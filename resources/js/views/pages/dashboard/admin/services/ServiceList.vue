<template>
  <div>
    <h2>Services</h2>
    <div v-if="services.length">
      <div v-for="service in services" :key="service.id" class="service-item">
        <service-item :service="service" @delete="deleteService" />
      </div>
    </div>
    <div v-else>No services found.</div>
  </div>
</template>

<script>
import axios from "axios";
import ServiceItem from "./ServiceItem.vue";

export default {
  components: {
    ServiceItem
  },
  data() {
    return {
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
      } catch (error) {
        console.error(error);
      }
    },
    async deleteService(serviceId) {
      try {
        await axios.delete(`/api/dashboard/admin/services/${serviceId}`);
        // Filter the deleted service out of the list
        this.services = this.services.filter(service => service.id !== serviceId);
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>
