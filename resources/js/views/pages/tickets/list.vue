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
        <!-- Password Expiry Timer Section -->
        <div v-if="isDefaultPassword" class="mt-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
          <p class="font-bold">{{ $t('Password Expiry Notice') }}</p>
          <p>{{ $t('Your password will expire in') }}: {{ timeLeft }}</p>
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
                <div class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                      <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                          {{ $t('Subject') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                          {{ $t('Created at') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                          {{ $t('Updated at') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                          {{ $t('Status') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                          {{ $t('Service') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                          {{ $t('Needed By') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                          {{ $t('Time Left') }}
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
                        <td class="px-6 py-4 whitespace-no-wrap leading-5">
                          <div class="text-sm text-gray-800">
                            {{ ticket.service ? ticket.service.name : '' }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap leading-5">
                          <div class="text-sm text-gray-800">
                            {{ formatDate(ticket.needed_by, { onlyDate: true }) }}
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap leading-5">
                          <div class="text-sm text-gray-800">
                            {{ getTimeLeft(ticket.created_at, ticket.service.expiration_days) }}
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
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

          <!-- Barangay Announcement Section -->
          <div class="mt-10 bg-gray-50 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $t('Barangay Announcement') }}</h2>
            <ul>
              <li
                v-for="announcement in announcements"
                :key="announcement.id"
                class="mb-6 border-b border-gray-200 pb-4 last:border-none"
              >
                <a
                  :href="announcement.link"
                  target="_blank"
                  class="text-lg font-semibold text-blue-600 hover:underline"
                >
                  {{ announcement.title }}
                </a>
                <p class="mt-2 text-gray-700">
                  {{ announcement.description }}
                </p>
                <small class="block mt-1 text-sm text-gray-500">
                  {{ formatDate(announcement.date) }}
                </small>
              </li>
            </ul>
          </div>
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
    this.loadAnnouncements();
    this.checkDefaultPassword(); // Check if the user is using a default password
    this.startCountdown(); // Start the countdown timer
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
      announcements: [],
      articles: [], // Add this line
      isDefaultPassword: false, // Add this line
      passwordExpiresAt: null, // Add this line
      timeLeft: '' // Add this line
    };
  },
  computed: {
    anyFilter() {
      return this.filters.search !== '' || this.filters.status !== null
    }
  },
  methods: {
    formatDate(date, options = { onlyDate: false }) {
      const formatOptions = options.onlyDate
        ? { year: 'numeric', month: 'long', day: 'numeric' }
        : {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            hour12: true
          };
      return new Date(date).toLocaleString('en-US', formatOptions);
    },
    calculateExpiryDate(createdAt, expirationDays) {
      const createdDate = new Date(createdAt);
      return new Date(createdDate.getTime() + expirationDays * 24 * 60 * 60 * 1000); // expiration_days for other services
    },
    getTimeLeft(createdAt, expirationDays) {
      const expiryDate = this.calculateExpiryDate(createdAt, expirationDays);
      const now = new Date();
      const timeLeft = expiryDate - now;

      if (timeLeft <= 0) {
        return this.$t('Expired');
      }

      const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
      const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

      return `${days}d ${hours}h ${minutes}m ${seconds}s`;
    },
    startCountdown() {
      setInterval(() => {
        this.getTimeLeftForPassword(); // Update the password expiry countdown
        this.ticketList = [...this.ticketList]; // Trigger reactivity for tickets
      }, 1000);
    },
    getTimeLeftForPassword() {
      if (!this.passwordExpiresAt) {
        this.timeLeft = this.$t('No expiration');
        return;
      }

      const expiryDate = new Date(this.passwordExpiresAt);
      const now = new Date();
      const timeLeft = expiryDate - now;

      if (timeLeft <= 0) {
        this.timeLeft = this.$t('Expired');
        return;
      }

      const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
      const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

      this.timeLeft = `${days}d ${hours}h ${minutes}m ${seconds}s`;
    },
    checkDefaultPassword() {
      axios.get('api/users/me').then(response => {
        const user = response.data.user;

        // Use the is_default_password flag from the API response
        this.isDefaultPassword = response.data.is_default_password;
        this.passwordExpiresAt = user.password_expires_at || null;

        // Debugging: Log the response
        console.log('User data:', user);
        console.log('Is default password:', this.isDefaultPassword);
        console.log('Password expires at:', this.passwordExpiresAt);

        // Debugging: Check if the timer section should render
        if (this.isDefaultPassword) {
          console.log('Timer section should render.');
        } else {
          console.log('Timer section should NOT render.');
        }
      }).catch(error => {
        console.error('Error fetching user data:', error);
      });
    },
    loadAnnouncements() {
      // Fetch announcements from the API
      axios.get('api/announcements').then(response => {
        this.announcements = response.data;
        this.loading = false;
      }).catch(() => {
        this.loading = false;
      });
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
          this.checkExpiredTickets(); // Check for expired tickets after loading
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
    },
    checkExpiredTickets() {
      const now = new Date();
      this.ticketList.forEach(ticket => {
        const expiryDate = this.calculateExpiryDate(ticket.created_at, ticket.service.expiration_days);
        console.log(`Checking ticket ${ticket.uuid}: expiryDate = ${expiryDate}, now = ${now}`);
        if (expiryDate < now) {
          console.log(`Deleting expired ticket ${ticket.uuid}`);
          this.deleteTicket(ticket.uuid);
        }
      });
    },
    deleteTicket(uuid) {
      axios.delete(`api/tickets/${uuid}`).then(() => {
        this.ticketList = this.ticketList.filter(ticket => ticket.uuid !== uuid);
        console.log(`Ticket ${uuid} deleted`);
      }).catch(error => {
        console.error('Error deleting ticket:', error);
      });
    }
  }
}
</script>

<style scoped>
.table-container {
  width: 100%;
  overflow-x: auto;
}
</style>