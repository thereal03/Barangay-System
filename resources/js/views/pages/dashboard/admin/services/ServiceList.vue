<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Services') }}</h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <router-link
                        class="btn btn-blue shadow-sm rounded-md"
                        to="/dashboard/admin/services/new"
                    >
                        {{ $t('Create service') }}
                    </router-link>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
                <loading :status="loading"/>
                <template v-if="services.length > 0">
                    <ul>
                        <!-- Move :key to the actual li element -->
                        <li v-for="(service, index) in services" :key="service.id" :class="{'border-t border-gray-200': index !== 0}">
                            <router-link
                                :to="'/dashboard/admin/services/' + service.id + '/edit'"
                                class="block hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                            >
                                <div class="px-4 py-4 flex items-center sm:px-6">
                                    <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div>
                                            <div class="text-sm font-medium leading-5 text-gray-900 truncate">
                                                {{ service.name }}
                                            </div>
                                            <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                                {{ service.description }}
                                            </div>
                                        </div>
                                        <div class="mt-4 flex-shrink-0 sm:mt-0">
                                            <div class="flex overflow-hidden">
                                                <div class="text-sm text-gray-700">
                                                    {{ service.status ? $t('Active') : $t('Inactive') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ml-5 flex-shrink-0">
                                        <svg-vue class="h-5 w-5 text-gray-400" icon="font-awesome.angle-right-regular"></svg-vue>
                                    </div>
                                </div>
                            </router-link>
                            <button @click="deleteService(service.id)" class="btn btn-red">
                                {{ $t('Delete') }}
                            </button>
                        </li>
                    </ul>
                </template>
                <template v-else-if="!loading">
                    <div class="h-full flex">
                        <div class="m-auto">
                            <div class="grid grid-cols-1 justify-items-center h-full w-full px-4 py-10">
                                <div class="flex justify-center items-center">
                                    <svg-vue class="h-full h-auto w-64 mb-12" icon="undraw.browsing"></svg-vue>
                                </div>
                                <div class="flex justify-center items-center">
                                    <div class="w-full font-semibold text-2xl">{{ $t('No services found') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </main>
</template>

<script>
import axios from "axios";

export default {
    name: "ServiceList",
    metaInfo() {
        return {
            title: this.$i18n.t('Services')
        };
    },
    data() {
        return {
            loading: true,
            services: [],
        };
    },
    mounted() {
        this.fetchServices();
    },
    methods: {
        async fetchServices() {
            try {
                const response = await axios.get('/api/dashboard/admin/services');
                this.services = response.data;
                this.loading = false;
            } catch (error) {
                this.loading = false;
                console.error(error);
            }
        },
        async deleteService(serviceId) {
            try {
                await axios.delete(`/api/dashboard/admin/services/${serviceId}`);
                // Remove the deleted service from the list
                this.services = this.services.filter(service => service.id !== serviceId);
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>
