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
          <tr
            v-for="ticket in ticketList"
            :key="ticket.uuid"
            class="cursor-pointer hover:bg-gray-100"
            @click="goToTicket(ticket.uuid)"
          >
            <td class="px-6 py-4 max-w-0 w-full whitespace-no-wrap">
              <div class="w-full truncate text-sm leading-5 text-gray-900">
                {{ ticket.subject }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap leading-5">
              <div class="text-sm text-gray-800">
                {{ formatDate(ticket.created_at) }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap leading-5">
              <div class="text-sm text-gray-800">
                {{ formatDate(ticket.updated_at) }}
              </div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap leading-5">
              <div class="text-sm text-gray-800">
                {{ ticket.status.name }}
              </div>
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

          <!-- Pagination Section -->
          <nav class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="hidden sm:block">
              <p v-if="pagination.total > 0" class="text-sm leading-5 text-gray-700">
                {{ $t('Showing') }}
                <span class="font-medium">{{ (pagination.perPage * pagination.currentPage) - pagination.perPage + 1 }}</span>
                {{ $t('to') }}
                <span class="font-medium">{{ pagination.perPage * pagination.currentPage <= pagination.total ? pagination.perPage * pagination.currentPage : pagination.total }}</span>
                {{ $t('of') }}
                <span class="font-medium">{{ pagination.total }}</span>
                {{ $t('results') }}
              </p>
              <p v-else class="text-sm leading-5 text-gray-700">
                {{ $t('No results found') }}
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
          <div class="mt-10 bg-gray-50 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $t('Latest News') }}</h2>
            <ul>
              <li
                v-for="article in articles"
                :key="article.link"
                class="mb-6 border-b border-gray-200 pb-4 last:border-none"
              >
                <a
                  :href="article.link"
                  target="_blank"
                  class="text-lg font-semibold text-blue-600 hover:underline"
                >
                  {{ article.title }}
                </a>
                <p class="mt-2 text-gray-700">
                  {{ article.description }}
                </p>
                <small class="block mt-1 text-sm text-gray-500">
                  {{ article.pubDate }}
                </small>
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
    this.fetchRSS();
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
      articles: [],
    };
  },
  computed: {
    anyFilter() {
      return this.filters.search !== '' || this.filters.status !== null
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
    fetchRSS() {
      axios.get('http://127.0.0.1:8000/api/rss')
        .then(response => {
          this.articles = response.data;
          this.loading = false;
        })
        .catch(error => {
          console.error('Error fetching RSS feed:', error);
          this.loading = false;
        });
    },
    getStatuses() {
      axios.get('api/tickets/statuses').then(response => {
        this.statusList = response.data;
      });
    },
    getTickets() {
      this.loading = true;
      axios.get('api/tickets', {
        params: {
          page: this.page,
          sort: this.sort,
          perPage: this.perPage,
          search: this.filters.search,
          status: this.filters.status,
        }
      }).then(response => {
        this.ticketList = response.data.items;
        this.pagination = response.data.pagination;
        if (this.pagination.totalPages < this.pagination.currentPage) {
          this.page = this.pagination.totalPages;
          this.getTickets();
        } else {
          this.loading = false;
        }
      }).catch(() => {
        this.loading = false;
      });
    },
    changePage(page) {
      if ((page > 0) && (page <= this.pagination.totalPages) && (page !== this.page)) {
        this.page = page;
        this.getTickets();
      }
    },
    changeSort() {
      this.sort.order = this.sort.order === 'asc' ? 'desc' : 'asc';
      this.getTickets();
    },
    goToTicket(uuid) {
      this.$router.push(`/tickets/${uuid}`);
    }
  }
}
</script>
