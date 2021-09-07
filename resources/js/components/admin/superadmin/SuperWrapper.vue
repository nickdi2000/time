<template>
  <v-container fluid grid-list-xl>
    <v-flex >
      <v-card class="py-4 px-4">
      <h2>SUPER ADMIN</h2>
    <Users :users="users" />
    </v-card>
  </v-flex>
  </v-container>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import Users from './Users';

export default {
  components: {
    Users
  },

  data: () => ({
		app_name: process.env.MIX_APP_NAME,
    users: []
  }),

  mounted() {
    this.getUsers();
  },

  methods: {
    getUsers(){
      axios.get('/api/user/')
        .then(res => {
          console.log(res);
          this.users = res.data;
        })
    },
    getCourse(course){
      return course ? course.name : '--';
    }
  }
}
</script>
