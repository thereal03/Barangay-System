<template>
    <div v-if="canView" class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-900">User Engagement</h2>
        <p>Total User Accounts: {{ userCount }}</p> <!-- Display the number of user accounts -->
        <canvas ref="userEngagementChart"></canvas>
    </div>
</template>

<script>
import Chart from 'chart.js';
import axios from 'axios';

export default {
    name: "UserEngagement",
    data() {
        return {
            userRole: null,
            canView: false,
            userCount: 0, // New data property to store the number of user accounts
        };
    },
    async mounted() {
        await this.getUserRole();
        if (this.canView) {
            await this.getUserCount(); // Fetch the number of user accounts
            this.renderChart();
        }
    },
    methods: {
        async getUserRole() {
            try {
                const response = await axios.get('/api/auth/user');
                this.userRole = response.data.role;
                console.log("Fetched User Role:", this.userRole);

                if (this.userRole && this.userRole.name) {
                    this.canView = ["admin", "Admin"].includes(this.userRole.name);
                }

                console.log("Can View UserEngagement:", this.canView);
            } catch (error) {
                console.error("Failed to fetch user role:", error);
            }
        },
        async getUserCount() {
            try {
                const response = await axios.get('/api/users/count'); // Adjust the endpoint as needed
                this.userCount = response.data.count;
                console.log("Fetched User Count:", this.userCount);
            } catch (error) {
                console.error("Failed to fetch user count:", error);
            }
        },
        renderChart() {
            const ctx = this.$refs.userEngagementChart?.getContext('2d');
            if (!ctx) {
                console.error("Canvas context is not available.");
                return;
            }

            console.log("Rendering chart...");
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['November', 'December', 'January', 'February'],
                    datasets: [{
                        label: 'Active Users',
                        data: [6, 22, 11, this.userCount], // Include the total user count as the last data point
                        borderColor: 'rgba(75, 192, 192, 1)',
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    legend: {
                        display: true,
                        position: 'top',
                    },
                }
            });
        }
    }
}
</script>