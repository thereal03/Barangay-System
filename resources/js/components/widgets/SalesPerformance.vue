<template>
    <div class="analytics-container">
      <h2 class="text-2xl font-bold mb-4">{{ $t('Ticket Priority Analysis') }}</h2>
      <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <canvas ref="ticketPriorityChart"></canvas>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { Chart } from 'chart.js';
  
  export default {
    name: "TicketPriorityAnalysis",
    data() {
      return {
        ticketPriorityStats: [],
      };
    },
    mounted() {
      this.fetchTicketPriorityStats();
    },
    methods: {
      fetchTicketPriorityStats() {
        axios.get('api/dashboard/tickets/priority-stats').then(response => {
          this.ticketPriorityStats = response.data;
          this.renderTicketPriorityChart();
        }).catch(error => {
          console.error("Error fetching ticket priority stats:", error);
        });
      },
      renderTicketPriorityChart() {
        const ctx = this.$refs.ticketPriorityChart?.getContext('2d');
        if (!ctx) {
          console.error("Canvas context is not available.");
          return;
        }
  
        // Ensure all priority levels are included, even if their count is 0
        const priorities = ['Low', 'Medium', 'High', 'Urgent', 'Unknown'];
        const priorityData = priorities.map(priority => {
          const stat = this.ticketPriorityStats.find(stat => stat.priority === priority);
          return stat ? stat.count : 0;
        });
  
        console.log("Rendering ticket priority chart with data:", priorityData);
  
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: priorities,
            datasets: [{
              label: 'Tickets',
              data: priorityData,
              backgroundColor: priorities.map(priority => {
                switch (priority) {
                  case 'Low':
                    return '#4caf50'; // Green
                  case 'Medium':
                    return '#ffeb3b'; // Yellow
                  case 'High':
                    return '#ff9800'; // Orange
                  case 'Urgent':
                    return '#f44336'; // Red
                  default:
                    return '#9e9e9e'; // Grey for Unknown
                }
              }),
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: true,
                position: 'top',
              },
              tooltip: {
                callbacks: {
                  label: function(tooltipItem) {
                    return tooltipItem.label + ': ' + tooltipItem.raw;
                  }
                }
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                min: 0, // Ensure the y-axis starts at 0
                title: {
                  display: true,
                  text: 'Number of Tickets',
                },
              },
              x: {
                title: {
                  display: true,
                  text: 'Priority',
                },
              },
            },
          },
        });
      },
    },
  };
  </script>
  
  <style scoped>
  .analytics-container {
    padding: 20px;
  }
  </style>