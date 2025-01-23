<template>
  <div class="py-10">
    <!-- Header Section -->
    <header>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
        <div class="md:flex md:items-center md:justify-between">
          <div class="flex-1 min-w-0">
            <h2 class="py-0.5 text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
              {{ $t('My tickets') }}
            </h2>
          </div>
          <div class="mt-4 flex md:mt-0 md:ml-4">
            <router-link
              class="btn btn-blue shadow-sm rounded-md"
              to="/tickets/new"
            >
              {{ $t('New ticket') }}
            </router-link>
          </div>
        </div>
      </div>
    </header>
    <main>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mt-10 my-6 bg-white shadow overflow-hidden sm:rounded-md">
          <loading :status="loading"/>

          <!-- Ticket Table Section -->
          <template v-if="ticketList.length > 0">
            <div class="-my-2 sm:-mx-6 lg:-mx-8">
              <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead>
                    <tr>
                      <th class="px-6 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                        {{ $t('Subject') }}
                      </th>
                      <th class="px-6 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                        {{ $t('Created at') }}
                      </th>
                      <th class="px-6 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                        {{ $t('Updated at') }}
                      </th>
                      <th class="px-6 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                        {{ $t('Status') }}
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-100">
                    <template v-for="ticket in ticketList">
                      <router-link
                        :to="'/tickets/' + ticket.uuid"
                        class="cursor-pointer hover:bg-gray-100 p"
                        tag="tr"
                      >
                        <td class="px-6 py-4 max-w-0 w-full whitespace-no-wrap">
                          <div class="w-full truncate text-sm leading-5 text-gray-900">
                            {{ ticket.subject }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap leading-5">
                          <div class="text-sm text-gray-800">
                            {{ ticket.created_at | momentFormatDate }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap leading-5">
                          <div class="text-sm text-gray-800">
                            {{ ticket.updated_at | momentFormatDateTimeAgo }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap leading-5">
                          <div class="text-sm text-gray-800">
                            {{ ticket.status.name }}
                          </div>
                        </td>
                      </router-link>
                    </template>
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

          <!-- Pagination Section -->
          <nav class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="hidden sm:block">
              <p class="text-sm leading-5 text-gray-700">
                {{ $t('Showing') }}
                <span class="font-medium">{{ (pagination.perPage * pagination.currentPage) - pagination.perPage + 1 }}</span>
                {{ $t('to') }}
                <span class="font-medium">{{ pagination.perPage * pagination.currentPage <= pagination.total ? pagination.perPage * pagination.currentPage : pagination.total }}</span>
                {{ $t('of') }}
                <span class="font-medium">{{ pagination.total }}</span>
                {{ $t('results') }}
              </p>
            </div>
            <div class="flex-1 flex justify-between sm:justify-end">
              <button
                :class="pagination.currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : ''"
                :disabled="pagination.currentPage <= 1"
                class="pagination-link"
                type="button"
                @click="changePage(pagination.currentPage - 1)"
              >
                {{ $t('Previous') }}
              </button>
              <button
                :class="pagination.currentPage >= pagination.totalPages ? 'opacity-50 cursor-not-allowed' : ''"
                :disabled="pagination.currentPage >= pagination.totalPages"
                class="ml-3 pagination-link"
                type="button"
                @click="changePage(pagination.currentPage + 1)"
              >
                {{ $t('Next') }}
              </button>
            </div>
          </nav>

          <!-- Latest News Section -->
          <div class="mt-10">
            <h2 class="text-2xl font-bold">{{ $t('Latest News') }}</h2>
            <ul>
              <li v-for="article in articles" :key="article.link" class="my-4">
                <a :href="article.link" target="_blank" class="text-blue-500 hover:underline">{{ article.title }}</a>
                <p class="text-gray-700">{{ article.description }}</p>
                <small class="text-gray-500">{{ article.pubDate }}</small>
              </li>
            </ul>
          </div>

        </div>
      </div>
    </main>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "index",
  metaInfo() {
    return {
      title: this.$i18n.t('My tickets')
    }
  },
  mounted() {
    this.getStatuses();
    this.getTickets();
    this.fetchRSS();  // Fetch RSS when the component is mounted
  },
  data() {
    return {
      loading: true,
      ticketList: [],
      statusList: [],
      filters: {
        search: '',
        status: null,
      },
      sort: {
        order: 'desc',
        column: 'updated_at',
      },
      page: 1,
      perPage: 10,
      pagination: {
        currentPage: 0,
        perPage: 0,
        total: 0,
        totalPages: 0
      },
      articles: [],  // Store the fetched RSS articles
    };
  },
  computed: {
    anyFilter() {
      return this.filters.search !== '' || this.filters.status !== null
    }
  },
  methods: {
    // Fetch the RSS feed from your local API endpoint
    fetchRSS() {
      axios.get('http://127.0.0.1:8000/api/rss')  // Make sure this points to your API
        .then(response => {
          // Assuming the response returns a structured array of articles
          this.articles = response.data;  // Adjust based on your API response structure
          this.loading = false;
        })
        .catch(error => {
          console.error('Error fetching RSS feed:', error);
          this.loading = false;
        });
    },

    // Get the ticket statuses
    getStatuses() {
      const self = this;
      axios.get('api/tickets/statuses').then(function (response) {
        self.statusList = response.data;
      });
    },

    // Get tickets
    getTickets() {
      const self = this;
      self.loading = true;
      axios.get('api/tickets', {
        params: {
          page: self.page,
          sort: self.sort,
          perPage: self.perPage,
          search: self.filters.search,
          status: self.filters.status,
        }
      }).then(function (response) {
        self.ticketList = response.data.items;
        self.pagination = response.data.pagination;
        if (self.pagination.totalPages < self.pagination.currentPage) {
          self.page = self.pagination.totalPages;
          self.getTickets();
        } else {
          self.loading = false;
        }
      }).catch(function () {
        self.loading = false;
      });
    },

    // Change page for pagination
    changePage(page) {
      const self = this;
      if ((page > 0) && (page <= self.pagination.totalPages) && (page !== self.page)) {
        self.page = page;
        self.getTickets();
      }
    },

    // Change sorting
    changeSort() {
      const self = this;
      self.sort.order = self.sort.order === 'asc' ? 'desc' : 'asc';
      self.getTickets();
    },
  }
}
</script>
