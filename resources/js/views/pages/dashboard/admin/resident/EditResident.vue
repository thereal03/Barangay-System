<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Edit Resident') }}</h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <router-link
                        class="btn btn-blue shadow-sm rounded-md"
                        to="/dashboard/admin/resident"
                    >
                        {{ $t('Back to Residents List') }}
                    </router-link>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
                <loading :status="loading"/>
                <form @submit.prevent="updateResident">
                    <div class="px-4 py-4 sm:px-6">
                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">{{ $t('First Name') }}</label>
                            <input
                                type="text"
                                id="first_name"
                                v-model="form.first_name"
                                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required
                            />
                        </div>
                        <!-- Last Name -->
                        <div class="mt-4">
                            <label for="last_name" class="block text-sm font-medium text-gray-700">{{ $t('Last Name') }}</label>
                            <input
                                type="text"
                                id="last_name"
                                v-model="form.last_name"
                                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                required
                            />
                        </div>
                        <!-- Date of Birth -->
                        <div class="mt-4">
                            <label for="dob" class="block text-sm font-medium text-gray-700">{{ $t('Date of Birth') }}</label>
                            <input
                                type="date"
                                id="dob"
                                v-model="form.dob"
                                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            />
                        </div>
                        <!-- Gender -->
                        <div class="mt-4">
                            <label for="gender" class="block text-sm font-medium text-gray-700">{{ $t('Gender') }}</label>
                            <select
                                id="gender"
                                v-model="form.gender"
                                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            >
                                <option value="male">{{ $t('Male') }}</option>
                                <option value="female">{{ $t('Female') }}</option>
                                <option value="other">{{ $t('Other') }}</option>
                            </select>
                        </div>
                        <!-- Address -->
                        <div class="mt-4">
                            <label for="address" class="block text-sm font-medium text-gray-700">{{ $t('Address') }}</label>
                            <input
                                type="text"
                                id="address"
                                v-model="form.address"
                                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            />
                        </div>
                        <!-- Contact Number -->
                        <div class="mt-4">
                            <label for="contact_number" class="block text-sm font-medium text-gray-700">{{ $t('Contact Number') }}</label>
                            <input
                                type="text"
                                id="contact_number"
                                v-model="form.contact_number"
                                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            />
                        </div>
                        <!-- Email -->
                        <div class="mt-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">{{ $t('Email') }}</label>
                            <input
                                type="email"
                                id="email"
                                v-model="form.email"
                                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            />
                        </div>
                        <!-- Created At -->
                        <div class="mt-4">
                            <label for="created_at" class="block text-sm font-medium text-gray-700">{{ $t('Created At') }}</label>
                            <input
                                type="text"
                                id="created_at"
                                v-model="form.created_at"
                                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                disabled
                            />
                        </div>
                        <!-- Updated At -->
                        <div class="mt-4">
                            <label for="updated_at" class="block text-sm font-medium text-gray-700">{{ $t('Updated At') }}</label>
                            <input
                                type="text"
                                id="updated_at"
                                v-model="form.updated_at"
                                class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                disabled
                            />
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button
                            type="submit"
                            class="btn btn-blue shadow-sm rounded-md"
                            :disabled="loading"
                        >
                            {{ $t('Update Resident') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: "EditResident",
    data() {
        return {
            loading: true,
            form: {
                first_name: '',
                last_name: '',
                dob: '',
                gender: '',
                address: '',
                contact_number: '',
                email: '',
                created_at: '',
                updated_at: ''
            }
        };
    },
    mounted() {
        this.getResident();
    },
    methods: {
        getResident() {
            const residentId = this.$route.params.id;
            axios.get(`api/dashboard/admin/resident/${residentId}`).then(response => {
                this.form = response.data;
                this.loading = false;
            }).catch(error => {
                console.error(error);
                this.loading = false;
            });
        },
        updateResident() {
            this.loading = true;
            const residentId = this.$route.params.id;
            axios.put(`api/dashboard/admin/resident/${residentId}`, this.form)
                .then(response => {
                    this.$router.push('/dashboard/admin/resident');
                })
                .catch(error => {
                    console.error(error);
                    this.loading = false;
                });
        }
    }
}
</script>
