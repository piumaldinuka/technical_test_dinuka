<template>
  <form @submit.prevent="submitForm" class="form-container">
    <div class="form-group">
      <label for="name">Name</label>
      <input id="name" v-model="form.name" placeholder="Name" required />
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input id="email" v-model="form.email" placeholder="Email" type="email" required />
    </div>
    <div class="form-group">
      <label for="phone">Phone</label>
      <input id="phone" v-model="form.phone" placeholder="Phone" type="number" />
    </div>
    <div class="form-group">
      <label for="address">Address</label>
      <input id="address" v-model="form.address" placeholder="Address" />
    </div>
    <div class="form-group">
      <label for="age">Age</label>
      <input id="age" v-model="form.age" placeholder="Age" type="number" />
    </div>
    <div class="form-group">
      <label for="profile_picture">Profile Picture</label>
      <input id="profile_picture" type="file" @change="handleFileUpload" />
    </div>
    <button type="submit" class="submit-button">Submit</button>
    <p v-if="error" class="error-message">{{ error }}</p>
  </form>
</template>

<style scoped>
.form-container {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-group input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.submit-button {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.submit-button:hover {
  background-color: #0056b3;
}

.error-message {
  color: red;
  margin-top: 10px;
  text-align: center;
}
</style>

<script>
import axios from 'axios';

export default {
  props: ['editData'],
  data() {
    return {
      form: {
        name: '',
        email: '',
        phone: '',
        address: '',
        age: '',
        profile_picture: null
      },
      error: null,
    };
  },
  methods: {
    handleFileUpload(e) {
      this.form.profile_picture = e.target.files[0];
    },
    async submitForm() {
   const formData = new FormData();
   Object.keys(this.form).forEach(key => {
      if (this.form[key]) formData.append(key, this.form[key]);
   });

   try {
      let response;
      if (this.editData) {
         response = await axios.put(`http://127.0.0.1:8000/api/user-details/${this.editData.id}?_method=PUT`, formData, {
        headers: {
           'Content-Type': 'multipart/form-data',
           'Access-Control-Allow-Origin': '*'
        }
         });
      } else {
         response = await axios.post('http://127.0.0.1:8000/api/user-details', formData, {
           headers: {
             'Content-Type': 'multipart/form-data',
             'Access-Control-Allow-Origin': '*'
           }
         });
      }
      console.log(response.data); // Debugging: Check the response structure
      this.$emit('refresh');
   } catch (err) {
      console.error(err); // Log the full error for debugging
      this.error = err.response?.data?.message || 'Submission error';
   }
},
    resetForm() {
      this.form = {
        name: '',
        email: '',
        phone: '',
        address: '',
        age: '',
        profile_picture: null
      };
      this.error = null;
    }
  },
  mounted() {
    if (this.editData) this.form = { ...this.editData };
  }
};
</script>
