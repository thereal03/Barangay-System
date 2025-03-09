<template>
  <div class="analytics-container">
    <h2 class="text-2xl font-bold mb-4">{{ $t('Ticket Analytics') }}</h2>
    <div class="flex justify-between mb-4">
      <div class="bg-green-100 p-4 rounded shadow">
        <h3 class="font-semibold">{{ $t('Resolved Tickets') }}</h3>
        <p class="text-lg">{{ resolvedTickets }}</p>
      </div>
      <div class="bg-red-100 p-4 rounded shadow">
        <h3 class="font-semibold">{{ $t('Open Tickets') }}</h3>
        <p class="text-lg">{{ openTickets }}</p>
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

export default {
  name: "Analytics",
  data() {
    return {
      resolvedTickets: 0,
      openTickets: 0,
    };
  },
  computed: {
    totalTickets() {
      return this.resolvedTickets + this.openTickets;
    }
  },
  mounted() {
    this.fetchTicketData();
  },
  methods: {
    fetchTicketData() {
      axios.get('api/dashboard/tickets/stats').then(response => {
        this.resolvedTickets = response.data.resolved;
        this.openTickets = response.data.open;
        console.log("Resolved Tickets:", this.resolvedTickets);
        console.log("Open Tickets:", this.openTickets);
        this.renderChart();
      }).catch(error => {
        console.error("Error fetching ticket data:", error);
      });
    },
    renderChart() {
      const ctx = document.getElementById('ticketChart').getContext('2d');
      console.log("Chart Data:", [this.resolvedTickets, this.openTickets]);
      new Chart(ctx, {
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
            }
          }
        }
      });
    }
  }
}
</script>

<style scoped>
.analytics-container {
  padding: 20px;
}
</style>