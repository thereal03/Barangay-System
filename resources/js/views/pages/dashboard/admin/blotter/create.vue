<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
      <form @submit.prevent="createBlotter">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
          <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
              <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Create Blotter Report') }}</h1>
            </div>
          </div>
        </div>
  
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="mt-6 shadow sm:rounded-lg">
            <loading :status="loading" />
            <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
              <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Blotter details') }}</h3>
                <p class="mt-1 text-sm leading-5 text-gray-500">{{ $t('Enter the blotter details here.') }}</p>
              </div>
  
              <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="grid grid-cols-3 gap-6">
                  <!-- Complainant -->
                  <div class="col-span-3">
                    <label class="block text-sm font-medium leading-5 text-gray-700" for="complainant">{{ $t('Complainant') }}</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <input
                        id="complainant"
                        v-model="blotter.complainant"
                        :placeholder="$t('Complainant')"
                        class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        required
                      />
                    </div>
                  </div>
  
                  <!-- Respondent -->
                  <div class="col-span-3">
                    <label class="block text-sm font-medium leading-5 text-gray-700" for="respondent">{{ $t('Respondent') }}</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <input
                        id="respondent"
                        v-model="blotter.respondent"
                        :placeholder="$t('Respondent')"
                        class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        required
                      />
                    </div>
                  </div>
  
                  <!-- Incident Type -->
                  <div class="col-span-3">
                    <label class="block text-sm font-medium leading-5 text-gray-700" for="incident_type">{{ $t('Incident Type') }}</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <input
                        id="incident_type"
                        v-model="blotter.incident_type"
                        :placeholder="$t('Incident Type')"
                        class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        required
                      />
                    </div>
                  </div>
  
                  <!-- Incident Location -->
                  <div class="col-span-3">
                    <label class="block text-sm font-medium leading-5 text-gray-700" for="incident_location">{{ $t('Incident Location') }}</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <input
                        id="incident_location"
                        v-model="blotter.incident_location"
                        :placeholder="$t('Incident Location')"
                        class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        required
                      />
                    </div>
                  </div>
  
                  <!-- Incident Date -->
                  <div class="col-span-3">
                    <label class="block text-sm font-medium leading-5 text-gray-700" for="incident_date">{{ $t('Incident Date') }}</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <input
                        type="date"
                        id="incident_date"
                        v-model="blotter.incident_date"
                        class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        required
                      />
                    </div>
                  </div>
  
                  <!-- Status -->
                  <div class="col-span-3">
                    <label class="block text-sm font-medium leading-5 text-gray-700" for="status">{{ $t('Status') }}</label>
                    <select
                      id="status"
                      v-model="blotter.status"
                      class="form-select block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                      required
                    >
                      <option value="Pending">{{ $t('Pending') }}</option>
                      <option value="Resolved">{{ $t('Resolved') }}</option>
                      <option value="Dismissed">{{ $t('Dismissed') }}</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
  
            <!-- Form Actions -->
            <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
              <span class="inline-flex">
                <router-link
                  class="btn btn-secondary shadow-sm rounded-md mr-4"
                  to="/dashboard/admin/blotter"
                >
                  {{ $t('Cancel') }}
                </router-link>
                <button
                  class="btn btn-green shadow-sm rounded-md"
                  type="submit"
                >
                  {{ $t('Create Blotter') }}
                </button>
              </span>
            </div>
          </div>
        </div>
      </form>
    </main>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: "CreateBlotter",
    metaInfo() {
      return {
        title: this.$i18n.t('Create Blotter Report')
      };
    },
    data() {
      return {
        loading: false,
        blotter: {
          complainant: '',
          respondent: '',
          incident_type: '',
          incident_location: '',
          incident_date: '',
          status: 'Pending'
        },
      };
    },
    methods: {
      async createBlotter() {
        this.loading = true; // Show loading indicator
        try {
          const response = await axios.post('/api/dashboard/admin/blotter', this.blotter);
          this.loading = false;
          this.$notify({
            title: this.$i18n.t('Success'),
            text: this.$i18n.t('Blotter created successfully'),
            type: 'success'
          });
          this.$router.push('/dashboard/admin/blotter'); // Redirect after successful creation
        } catch (error) {
          this.loading = false;
          this.$notify({
            title: this.$i18n.t('Error'),
            text: this.$i18n.t('Failed to create blotter'),
            type: 'error'
          });
          console.error('There was an error creating the blotter:', error.response ? error.response.data : error);
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