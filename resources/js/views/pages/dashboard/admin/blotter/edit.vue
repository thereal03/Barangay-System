<template>
  <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
      <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
          <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Edit Blotter Report') }}</h1>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
          <router-link
            class="btn btn-blue shadow-sm rounded-md"
            to="/dashboard/admin/blotter"
          >
            {{ $t('Back to Blotter List') }}
          </router-link>
        </div>
      </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
        <loading :status="loading"/>
        <form @submit.prevent="updateBlotter">
          <div class="px-4 py-4 sm:px-6">
            <!-- Complainant -->
            <div>
              <label for="complainant" class="block text-sm font-medium text-gray-700">{{ $t('Complainant') }}</label>
              <input
                type="text"
                id="complainant"
                v-model="blotter.complainant"
                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                required
              />
            </div>
            <!-- Respondent -->
            <div class="mt-4">
              <label for="respondent" class="block text-sm font-medium text-gray-700">{{ $t('Respondent') }}</label>
              <input
                type="text"
                id="respondent"
                v-model="blotter.respondent"
                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                required
              />
            </div>
            <!-- Incident Type -->
            <div class="mt-4">
              <label for="incident_type" class="block text-sm font-medium text-gray-700">{{ $t('Incident Type') }}</label>
              <input
                type="text"
                id="incident_type"
                v-model="blotter.incident_type"
                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                required
              />
            </div>
            <!-- Incident Location -->
            <div class="mt-4">
              <label for="incident_location" class="block text-sm font-medium text-gray-700">{{ $t('Incident Location') }}</label>
              <input
                type="text"
                id="incident_location"
                v-model="blotter.incident_location"
                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                required
              />
            </div>
            <!-- Incident Date -->
            <div class="mt-4">
              <label for="incident_date" class="block text-sm font-medium text-gray-700">{{ $t('Incident Date') }}</label>
              <input
                type="datetime-local"
                id="incident_date"
                v-model="blotter.incident_date"
                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                required
              />
            </div>
            <!-- Status -->
            <div class="mt-4">
              <label for="status" class="block text-sm font-medium text-gray-700">{{ $t('Status') }}</label>
              <select
                id="status"
                v-model="blotter.status"
                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                required
              >
                <option value="Pending">{{ $t('Pending') }}</option>
                <option value="Resolved">{{ $t('Resolved') }}</option>
                <option value="Dismissed">{{ $t('Dismissed') }}</option>
              </select>
            </div>
            <!-- Created At -->
            <div class="mt-4">
              <label for="created_at" class="block text-sm font-medium text-gray-700">{{ $t('Created At') }}</label>
              <input
                type="text"
                id="created_at"
                v-model="blotter.created_at"
                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                disabled
              />
            </div>
            <!-- Updated At -->
            <div class="mt-4">
              <label for="updated_at" class="block text-sm font-medium text-gray-700">{{ $t('Updated At') }}</label>
              <input
                type="text"
                id="updated_at"
                v-model="blotter.updated_at"
                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                disabled
              />
            </div>
          </div>
          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <button
              type="submit"
              class="btn btn-blue shadow-sm rounded-md"
              :disabled="loading"
            >
              {{ $t('Update Blotter') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</template>

<script>
import axios from 'axios';

export default {
  name: "EditBlotter",
  data() {
    return {
      loading: true,
      blotter: {
        complainant: '',
        respondent: '',
        incident_type: '',
        incident_location: '',
        incident_date: '',
        status: '',
        created_at: '',
        updated_at: ''
      }
    };
  },
  async mounted() {
    await this.getBlotter();
  },
  methods: {
    async getBlotter() {
      try {
        const response = await axios.get(`/api/dashboard/admin/blotter/${this.$route.params.id}`);
        this.blotter = response.data;
        this.loading = false;
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },
    async updateBlotter() {
      this.loading = true;
      try {
        this.blotter.updated_at = new Date().toISOString(); // Set updated_at to current date and time
        await axios.put(`/api/dashboard/admin/blotter/${this.$route.params.id}`, this.blotter);
        this.$router.push('/dashboard/admin/blotter');
      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
/* Add your custom styles here */
.form-group {
  margin-bottom: 1rem;
}

.form-control {
  width: 100%;
  padding: 0.5rem;
  font-size: 1rem;
}

.form-actions {
  margin-top: 1rem;
}

.btn {
  padding: 0.5rem 1rem;
  font-size: 1rem;
}
</style>