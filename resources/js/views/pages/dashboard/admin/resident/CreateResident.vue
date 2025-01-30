<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
      <form @submit.prevent="saveResident">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
          <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
              <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Create Resident') }}</h1>
            </div>
          </div>
        </div>
  
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="mt-6 shadow sm:rounded-lg">
            <loading :status="loading" />
            <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
              <div class="md:col-span-1">
                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Resident details') }}</h3>
                <p class="mt-1 text-sm leading-5 text-gray-500">{{ $t('Enter the resident details here.') }}</p>
              </div>
  
              <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="grid grid-cols-3 gap-6">
                  <!-- First Name -->
                  <div class="col-span-3">
                    <label class="block text-sm font-medium leading-5 text-gray-700" for="first_name">{{ $t('First Name') }}</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <input
                        id="first_name"
                        v-model="resident.first_name"
                        :placeholder="$t('First Name')"
                        class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        required
                      />
                    </div>
                  </div>
  
                  <!-- Last Name -->
                  <div class="col-span-3">
                    <label class="block text-sm font-medium leading-5 text-gray-700" for="last_name">{{ $t('Last Name') }}</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <input
                        id="last_name"
                        v-model="resident.last_name"
                        :placeholder="$t('Last Name')"
                        class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        required
                      />
                    </div>
                  </div>
  
                  <!-- Date of Birth -->
                  <div class="col-span-3">
                    <label class="block text-sm font-medium leading-5 text-gray-700" for="dob">{{ $t('Date of Birth') }}</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <input
                        type="date"
                        id="dob"
                        v-model="resident.dob"
                        class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        required
                      />
                    </div>
                  </div>
  
                  <!-- Gender -->
                  <div class="col-span-3">
                    <label class="block text-sm font-medium leading-5 text-gray-700" for="gender">{{ $t('Gender') }}</label>
                    <select
                      id="gender"
                      v-model="resident.gender"
                      class="form-select block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                      required
                    >
                      <option value="male">{{ $t('Male') }}</option>
                      <option value="female">{{ $t('Female') }}</option>
                      <option value="other">{{ $t('Other') }}</option>
                    </select>
                  </div>
  
                  <!-- Address -->
                  <div class="col-span-3">
                    <label class="block text-sm font-medium leading-5 text-gray-700" for="address">{{ $t('Address') }}</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <textarea
                        id="address"
                        v-model="resident.address"
                        :placeholder="$t('Address')"
                        class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        required
                      ></textarea>
                    </div>
                  </div>
  
                  <!-- Contact Number -->
                  <div class="col-span-3">
                    <label class="block text-sm font-medium leading-5 text-gray-700" for="contact_number">{{ $t('Contact Number') }}</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <input
                        id="contact_number"
                        v-model="resident.contact_number"
                        :placeholder="$t('Contact Number')"
                        class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        required
                      />
                    </div>
                  </div>
  
                  <!-- Email -->
                  <div class="col-span-3">
                    <label class="block text-sm font-medium leading-5 text-gray-700" for="email">{{ $t('Email') }}</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <input
                        id="email"
                        type="email"
                        v-model="resident.email"
                        :placeholder="$t('Email')"
                        class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                        required
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
  
            <!-- Form Actions -->
            <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
              <span class="inline-flex">
                <router-link
                  class="btn btn-secondary shadow-sm rounded-md mr-4"
                  to="/dashboard/admin/resident"
                >
                  {{ $t('Cancel') }}
                </router-link>
                <button
                  class="btn btn-green shadow-sm rounded-md"
                  type="submit"
                >
                  {{ $t('Create Resident') }}
                </button>
              </span>
            </div>
          </div>
        </div>
      </form>
    </main>
  </template>
  
  <script>
  import flatpickr from 'flatpickr';
  import 'flatpickr/dist/flatpickr.css';
  import axios from 'axios'; // Make sure to import axios
  
  export default {
    name: "CreateResident",
    metaInfo() {
      return {
        title: this.$i18n.t('Create Resident')
      };
    },
    data() {
      return {
        loading: false,
        resident: {
          first_name: '',
          last_name: '',
          dob: '',
          gender: 'male',
          address: '',
          contact_number: '',
          email: ''
        },
      };
    },
    mounted() {
      flatpickr("#dob", {
        dateFormat: "d-m-Y",
        onChange: (selectedDates, dateStr, instance) => {
          this.resident.dob = dateStr;
        }
      });
    },
    methods: {
        saveResident() {
  this.loading = true; // Show loading indicator
  axios.post('api/dashboard/admin/resident', this.resident)
    .then(response => {
      this.loading = false;
      this.$notify({
        title: this.$i18n.t('Success'),
        text: this.$i18n.t('Resident created successfully'),
        type: 'success'
      });
      this.$router.push('/dashboard/admin/resident'); // Redirect after successful creation
    })
    .catch(error => {
      this.loading = false;
      this.$notify({
        title: this.$i18n.t('Error'),
        text: this.$i18n.t('Failed to create resident'),
        type: 'error'
      });
    });
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
  