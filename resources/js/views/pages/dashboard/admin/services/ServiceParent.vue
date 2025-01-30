<template>
  <div class="service-list-container">
    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Services') }}</h1>
    <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
      <loading :status="loading" />
      <template v-if="services.length > 0">
        <ul>
          <li v-for="(service, index) in services" :key="service.id" :class="{'border-t border-gray-200': index !== 0}">
            <!-- Pass service as prop to ServiceItem -->
            <ServiceItem :service="service" @delete="deleteService" />
          </li>
        </ul>
      </template>
      <template v-else-if="!loading">
        <div class="h-full flex">
          <div class="m-auto">
            <div class="grid grid-cols-1 justify-items-center h-full w-full px-4 py-10">
              <div class="flex justify-center items-center">
                <svg-vue class="h-full h-auto w-64 mb-12" icon="undraw.browsing" />
              </div>
              <div class="flex justify-center items-center">
                <div class="w-full font-semibold text-2xl">{{ $t('No services found') }}</div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import ServiceItem from './ServiceItem.vue';

export default {
  name: "ServiceParent",
  components: {
    ServiceItem
  },
  data() {
    return {
      loading: true,
      services: [],
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
    async deleteService(serviceId) {
      try {
        await axios.delete(`/api/dashboard/admin/services/${serviceId}`);
        this.services = this.services.filter(service => service.id !== serviceId);
      } catch (error) {
        console.error(error);
      }
    }
  }
};
</script>
