<template>
  <div class="py-10">
    <!-- Header Section -->
    <header>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
        <div class="md:flex md:items-center md:justify-between">
          <div class="flex-1 min-w-0">
            <h2 class="py-0.5 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
              {{ $t('Announcements') }}
            </h2>
          </div>
          <div class="mt-4 flex md:mt-0 md:ml-4">
            <router-link
              class="btn btn-blue shadow-sm rounded-md"
              to="/dashboard/admin/announcements/new"
            >
              {{ $t('Add Announcement') }}
            </router-link>
          </div>
        </div>
      </div>
    </header>
    <main>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mt-10 my-6 bg-white shadow overflow-hidden sm:rounded-md">
          <loading :status="loading"/>

          <!-- Announcements Table Section -->
          <template v-if="announcements.length > 0">
            <div class="-my-2 sm:-mx-6 lg:-mx-8">
              <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead>
                    <tr>
                      <th class="px-6 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                        {{ $t('Title') }}
                      </th>
                      <th class="px-6 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                        {{ $t('Description') }}
                      </th>
                      <th class="px-6 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                        {{ $t('Date') }}
                      </th>
                      <th class="px-6 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                        {{ $t('Link') }}
                      </th>
                      <th class="px-6 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                        {{ $t('Actions') }}
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-100">
                    <tr
                      v-for="announcement in announcements"
                      :key="announcement.id"
                      class="cursor-pointer hover:bg-gray-100"
                    >
                      <td class="px-6 py-4 max-w-0 w-full whitespace-no-wrap">
                        <div class="w-full truncate text-sm leading-5 text-gray-900">
                          {{ announcement.title }}
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap leading-5">
                        <div class="text-sm text-gray-800">
                          {{ announcement.description }}
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap leading-5">
                        <div class="text-sm text-gray-800">
                          {{ formatDate(announcement.date) }}
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap leading-5">
                        <div class="text-sm text-gray-800">
                          <a :href="announcement.link" target="_blank" class="text-blue-600 hover:underline">
                            {{ announcement.link }}
                          </a>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-no-wrap leading-5">
                        <button
                          class="text-red-600 hover:text-red-900"
                          @click="deleteAnnouncement(announcement.id)"
                        >
                          {{ $t('Delete') }}
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </template>

          <!-- No Results Found Section -->
          <template v-else-if="!loading">
            <div class="h-full flex">
              <div class="m-auto">
                <div class="grid grid-cols-1 justify-items-center h-full w-full py-24">
                  <div class="flex justify-center items-center">
                    <svg-vue class="h-full h-auto w-48 mb-6" icon="undraw.task-list"></svg-vue>
                  </div>
                  <div class="flex justify-center items-center">
                    <div class="w-full font-semibold text-2xl">{{ $t('No records found') }}</div>
                  </div>
                  <template v-if="anyFilter">
                    <div class="flex justify-center items-center">
                      <div>{{ $t('Try changing the filters, or rephrasing your search') }}.</div>
                    </div>
                  </template>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "AnnouncementList",
  data() {
    return {
      loading: true,
      announcements: []
    };
  },
  mounted() {
    this.loadAnnouncements();
  },
  computed: {
    anyFilter() {
      // Define anyFilter computed property if needed
      return false;
    }
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: true
      }); // Example format: "January 25, 2025, 11:55:18 AM"
    },
    loadAnnouncements() {
      // Load announcements from a local source or API
      axios.get('/api/announcements').then(response => {
        this.announcements = response.data;
        this.loading = false;
      }).catch(() => {
        this.loading = false;
      });
    },
    deleteAnnouncement(id) {
      if (confirm(this.$t('Are you sure you want to delete this announcement?'))) {
        axios.delete(`/api/announcements/${id}`).then(() => {
          this.loadAnnouncements();
        }).catch(error => {
          console.error("There was an error deleting the announcement:", error);
        });
      }
    }
  }
}
</script>