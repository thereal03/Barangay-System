<template>
  <div class="service-item">
    <h3>{{ service.name }}</h3>
    <p>{{ service.description }}</p>
    <button @click="deleteService">Delete</button>
  </div>
</template>

<script>
export default {
  props: {
    service: Object
  },
  methods: {
    deleteService() {
      // Use the service.id to pass the service id
      this.$emit("delete", this.service.id); // Emitting the service ID to the parent component
    }
  }
};
</script>
