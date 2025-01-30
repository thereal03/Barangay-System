<template>
  <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
      <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
          <h1 class="py-0.5 text-3xl font-bold text-gray-900">{{ $t('Services') }}</h1>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
          <router-link
            class="px-5 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition duration-200"
            to="/dashboard/admin/services/new"
          >
            {{ $t('Create Service') }}
          </router-link>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="my-6">
        <loading :status="loading" />

        <template v-if="services.length > 0">
          <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div
              v-for="service in services"
              :key="service.id"
              class="bg-white p-5 rounded-lg shadow-md hover:shadow-lg transition-all duration-200"
            >
              <div class="flex justify-between items-center">
                <div>
                  <!-- Edit link updated here -->
                  <router-link
                    :to="`/dashboard/admin/services/${service.id}/edit`"
                    class="text-lg font-semibold text-gray-900 hover:text-blue-600"
                  >
                    {{ service.name }}
                  </router-link>
                  <p class="text-sm text-gray-600 mt-1">{{ service.description }}</p>
                </div>
                <button
                  @click="confirmDelete(service.id)"
                  class="p-2 text-red-600 hover:text-red-800 hover:bg-red-100 rounded-md transition duration-200"
                >
                  <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </template>

        <template v-else-if="!loading">
          <div class="flex flex-col items-center py-10">
            <svg-vue class="h-auto w-64 mb-6" icon="undraw.browsing" />
            <p class="text-xl font-semibold text-gray-700">{{ $t('No services found') }}</p>
          </div>
        </template>
      </div>
    </div>

    <!-- Enhanced Confirmation Modal -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm mx-auto">
        <h2 class="text-xl font-semibold text-gray-800">{{ $t('Are you sure you want to delete this service?') }}</h2>
        <div class="flex justify-between mt-4">
          <button
            @click="deleteService(deletingServiceId)"
            class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-lg shadow-lg hover:from-red-600 hover:to-red-700 focus:outline-none transition-all duration-300 transform hover:scale-105"
          >
            {{ $t('Yes') }}
          </button>
          <button
            @click="cancelDelete"
            class="px-6 py-3 bg-gradient-to-r from-gray-300 to-gray-400 text-gray-800 font-semibold rounded-lg shadow-lg hover:from-gray-400 hover:to-gray-500 focus:outline-none transition-all duration-300 transform hover:scale-105"
          >
            {{ $t('No') }}
          </button>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import axios from "axios";

export default {
  name: "ServiceList",
  metaInfo() {
    return {
      title: this.$i18n.t("Services"),
    };
  },
  data() {
    return {
      loading: true,
      services: [],
      showModal: false,
      deletingServiceId: null,
    };
  },
  mounted() {
    this.fetchServices();
  },
  methods: {
    async fetchServices() {
      try {
        const response = await axios.get("/api/dashboard/admin/services");
        this.services = response.data;
        this.loading = false;
      } catch (error) {
        this.loading = false;
        console.error(error);
      }
    },
    confirmDelete(serviceId) {
      this.deletingServiceId = serviceId;
      this.showModal = true;
    },
    cancelDelete() {
      this.showModal = false;
      this.deletingServiceId = null;
    },
    async deleteService(serviceId) {
      try {
        await axios.delete(`/api/dashboard/admin/services/${serviceId}`);
        this.services = this.services.filter((service) => service.id !== serviceId);
        this.showModal = false; // Close the modal
        this.deletingServiceId = null; // Reset deletingServiceId
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>

<style scoped>
/* Add some transition effects for smooth animations */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s ease;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>
