<template>
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5 py-6">
    <h2 class="text-2xl font-semibold text-gray-900">{{ $t('Create Service') }}</h2>
    
    <!-- Form to create a new service -->
    <form @submit.prevent="createService" class="mt-6 space-y-6">
      <!-- Service Name -->
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">{{ $t('Service Name') }}</label>
        <input
          type="text"
          id="name"
          v-model="service.name"
          required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        />
      </div>

      <!-- Service Description -->
      <div>
        <label for="description" class="block text-sm font-medium text-gray-700">{{ $t('Description') }}</label>
        <textarea
          id="description"
          v-model="service.description"
          required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
        ></textarea>
      </div>

      <!-- Submit Button -->
      <div>
        <button type="submit" class="btn btn-blue">
          {{ $t('Create Service') }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "CreateService",
  data() {
    return {
      service: {
        name: '',
        description: '',
      },
    };
  },
  methods: {
    async createService() {
      try {
        // Send a POST request to create the new service
        const response = await axios.post('/api/dashboard/admin/services', this.service);
        this.$router.push('/dashboard/admin/services'); // Redirect to the service list page
        console.log(response.data); // Optionally log the response
      } catch (error) {
        console.error('Error creating service:', error);
        // Optionally show an error message to the user
      }
    },
  },
};
</script>
