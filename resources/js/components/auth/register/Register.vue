<template>
  <v-flex sm8 md6 lg4>
    <v-card>
      <v-toolbar dark color="primary" flat v-on:dblclick="allowRegister=true">
        <v-toolbar-title>Register As: {{ user_type }}</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <register-form @success="success" @set-user-type="UserType"></register-form>
      </v-card-text>
    </v-card>
  </v-flex>
</template>

<script>
import RegisterForm from './RegisterForm'
import api from '~/api';

export default {
  components: {
    RegisterForm
  },
  data: () => ({
    user_type: "",
    allowRegister: false
  }),
  methods: {
    success(data) {
      this.$store.dispatch('auth/saveToken', data)
      this.$store.dispatch('auth/setUser', data)
      this.$router.push({ name: 'index' })
    },
		UserType(v) {
			this.user_type = v;
		}
  },
  async mounted() {
    if (this.$store.getters['player/player_course_id']){
      let course_id = this.$store.getters['player/player_course_id'];
      const course = await api.getCourseData(course_id);
      console.log("course: ", course);
      //this.$router.push('/' + course.code);
    }
  },
  computed: {
    register() {

      let reg = (process.env.REGISTER || this.allowRegister) ? true : false;
      console.log("register is opened", reg);
      return reg;
    }
  }
}
</script>
