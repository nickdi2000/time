<template>
  <v-container fluid grid-list-xl>
    <v-flex >
      <v-card class="py-4 px-4">
      <h2>SUPER ADMIN</h2>

      <v-data-table
        :headers="headers"
        :items="users"
        :items-per-page="5"
        class="elevation-1"
      ></v-data-table>


    </v-card>
  </v-flex>
  </v-container>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
  components: {

  },

  data: () => ({
		app_name: process.env.MIX_APP_NAME,
    headers: [
      {text: "Name", value: "name"},
      {text: "Email", value: "email"},
      {text: "Signed Up", value: "created_at"},
      {text: "Course", value: "course.name"}
    ],
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
    }
  }
}
</script>
