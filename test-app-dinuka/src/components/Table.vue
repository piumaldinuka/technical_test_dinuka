<!-- src/components/UserTable.vue -->
<template>
  <table>
    <thead><tr><th>Name</th><th>Email</th><th>Actions</th></tr></thead>
    <tbody>
      <tr v-for="user in users.data" :key="user.id">
        <td>{{ user.name }}</td>
        <td>{{ user.email }}</td>
        <td>
          <button @click="edit(user)">Edit</button>
          <button @click="del(user.id)">Delete</button>
        </td>
      </tr>
    </tbody>
  </table>
  <button @click="fetchUsers(users.prev_page_url)" :disabled="!users.prev_page_url">Prev</button>
  <button @click="fetchUsers(users.next_page_url)" :disabled="!users.next_page_url">Next</button>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from '../services/api';

const users = ref({ data: [] });

const fetchUsers = async (url = '/users') => {
  const res = await axios.get(url);
  users.value = res.data;
};

const del = async (id) => {
  await axios.delete(`/users/${id}`);
  fetchUsers();
};

const edit = (user) => {
  // emit to populate form, or use a shared state
};

onMounted(fetchUsers);
</script>
