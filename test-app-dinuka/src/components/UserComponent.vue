<!-- src/components/UserForm.vue -->
<template>
  <form @submit.prevent="submit">
    <input v-model="form.name" placeholder="Name" required />
    <input v-model="form.email" placeholder="Email" type="email" required />
    <input v-model="form.phone" placeholder="Phone" type="number" />
    <input v-model="form.address" placeholder="Address" />
    <input v-model="form.age" placeholder="Age" type="number" />
    <input @change="handleFileUpload" type="file" />
    <button type="submit">Save</button>
    <div v-if="errors.length">
      <ul><li v-for="(err, i) in errors" :key="i">{{ err }}</li></ul>
    </div>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import axios from '../services/api';

const form = ref({
  name: '',
  email: '',
  phone: '',
  address: '',
  age: '',
  profile_picture: null
});

const errors = ref([]);

const handleFileUpload = (e) => {
  form.value.profile_picture = e.target.files[0];
};

const submit = async () => {
  errors.value = [];
  const formData = new FormData();
  for (let key in form.value) {
    if (form.value[key] !== null) {
      formData.append(key, form.value[key]);
    }
  }

  try {
    await axios.post('/users', formData);
    alert('User saved!');
  } catch (err) {
    errors.value = Object.values(err.response.data.errors).flat();
  }
};
</script>
