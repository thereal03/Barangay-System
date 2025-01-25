<template>
  <form @submit.prevent="submitForm">
    <div>
      <label for="name">Service Name</label>
      <input type="text" v-model="name" id="name" required />
    </div>
    <div>
      <label for="description">Service Description</label>
      <textarea v-model="description" id="description" required></textarea>
    </div>
    <button type="submit">Save Service</button>
  </form>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      name: "",
      description: "",
    };
  },
  methods: {
    async submitForm() {
      try {
        const response = await axios.post("/api/dashboard/admin/services", {
          name: this.name,
          description: this.description,
        });
        this.$router.push("/dashboard/admin/services"); // Redirect to services list
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>
