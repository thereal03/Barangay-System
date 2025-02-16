<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
        <div class="md:flex md:items-center md:justify-between">
          <div class="flex-1 min-w-0">
            <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Edit Resident') }}</h1>
          </div>
          <div class="mt-4 flex md:mt-0 md:ml-4">
            <router-link
              class="btn btn-blue shadow-sm rounded-md"
              to="/dashboard/admin/resident"
            >
              {{ $t('Back to Residents List') }}
            </router-link>
          </div>
        </div>
      </div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
          <loading :status="loading"/>
          <form @submit.prevent="updateResident">
            <div class="px-4 py-4 sm:px-6">
              <!-- First Name -->
              <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700">{{ $t('First Name') }}</label>
                <input
                  type="text"
                  id="first_name"
                  v-model="form.first_name"
                  class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                  required
                />
              </div>
              <!-- Last Name -->
              <div class="mt-4">
                <label for="last_name" class="block text-sm font-medium text-gray-700">{{ $t('Last Name') }}</label>
                <input
                  type="text"
                  id="last_name"
                  v-model="form.last_name"
                  class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                  required
                />
              </div>
              <!-- Date of Birth -->
              <div class="mt-4">
                <label for="dob" class="block text-sm font-medium text-gray-700">{{ $t('Date of Birth') }}</label>
                <input
                  type="date"
                  id="dob"
                  v-model="form.dob"
                  class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                />
              </div>
              <!-- Gender -->
              <div class="mt-4">
                <label for="gender" class="block text-sm font-medium text-gray-700">{{ $t('Gender') }}</label>
                <select
                  id="gender"
                  v-model="form.gender"
                  class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                >
                  <option value="male">{{ $t('Male') }}</option>
                  <option value="female">{{ $t('Female') }}</option>
                  <option value="other">{{ $t('Other') }}</option>
                </select>
              </div>
              <!-- Address -->
              <div class="mt-4">
                <label for="address" class="block text-sm font-medium text-gray-700">{{ $t('Address') }}</label>
                <input
                  type="text"
                  id="address"
                  v-model="form.address"
                  class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                />
              </div>
              <!-- Contact Number -->
              <div class="mt-4">
                <label for="contact_number" class="block text-sm font-medium text-gray-700">{{ $t('Contact Number') }}</label>
                <input
                  type="text"
                  id="contact_number"
                  v-model="form.contact_number"
                  class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                />
              </div>
              <!-- Email -->
              <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ $t('Email') }}</label>
                <input
                  type="email"
                  id="email"
                  v-model="form.email"
                  class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                />
              </div>
              <!-- Created At -->
              <div class="mt-4">
                <label for="created_at" class="block text-sm font-medium text-gray-700">{{ $t('Created At') }}</label>
                <input
                  type="text"
                  id="created_at"
                  v-model="form.created_at"
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
                  v-model="form.updated_at"
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
                {{ $t('Update Resident') }}
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
    name: "EditResident",
    data() {
      return {
        loading: true,
        form: {
          first_name: '',
          last_name: '',
          dob: '',
          gender: '',
          address: '',
          contact_number: '',
          email: '',
          created_at: '',
          updated_at: ''
        }
      };
    },
    mounted() {
      this.getResident();
    },
    methods: {
      getResident() {
        const residentId = this.$route.params.id;
        axios.get(`api/dashboard/admin/resident/${residentId}`).then(response => {
          this.form = response.data;
          this.loading = false;
        }).catch(error => {
          console.error(error);
          this.loading = false;
        });
      },
      updateResident() {
        this.loading = true;
        const residentId = this.$route.params.id;
        this.form.updated_at = this.formatDate(new Date()); // Set updated_at to current date and time
        axios.put(`api/dashboard/admin/resident/${residentId}`, this.form)
          .then(response => {
            this.$router.push('/dashboard/admin/resident');
          })
          .catch(error => {
            console.error(error);
            this.loading = false;
          });
      },
      formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
      }
    }
  };
  </script>
  
  <style scoped>
  /* Container */
  .container {
    max-width: 100%;
    padding: 16px;
  }
  
  /* Header */
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
  }
  
  h1 {
    font-size: 20px;
    font-weight: bold;
  }
  
  .add-btn {
    background-color: #2563eb;
    color: white;
    padding: 8px 12px;
    border-radius: 5px;
    text-decoration: none;
  }
  
  .add-btn:hover {
    background-color: #1d4ed8;
  }
  
  /* Table */
  .table-container {
    width: 100%;
    overflow-x: auto;
  }
  
  .table-wrapper {
    width: 100%;
    overflow-x: auto;
    position: relative;
    max-height: 500px;
  }
  
  /* Fixed Header */
  thead {
    position: sticky;
    top: 0;
    background: white;
    z-index: 5;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }
  
  /* Table Styling */
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    padding: 8px;
    text-align: left;
    border: 1px solid #ddd;
    white-space: nowrap;
  }
  
  /* Adjust column width for small screens */
  @media (max-width: 1024px) {
    table {
      min-width: 1000px;
    }
  }
  
  @media (max-width: 768px) {
    table {
      min-width: 900px;
    }
  }
  
  /* Mobile-friendly */
  @media (max-width: 480px) {
    table {
      min-width: 800px;
    }
  
    th, td {
      padding: 6px;
      font-size: 12px;
    }
  }
  
  /* Ensure "Actions" column is always visible */
  .actions {
    min-width: 140px;
    text-align: center;
  }
  
  /* Action Buttons */
  .edit-btn, .delete-btn {
    padding: 6px 10px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 12px;
    margin: 2px;
    display: inline-block;
  }
  
  .edit-btn {
    background-color: #facc15;
    color: white;
  }
  
  .delete-btn {
    background-color: #dc2626;
    color: white;
    border: none;
    cursor: pointer;
  }
  
  .edit-btn:hover {
    background-color: #eab308;
  }
  
  .delete-btn:hover {
    background-color: #b91c1c;
  }
  </style>