<template>
  <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
      <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
          <h1 class="py-0.5 text-3xl font-bold text-gray-900">{{ $t('Services') }}</h1>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
          <router-link
            class="px-5 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition duration-200"
            to="/dashboard/admin/services/new"
          >
            {{ $t('Create Service') }}
          </router-link>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="my-6">
        <loading :status="loading" />

        <template v-if="services.length > 0">
          <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div
              v-for="service in services"
              :key="service.id"
              class="bg-white p-5 rounded-lg shadow-md hover:shadow-lg transition-all duration-200"
            >
              <div class="flex justify-between items-center">
                <div>
                  <router-link
                    :to="`/dashboard/admin/services/${service.id}/edit`"
                    class="text-lg font-semibold text-gray-900 hover:text-blue-600"
                  >
                    {{ service.name }}
                  </router-link>
                  <p class="text-sm text-gray-600 mt-1">{{ service.description }}</p>
                  <p class="text-sm text-gray-600 mt-1">{{ $t('Validity Period') }}: {{ service.expiration_days }} {{ $t('days') }}</p>
                </div>
                
                <!-- Delete Button -->
                <button
                  @click="confirmDelete(service.id)"
                  class="p-2 text-red-600 hover:text-red-800 hover:bg-red-100 rounded-md transition duration-200"
                >
                  <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>

              <!-- DOCX Actions -->
              <!-- <div class="mt-4">
                <div class="flex flex-wrap gap-3">
                  <button
                    @click="triggerFileUpload(service.id)"
                    class="flex-1 px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded-md shadow-md transition duration-200"
                  >
                    {{ $t('Upload DOCX') }}
                  </button>

                  <button
                    v-if="selectedFiles[service.id]"
                    @click="uploadFile(service.id)"
                    class="flex-1 px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-md transition duration-200"
                  >
                    {{ $t('Save') }}
                  </button>
                </div>

                <div class="flex flex-wrap gap-3 mt-2">
                  <button
                    v-if="service.docx"
                    @click="fetchDocx(service.id)"
                    class="flex-1 px-4 py-2 text-white bg-purple-600 hover:bg-purple-700 rounded-md shadow-md transition duration-200"
                  >
                    {{ $t('Edit DOCX') }}
                  </button>

                  <a
                    v-if="service.docx"
                    :href="`/storage/uploads/docx/${service.docx}`"
                    class="flex-1 px-4 py-2 text-white bg-yellow-600 hover:bg-yellow-700 rounded-md shadow-md transition duration-200 text-center"
                    download
                  >
                    {{ $t('Download DOCX') }}
                  </a>
                </div>
              </div> -->
            </div>
          </div>
        </template>

        <template v-else-if="!loading">
          <div class="flex flex-col items-center py-10">
            <svg-vue class="h-auto w-64 mb-6" icon="undraw.browsing" />
            <p class="text-xl font-semibold text-gray-700">{{ $t('No services found') }}</p>
          </div>
        </template>
      </div>
    </div>

    <!-- Modal for Editing DOCX -->
    <div v-if="showDocxEditor" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white p-6 rounded-md w-3/4">
        <h2 class="text-lg font-semibold mb-4">Edit DOCX</h2>

        <editor v-model="docxContent" />

        <div class="mt-4 flex justify-end">
          <button @click="showDocxEditor = false" class="mr-2 px-4 py-2 bg-gray-400 text-white rounded-md">Cancel</button>
          <button @click="saveDocx" class="px-4 py-2 bg-blue-600 text-white rounded-md">Save</button>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import axios from "axios";
import Editor from "@tinymce/tinymce-vue";

export default {
  components: { Editor },
  data() {
    return {
      loading: true,
      services: [],
      selectedFiles: {}, 
      showDocxEditor: false,
      docxContent: "",
      editingServiceId: null,
    };
  },
  mounted() {
    this.fetchServices();
  },
  methods: {
    async fetchServices() {
      try {
        const response = await axios.get("/api/dashboard/admin/services");
        this.services = response.data;
        this.loading = false;
      } catch (error) {
        this.loading = false;
        console.error(error);
      }
    },

    confirmDelete(serviceId) {
      if (confirm("Are you sure you want to delete this service?")) {
        this.deleteService(serviceId);
      }
    },

    async deleteService(serviceId) {
      try {
        await axios.delete(`/api/dashboard/admin/services/${serviceId}`);
        this.services = this.services.filter((service) => service.id !== serviceId);
      } catch (error) {
        console.error(error);
      }
    },

    triggerFileUpload(serviceId) {
      const fileInput = this.$refs['fileInput' + serviceId];
      if (fileInput && fileInput[0]) {
        fileInput[0].click();
      }
    },

    handleFileUpload(event, serviceId) {
      const file = event.target.files[0];
      if (file) {
        this.$set(this.selectedFiles, serviceId, file);
      }
    },

    async uploadFile(serviceId) {
      if (!this.selectedFiles[serviceId]) {
        alert("No file selected.");
        return;
      }

      let formData = new FormData();
      formData.append("docx", this.selectedFiles[serviceId]);

      try {
        await axios.post(`/api/dashboard/admin/services/${serviceId}/upload-docx`, formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        alert("DOCX file uploaded successfully!");
        this.$delete(this.selectedFiles, serviceId);
        this.fetchServices();
      } catch (error) {
        console.error(error);
      }
    },

    async fetchDocx(serviceId) {
      try {
        const response = await axios.get(`/api/dashboard/admin/services/${serviceId}/view-docx`);
        this.docxContent = response.data.html;
        this.editingServiceId = serviceId;
        this.showDocxEditor = true;
      } catch (error) {
        console.error(error);
      }
    },

    async saveDocx() {
      try {
        await axios.post(`/api/dashboard/admin/services/${this.editingServiceId}/save-docx`, {
          html: this.docxContent,
        });
        alert("Document updated successfully!");
        this.showDocxEditor = false;
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>

<style scoped>
/* Add some transition effects for smooth animations */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s ease;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>