<template>
  <v-flex sm8 md6 lg4>
    <v-card>
      <v-toolbar dark color="primary" flat>
        <v-toolbar-title>Register As:: {{ user_type }}</v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <register-form @success="success" @set-user-type="UserType"></register-form>
      </v-card-text>
    </v-card>
  </v-flex>
</template>

<script>
import RegisterForm from './RegisterForm'

export default {
  components: {
    RegisterForm
  },
  data: () => ({
    user_type: "",
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
  }
}
</script>
