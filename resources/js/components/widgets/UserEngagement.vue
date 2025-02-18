<template>
    <div v-if="canView" class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-900">User Engagement</h2>
        <canvas ref="userEngagementChart"></canvas>
    </div>
</template>

<script>
import Chart from 'chart.js';
import axios from 'axios'; // Ensure Axios is imported

export default {
    name: "UserEngagement",
    data() {
        return {
            userRole: null,
            canView: false, // This determines if the component should render
        };
    },
    async mounted() {
        await this.getUserRole();
        if (this.canView) {
            this.renderChart();
        }
    },
    methods: {
        async getUserRole() {
    try {
        const response = await axios.get('/api/auth/user'); // Fetch user data
        this.userRole = response.data.role;
        console.log("Fetched User Role:", this.userRole); // Debugging

        // Ensure we're checking the name property of the object
        if (this.userRole && this.userRole.name) {
            this.canView = ["admin", "Admin"].includes(this.userRole.name);
        }

        console.log("Can View UserEngagement:", this.canView); // Debugging
    } catch (error) {
        console.error("Failed to fetch user role:", error);
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
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [{
                        label: 'Active Users',
                        data: [65, 59, 80, 81, 56, 55, 40],
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
