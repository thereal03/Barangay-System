<template>
  <div class="container">
    <div class="header">
      <h1>{{ $t('Blotter List') }}</h1>
      <router-link to="/dashboard/admin/blotter/create" class="add-btn">
        {{ $t('Add New Blotter') }}
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
            <tr v-for="blotter in blotters" :key="blotter.id">
              <td>{{ blotter.id }}</td>
              <td>{{ blotter.complainant }}</td>
              <td>{{ blotter.respondent }}</td>
              <td>{{ blotter.incident_type }}</td>
              <td>{{ blotter.incident_location }}</td>
              <td>{{ formatDate(blotter.incident_date) }}</td>
              <td>{{ blotter.status }}</td>
              <td>{{ formatDate(blotter.created_at) || 'N/A' }}</td>
              <td>{{ formatDate(blotter.updated_at) || 'N/A' }}</td>
              <td class="actions">
                <router-link :to="'/dashboard/admin/blotter/' + blotter.id + '/edit'" class="edit-btn">
                  {{ $t('Edit') }}
                </router-link>
                <button @click="deleteBlotter(blotter.id)" class="delete-btn">
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
import axios from 'axios';

export default {
  data() {
    return {
      blotters: [],
      headers: ['ID', 'Complainant', 'Respondent', 'Incident Type', 'Incident Location', 'Incident Date', 'Status', 'Created At', 'Updated At', 'Actions'],
    };
  },
  mounted() {
    this.getBlotters();
  },
  methods: {
    getBlotters() {
      axios.get('/api/dashboard/admin/blotter')
        .then(response => {
          this.blotters = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    deleteBlotter(id) {
      if (confirm("Are you sure you want to delete this blotter?")) {
        axios.delete(`/api/dashboard/admin/blotter/${id}`)
          .then(() => this.getBlotters())
          .catch(error => console.error(error));
      }
    },
    formatDate(dateString) {
      if (!dateString) return 'N/A';
      const date = new Date(dateString);
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