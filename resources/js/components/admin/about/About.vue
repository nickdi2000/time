<template>
  <v-container fluid grid-list-xl>
    <v-layout row justify-center wrap>
      <v-alert
      border="top"
      colored-border
      type="info"
      elevation="2"
    >
				<h2>{{app_name}}</h2> <br/>
				Welcome to the admin portal.  Currently we are still in production, but you will be notified as soon as we are ready to launch.
			</v-alert>

			<v-alert>
				Contact: <a href="mailto:golf@webfly.io">Golf@webfly.io</a>
			</v-alert>

    </v-layout>
  </v-container>
</template>

<script>

export default {
  components: {

  },

  data: () => ({
		app_name: "Brew Caddy"
  }),

  mounted() {

  },

  methods: {

  }
}
</script>
