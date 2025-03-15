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
        <p class="text-2xl font-bold text-green-700">{{ totalResolvedTickets }}</p>
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
      resolvedTicketsByService: [],
      openTickets: 0,
      services: [],
      departments: [],
      selectedService: '',
      selectedDepartment: '',
      chart: null,
    };
  },
  computed: {
    totalResolvedTickets() {
      return this.resolvedTicketsByService.reduce((total, service) => total + service.count, 0);
    },
    totalTickets() {
      return this.totalResolvedTickets + this.openTickets;
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
        console.log("API Response:", response.data); // Log the API response
        this.resolvedTicketsByService = response.data.resolvedByService || [];
        this.openTickets = response.data.open || 0;
        console.log("Resolved Tickets by Service:", this.resolvedTicketsByService);
        console.log("Open Tickets:", this.openTickets);
        this.updateChart();
      }).catch(error => {
        console.error("Error fetching ticket data:", error);
      });
    },
    renderChart() {
      const ctx = document.getElementById('ticketChart').getContext('2d');
      if (!ctx) {
        console.error("Canvas element not found");
        return;
      }
      const labels = this.resolvedTicketsByService.map(service => service.name);
      const data = this.resolvedTicketsByService.map(service => service.count);
      labels.push('Open Tickets');
      data.push(this.openTickets);
      console.log("Rendering Chart with Data:", data);

      this.chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Tickets',
            data: data,
            backgroundColor: this.generateColors(data.length),
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
          },
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    },
    updateChart() {
      if (this.chart) {
        const labels = this.resolvedTicketsByService.map(service => service.name);
        const data = this.resolvedTicketsByService.map(service => service.count);
        labels.push('Open Tickets');
        data.push(this.openTickets);
        console.log("Updating Chart Data:", data);

        this.chart.data.labels = labels;
        this.chart.data.datasets[0].data = data;
        this.chart.update();
      } else {
        this.renderChart();
      }
    },
    generateColors(count) {
      const colors = [];
      for (let i = 0; i < count; i++) {
        colors.push(`hsl(${Math.floor(Math.random() * 360)}, 100%, 75%)`);
      }
      return colors;
    }
  }
}
</script>

<style scoped>
.analytics-container {
  padding: 20px;
}
</style>