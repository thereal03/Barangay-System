<template>
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5 py-6">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-semibold text-gray-800">{{ $t('Residents List') }}</h1>
      <router-link
        class="bg-blue-600 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-700 transition"
        to="/dashboard/admin/resident/create"
      >
        {{ $t('Add New Resident') }}
      </router-link>
    </div>
    <div class="my-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase border-b">{{ $t('ID') }}</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase border-b">{{ $t('First Name') }}</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase border-b">{{ $t('Last Name') }}</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase border-b">{{ $t('DOB') }}</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase border-b">{{ $t('Gender') }}</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase border-b">{{ $t('Address') }}</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase border-b">{{ $t('Contact') }}</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase border-b">{{ $t('Email') }}</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase border-b">{{ $t('Created At') }}</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase border-b">{{ $t('Updated At') }}</th>
              <th class="px-4 py-3 text-center text-xs font-medium text-gray-600 uppercase border-b">{{ $t('Actions') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="resident in resident" :key="resident.id" class="border-b hover:bg-gray-50 transition">
              <td class="px-4 py-3">{{ resident.id }}</td>
              <td class="px-4 py-3">{{ resident.first_name }}</td>
              <td class="px-4 py-3">{{ resident.last_name }}</td>
              <td class="px-4 py-3">{{ resident.dob || 'N/A' }}</td>
              <td class="px-4 py-3">{{ resident.gender }}</td>
              <td class="px-4 py-3">{{ resident.address }}</td>
              <td class="px-4 py-3">{{ resident.contact_number }}</td>
              <td class="px-4 py-3">{{ resident.email }}</td>
              <td class="px-4 py-3">{{ resident.created_at || 'N/A' }}</td>
              <td class="px-4 py-3">{{ resident.updated_at || 'N/A' }}</td>
              <td class="px-4 py-3 flex justify-center space-x-2">
                <router-link 
                  :to="'/dashboard/admin/resident/' + resident.id + '/edit'" 
                  class="bg-yellow-500 text-white px-3 py-1 rounded-md shadow-sm hover:bg-yellow-600 transition"
                >
                  {{ $t('Edit') }}
                </router-link>
                <button 
                  @click="deleteResident(resident.id)" 
                  class="bg-red-500 text-white px-3 py-1 rounded-md shadow-sm hover:bg-red-600 transition"
                >
                  {{ $t('Delete') }}
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
      return {
          resident: []
      };
  },
  mounted() {
      this.getResident();
  },
  methods: {
      getResident() {
          axios.get('api/dashboard/admin/resident')
              .then(response => {
                  this.resident = response.data;
              })
              .catch(error => {
                  console.error(error);
              });
      },
      deleteResident(id) {
          if (confirm("Are you sure you want to delete this resident?")) {
              axios.delete(`api/dashboard/admin/resident/${id}`)
                  .then(response => {
                      this.getResident(); // Refresh the list
                  })
                  .catch(error => {
                      console.error(error);
                  });
          }
      }
  }
}
</script>
