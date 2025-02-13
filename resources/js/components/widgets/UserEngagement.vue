<template>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-900">User Engagement</h2>
        <canvas ref="userEngagementChart"></canvas>
    </div>
</template>

<script>
import Chart from 'chart.js'; // Import Chart.js 2.x

export default {
    name: "UserEngagement",
    mounted() {
        this.renderChart();
    },
    methods: {
        renderChart() {
            const ctx = this.$refs.userEngagementChart?.getContext('2d');
            if (!ctx) {
                console.error("Canvas context is not available.");
                return;
            }

            console.log("Chart object:", Chart); // Debug log
            if (!Chart) {
                console.error("Chart.js is not properly imported.");
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

<style scoped>
/* Add any custom styles here */
</style>