<template>
  <div class="container">
    <div class="header">
      <h1>{{ $t('Residents List') }}</h1>
      <router-link to="/dashboard/admin/resident/create" class="add-btn">
        {{ $t('Add New Resident') }}
      </router-link>
    </div>

    <div class="table-container">
      <div class="table-wrapper">
        <table>
          <thead>
            <tr>
              <th v-for="header in headers" :key="header">{{ $t(header) }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="resident in resident" :key="resident.id">
              <td>{{ resident.id }}</td>
              <td>{{ resident.first_name }}</td>
              <td>{{ resident.last_name }}</td>
              <td>{{ resident.dob || 'N/A' }}</td>
              <td>{{ resident.gender }}</td>
              <td>{{ resident.address }}</td>
              <td>{{ resident.contact_number }}</td>
              <td>{{ resident.email }}</td>
              <td>{{ resident.created_at || 'N/A' }}</td>
              <td>{{ resident.updated_at || 'N/A' }}</td>
              <td class="actions">
                <router-link :to="'/dashboard/admin/resident/' + resident.id + '/edit'" class="edit-btn">
                  {{ $t('Edit') }}
                </router-link>
                <button @click="deleteResident(resident.id)" class="delete-btn">
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
      resident: [],
      headers: ['ID', 'First Name', 'Last Name', 'DOB', 'Gender', 'Address', 'Contact', 'Email', 'Created At', 'Updated At', 'Actions'],
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
          .then(() => this.getResident())
          .catch(error => console.error(error));
      }
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
