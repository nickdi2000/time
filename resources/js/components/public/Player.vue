<template>
  <v-flex sm8 md6 lg4>
    <v-card class="mx-auto">
      <v-toolbar dark color="primary" flat>
        <v-toolbar-title>CaddySnack.ca/</v-toolbar-title>
      </v-toolbar>
			<v-card-text>

				<v-text-field
            v-model="name"
            outlined
            label="Name.."
						hint="Give us a name or nick-name to help us find you"
          ></v-text-field>


	        <v-btn
						color="info"
						large
					>
					<v-icon left dark>mdi-signal-variant</v-icon>Request Drink Cart!</v-btn>
		</v-card-text>
		</v-card>
  </v-flex>
</template>

<script>

export default {
  components: {
  },
  data: () => ({
    name: "",
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
