<template>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-900">Tickets per Department</h2>
        <canvas ref="departmentChart"></canvas>
        <div v-if="highestDepartment" class="mt-4 text-sm text-gray-600">
            <span class="font-semibold">Highest:</span> {{ highestDepartment.name }} ({{ highestDepartment.tickets }} tickets)
        </div>
    </div>
</template>

<script>
import Chart from 'chart.js'; // Import Chart.js
import axios from 'axios';


export default {
    name: "SalesPerformance",
    data() {
        return {
            departmentData: {
                labels: [], // Department names
                datasets: [{
                    label: 'Number of Tickets',
                    data: [], // Ticket counts
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                }]
            },
            highestDepartment: null, // Department with the highest tickets
        };
    },
    mounted() {
        this.fetchDepartmentData();
    },
    methods: {
        async fetchDepartmentData() {
    try {
        const departmentResponse = await axios.get('/api/dashboard/admin/departments');
        const departments = departmentResponse.data;

        const ticketResponse = await axios.get('/api/dashboard/admin/departments/ticket-counts');
        const ticketCounts = ticketResponse.data;

        this.departmentData.labels = departments.map(dept => dept.name);
        this.departmentData.datasets[0].data = departments.map(dept => {
            const ticketData = ticketCounts.find(ticket => ticket.department_id === dept.id);
            return ticketData ? ticketData.count : 0;
        });

        this.highestDepartment = departments.reduce((max, dept, index) => {
            const tickets = this.departmentData.datasets[0].data[index];
            return tickets > max.tickets ? { name: dept.name, tickets } : max;
        }, { name: '', tickets: 0 });

        this.renderChart();
    } catch (error) {
        console.error("Failed to fetch department data:", error);
    }
},
        renderChart() {
            const ctx = this.$refs.departmentChart?.getContext('2d');
            if (!ctx) {
                console.error("Canvas context is not available.");
                return;
            }

            new Chart(ctx, {
                type: 'bar',
                data: this.departmentData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Tickets',
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Department',
                            },
                        },
                    },
                },
            });
        }
    }
}
</script>

<style scoped>
/* Add any custom styles here */
</style>