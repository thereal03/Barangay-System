<template>
  <div class="analytics-container">
    <h2 class="text-2xl font-bold mb-4">{{ $t('Ticket Analytics') }}</h2>
    <div class="mb-4">
      <label for="serviceFilter" class="block text-sm font-medium text-gray-700 mb-2">{{ $t('Filter by Service') }}</label>
      <select id="serviceFilter" v-model="selectedService" @change="fetchTicketData" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
        <option value="">{{ $t('All Services') }}</option>
        <option v-for="service in services" :key="service.id" :value="service.id">{{ service.name }}</option>
      </select>
    </div>
    <div class="mb-4">
      <label for="departmentFilter" class="block text-sm font-medium text-gray-700 mb-2">{{ $t('Filter by Barangay') }}</label>
      <select id="departmentFilter" v-model="selectedDepartment" @change="fetchTicketData" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md shadow-sm">
        <option value="">{{ $t('All Barangays') }}</option>
        <option v-for="department in departments" :key="department.id" :value="department.id">{{ department.name }}</option>
      </select>
    </div>
    <div class="flex justify-between mb-4">
      <div class="bg-green-100 p-4 rounded-lg shadow-lg flex-1 mr-2">
        <h3 class="font-semibold text-green-700">{{ $t('Resolved Tickets') }}</h3>
        <p class="text-2xl font-bold text-green-700">{{ resolvedTickets }}</p>
      </div>
      <div class="bg-red-100 p-4 rounded-lg shadow-lg flex-1 ml-2">
        <h3 class="font-semibold text-red-700">{{ $t('Open Tickets') }}</h3>
        <p class="text-2xl font-bold text-red-700">{{ openTickets }}</p>
      </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md">
      <h3 class="text-xl font-bold mb-4">{{ $t('Total Tickets') }}: {{ totalTickets }}</h3>
      <div>
        <canvas id="ticketChart"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { Chart } from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';

Chart.plugins.register(ChartDataLabels);

export default {
  name: "Analytics",
  data() {
    return {
      resolvedTickets: 0,
      openTickets: 0,
      services: [],
      departments: [],
      selectedService: '',
      selectedDepartment: '',
      chart: null,
    };
  },
  computed: {
    totalTickets() {
      return this.resolvedTickets + this.openTickets;
    }
  },
  mounted() {
    this.fetchServices();
    this.fetchDepartments();
    this.fetchTicketData();
  },
  methods: {
    fetchServices() {
      axios.get('api/services').then(response => {
        this.services = response.data;
      }).catch(error => {
        console.error("Error fetching services:", error);
      });
    },
    fetchDepartments() {
      axios.get('api/tickets/departments').then(response => {
        this.departments = response.data;
      }).catch(error => {
        console.error("Error fetching departments:", error);
      });
    },
    fetchTicketData() {
      const params = {};
      if (this.selectedService) {
        params.service_id = this.selectedService;
      }
      if (this.selectedDepartment) {
        params.department_id = this.selectedDepartment;
      }
      axios.get('api/dashboard/tickets/stats', { params }).then(response => {
        this.resolvedTickets = response.data.resolved;
        this.openTickets = response.data.open;
        console.log("Resolved Tickets:", this.resolvedTickets);
        console.log("Open Tickets:", this.openTickets);
        this.updateChart();
      }).catch(error => {
        console.error("Error fetching ticket data:", error);
      });
    },
    renderChart() {
      const ctx = document.getElementById('ticketChart').getContext('2d');
      this.chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['Resolved', 'Open'],
          datasets: [{
            label: 'Tickets',
            data: [this.resolvedTickets, this.openTickets],
            backgroundColor: ['#4caf50', '#f44336'],
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
            tooltip: {
              callbacks: {
                label: function(tooltipItem) {
                  return tooltipItem.label + ': ' + tooltipItem.raw;
                }
              }
            },
            datalabels: {
              display: true,
              color: '#fff',
              font: {
                weight: 'bold',
                size: '14'
              },
              formatter: (value) => {
                return value;
              }
            }
          }
        }
      });
    },
    updateChart() {
      if (this.chart) {
        this.chart.data.datasets[0].data = [this.resolvedTickets, this.openTickets];
        this.chart.update();
      } else {
        this.renderChart();
      }
    }
  }
}
</script>

<style scoped>
.analytics-container {
  padding: 20px;
}
</style>