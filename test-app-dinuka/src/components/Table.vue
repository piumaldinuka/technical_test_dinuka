<template>
  <div class="table-container">
    <UserForm v-if="showForm" :editData="editData" @refresh="fetchUsers" />

    <table class="user-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Address</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users.data" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.phone }}</td>
          <td>{{ user.address }}</td>
          <td>
            <button class="edit-btn" @click="editUser(user)">Edit</button>
            <button class="delete-btn" @click="deleteUser(user.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="pagination">
      <button class="prev-btn" @click="prevPage" :disabled="!users.prev_page_url">Previous</button>
      <button class="next-btn" @click="nextPage" :disabled="!users.next_page_url">Next</button>
    </div>
  </div>
</template>

<style scoped>
.table-container {
  padding: 20px;
  font-family: Arial, sans-serif;
  color: black; /* Added font color black */
}

.add-user-btn {
  margin-bottom: 15px;
  padding: 10px 15px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.add-user-btn:hover {
  background-color: #45a049;
}

.user-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 15px;
  color: black; /* Added font color black */
}

.user-table th, .user-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.user-table th {
  background-color: #f2f2f2;
}

.edit-btn, .delete-btn {
  padding: 5px 10px;
  margin-right: 5px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

.edit-btn {
  background-color: #2196F3;
  color: white;
}

.edit-btn:hover {
  background-color: #0b7dda;
}

.delete-btn {
  background-color: #f44336;
  color: white;
}

.delete-btn:hover {
  background-color: #da190b;
}

.pagination {
  display: flex;
  justify-content: space-between;
  color: black; /* Added font color black */
}

.prev-btn, .next-btn {
  padding: 10px 15px;
  background-color: #008CBA;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.prev-btn:disabled, .next-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.prev-btn:hover:not(:disabled), .next-btn:hover:not(:disabled) {
  background-color: #007bb5;
}
</style>

<script>
import axios from 'axios';
import UserForm from './UserComponent.vue';

export default {
  components: { UserForm },
  data() {
    return {
      users: {},
      showForm: false,
      editData: null,
      page: 1
    };
  },
  methods: {
    async fetchUsers() {
      const { data } = await axios.get(`http://localhost:8000/api/user-details`,{
        headers: {
           'Content-Type': 'multipart/form-data',
           'Access-Control-Allow-Origin': '*'
        }
      });
      this.users = data;
    },
    toggleForm() {
      this.showForm = !this.showForm;
      this.editData = null;
    },
    editUser(user) {
      this.editData = user;
      this.showForm = true;
    },
    async deleteUser(id) {
      await axios.delete(`http://localhost:8000/api/user-details/${id}`, {
        headers: {
          'Content-Type': 'multipart/form-data',
          'Access-Control-Allow-Origin': '*'
        }
      });
      this.fetchUsers();
    },
    nextPage() {
      this.page++;
      this.fetchUsers();
    },
    prevPage() {
      this.page--;
      this.fetchUsers();
    }
  },
  mounted() {
    this.fetchUsers();
  }
};
</script>
