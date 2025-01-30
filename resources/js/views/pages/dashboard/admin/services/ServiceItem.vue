<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="saveService">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Edit service') }}</h1>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <button
                            class="btn btn-red shadow-sm rounded-md"
                            type="button"
                            @click="deleteServiceModal = true"
                        >
                            {{ $t('Delete service') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Service Details -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading"/>
                    <div v-if="service" class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Service details') }}</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500">{{ $t('Service details and settings') }}.</p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-3 gap-6">
                                <!-- Service Name -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="name">{{ $t('Name') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="name"
                                            v-model="service.name"
                                            :placeholder="$t('Name')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                </div>

                                <!-- Visibility Toggle -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="public">{{ $t('Visibility') }}</label>
                                    <input-switch
                                        id="public"
                                        v-model="service.public"
                                        :disabled-label="$t('The service is private')"
                                        :enabled-label="$t('The service is public')"
                                    ></input-switch>
                                    <div class="mt-2 relative text-xs text-gray-500">
                                        {{ $t('If the service is public, users can select it when creating tickets.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                        <span class="inline-flex">
                            <router-link
                                class="btn btn-secondary shadow-sm rounded-md mr-4"
                                to="/dashboard/admin/services"
                            >
                                {{ $t('Close') }}
                            </router-link>
                            <button
                                class="btn btn-green shadow-sm rounded-md"
                                type="submit"
                            >
                                {{ $t('Save Changes') }}
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </form>

        <!-- Delete Service Modal -->
        <div v-show="deleteServiceModal" class="fixed z-20 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <transition
                    duration="300"
                    enter-active-class="ease-out duration-300"
                    enter-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-show="deleteServiceModal" class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                </transition>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
                <transition
                    enter-active-class="ease-out duration-300"
                    enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        v-show="deleteServiceModal"
                        aria-labelledby="modal-headline"
                        aria-modal="true"
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                        role="dialog"
                    >
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg-vue class="h-6 w-6 pb-1 text-red-600" icon="font-awesome.exclamation-triangle-light"></svg-vue>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 id="modal-headline" class="text-lg leading-6 font-medium text-gray-900">
                                        {{ $t('Delete service') }}
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm leading-5 text-gray-500">
                                            {{ $t('Are you sure you want to delete the service?') }}
                                            {{ $t('All data will be permanently removed') }}.
                                            {{ $t('Tickets with this service will be changed to "Without service"') }}.
                                            {{ $t('This action cannot be undone') }}.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                class="btn btn-red mr-2 sm:mr-0"
                                type="button"
                                @click="deleteService"
                            >
                                {{ $t('Delete service') }}
                            </button>
                            <button
                                class="btn btn-white mr-0 sm:mr-2"
                                type="button"
                                @click="deleteServiceModal = false"
                            >
                                {{ $t('Cancel') }}
                            </button>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: "ServiceEditDelete",
    data() {
        return {
            loading: false,
            deleteServiceModal: false,
            service: {
                name: '',
                public: true,
            },
        };
    },
    mounted() {
        this.getService();
    },
    methods: {
        saveService() {
            this.loading = true;
            axios
                .put(`api/dashboard/admin/services/${this.$route.params.id}`, this.service)
                .then((response) => {
                    this.loading = false;
                    // Notify the user of successful update
                    this.$notify({
                        title: this.$i18n.t("Success"),
                        text: this.$i18n.t("Data updated correctly"),
                        type: "success",
                    });

                    // Update the service data with the response
                    this.service = response.data.service;

                    // Redirect to the Services list after saving
                    this.$router.push("/dashboard/admin/services").catch(() => {});
                })
                .catch((error) => {
                    this.loading = false;
                    // Handle error, if any
                    console.error("There was an error updating the service:", error);
                });
        },
        getService() {
            this.loading = true;
            axios
                .get(`api/dashboard/admin/services/${this.$route.params.id}`)
                .then((response) => {
                    this.service = response.data;
                    this.loading = false;
                })
                .catch(() => {
                    this.loading = false;
                });
        },
        deleteService() {
            axios
                .delete(`api/dashboard/admin/services/${this.$route.params.id}`)
                .then(() => {
                    this.$notify({
                        title: this.$i18n.t("Success"),
                        text: this.$i18n.t("Data deleted successfully"),
                        type: "success",
                    });
                    this.$router.push("/dashboard/admin/services");
                })
                .catch(() => {
                    this.deleteServiceModal = false;
                });
        },
    },
};
</script>
