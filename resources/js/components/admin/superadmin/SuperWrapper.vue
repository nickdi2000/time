<template>
  <v-container fluid grid-list-xl>
    <v-flex >
      <v-card class="py-4 px-4">
      <h2>SUPER ADMIN</h2>
    <Users :users="users" />
    </v-card>

    <v-card class="py-4 px-4 mx-2">
      Current Course ID: {{ auth.course_id }}<br/>
      New Course: {{ new_course }}
      <CoursesDropdown @update-course="trigger" />
      <v-btn @click="saveCourse()" >Save</v-btn>
    </v-card>

  </v-flex>
  </v-container>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import Users from './Users';
import CoursesDropdown from '$comp/misc/CoursesDropdown';

export default {
  components: {
    Users,CoursesDropdown
  },

  data: () => ({
		app_name: process.env.MIX_APP_NAME,
    users: [],
    new_course: null,
  }),

  mounted() {
    this.getUsers();
  },

  computed: mapGetters({
    auth: 'auth/user'
  }),

  methods: {
    saveCourse(){
      let data = {course_id: this.new_course};

      axios.put('/api/user/' + this.auth.id, data)
        .then(res => {
          console.log(res);
          this.$toast.success(res.data.message);
        });
    },
    trigger(val){
      this.new_course = val;
      console.log(val);
    },
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
