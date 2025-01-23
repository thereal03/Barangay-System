<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RSSController extends Controller
{
    public function fetchRSS()
    {
        // Updated RSS Feed URL for Philstar
        $rssUrl = 'https://www.philstar.com/rss/headlines';

        // Use file_get_contents to fetch the RSS content
        $rssContent = file_get_contents($rssUrl);

        // Check if the content is empty or not
        if ($rssContent === false) {
            return response()->json(['error' => 'Failed to fetch RSS feed.'], 500);
        }

        // Parse the RSS content
        try {
            $rss = simplexml_load_string($rssContent, 'SimpleXMLElement', LIBXML_NOCDATA);
            if ($rss === false) {
                return response()->json(['error' => 'Invalid RSS feed format.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error loading RSS feed.'], 500);
        }

        // Register the namespaces to properly parse the feed
        $rss->registerXPathNamespace('dc', 'http://purl.org/dc/elements/1.1/');
        $rss->registerXPathNamespace('content', 'http://purl.org/rss/1.0/modules/content/');

        // Parse the feed and extract the articles
        $articles = [];
        foreach ($rss->channel->item as $item) {
            $articles[] = [
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'description' => (string) $item->description,
                'pubDate' => (string) $item->pubDate,
                'content' => (string) $item->children('content', true)->encoded, // Extract content from the 'content' namespace
            ];
        }

        // Return as JSON
        return response()->json($articles);
    }
}
