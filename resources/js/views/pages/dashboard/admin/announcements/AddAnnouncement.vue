<template>
  <div class="py-10">
    <main>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mt-10 my-6 bg-white shadow overflow-hidden sm:rounded-md">
          <!-- Add Announcement Form -->
          <div class="mt-10 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $t('Add Announcement') }}</h2>
            <form @submit.prevent="addAnnouncement">
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                  {{ $t('Title') }}
                </label>
                <input
                  v-model="newAnnouncement.title"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                  id="title"
                  type="text"
                  placeholder="Enter title"
                  required
                />
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                  {{ $t('Description') }}
                </label>
                <textarea
                  v-model="newAnnouncement.description"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                  id="description"
                  placeholder="Enter description"
                  required
                ></textarea>
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="date">
                  {{ $t('Date') }}
                </label>
                <input
                  v-model="newAnnouncement.date"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                  id="date"
                  type="datetime-local"
                  required
                />
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="link">
                  {{ $t('Link') }}
                </label>
                <input
                  v-model="newAnnouncement.link"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                  id="link"
                  type="url"
                  placeholder="Enter link"
                />
              </div>
              <div class="flex items-center justify-between">
                <button
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                  type="submit"
                >
                  {{ $t('Add Announcement') }}
                </button>
                <button
                  class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                  type="button"
                  @click="goBack"
                >
                  {{ $t('Back') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "AddAnnouncement",
  data() {
    return {
      newAnnouncement: {
        title: '',
        description: '',
        date: '',
        link: ''
      }
    };
  },
  methods: {
    addAnnouncement() {
      axios.post('/api/announcements', this.newAnnouncement).then(() => {
        this.$router.push('/dashboard/admin/announcements');
      }).catch(error => {
        console.error("There was an error adding the announcement:", error);
      });
    },
    goBack() {
      this.$router.push('/dashboard/admin/announcements');
    }
  }
}
</script>