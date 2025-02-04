<template>
  <div class="max-w-3xl mx-auto px-6 py-8">
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
      <!-- Title -->
      <div class="flex items-center justify-between border-b pb-3 mb-4">
        <h2 class="text-2xl font-bold text-gray-900">{{ $t('Create Service') }}</h2>
      </div>

      <p class="text-gray-600 mb-6">{{ $t('Fill in the details below to create a new service.') }}</p>

      <!-- Alert Messages -->
      <div v-if="message" :class="messageType" class="mt-4 p-3 rounded-md text-sm">
        {{ message }}
      </div>

      <!-- Form -->
      <form @submit.prevent="createService" class="space-y-5">
        <!-- Service Name -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">{{ $t('Service Name') }}</label>
          <input
            type="text"
            id="name"
            v-model="service.name"
            required
            class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
            :class="{ 'border-red-500': errors.name }"
          />
          <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name }}</p>
        </div>

        <!-- Service Description -->
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700">{{ $t('Description') }}</label>
          <textarea
            id="description"
            v-model="service.description"
            required
            rows="4"
            class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
            :class="{ 'border-red-500': errors.description }"
          ></textarea>
          <p v-if="errors.description" class="text-red-500 text-xs mt-1">{{ errors.description }}</p>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-4 mt-4">
          <!-- Cancel Button -->
          <router-link
            to="/dashboard/admin/services"
            class="px-4 py-2 border rounded-md text-gray-600 bg-gray-100 hover:bg-gray-200 transition duration-200 shadow-sm"
          >
            {{ $t('Cancel') }}
          </router-link>

          <!-- Submit Button -->
          <button
            type="submit"
            class="px-5 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md transition duration-200 shadow-sm flex items-center"
            :disabled="loading"
          >
            <span v-if="loading" class="animate-spin mr-2">🔄</span>
            {{ loading ? $t('Creating...') : $t('Create Service') }}
          </button>
        </div>
      </form>
    </div>
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
      loading: false,
      message: '',
      messageType: '',
      errors: {},
    };
  },
  methods: {
    async createService() {
      this.loading = true;
      this.message = '';
      this.errors = {}; // Clear previous errors

      try {
        // Make the API call
        await axios.post('/api/dashboard/admin/services', this.service);

        // Redirect immediately after the API call is initiated
        this.$router.push('/dashboard/admin/services');
      } catch (error) {
        console.error('Error creating service:', error);

        // Handle validation errors
        if (error.response && error.response.data.errors) {
          this.errors = error.response.data.errors;
        } else {
          this.message = this.$t('Failed to create service. Please try again.');
          this.messageType = 'bg-red-100 text-red-700 p-3 rounded-md';
        }
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>