<template>
  <UserForm @refresh="refreshList"/>
  <UserTable ref="table" @edit="editUser"/>
</template>


<script>
import UserForm from './components/UserComponent.vue';
import UserTable from './components/Table.vue';

export default {
  components: { UserForm, UserTable },
  methods: {
    refreshList() {
      this.$refs.table.getUsers();
    },
    editUser(user) {
      // Extend functionality to support editing.
    }
  }
};
</script>
