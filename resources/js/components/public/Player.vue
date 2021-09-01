<template>
  <v-flex sm8 md6 lg4>

		<v-container class="w-100 d-flex" fluid justify-center align-center>
				<transition name="slide-fade">
					<v-img v-if="showLogo" src="/images/beer-logo.png" max-width="100"></v-img>
				</transition>
		</v-container>



    <v-card class="mx-auto">
      <v-toolbar dark color="primary" flat>
        <v-toolbar-title>CaddySnack.ca/</v-toolbar-title>
      </v-toolbar>
			<v-card-text>
				<v-container fluid >
				<v-text-field
            v-model="name"
            outlined
            label="Name.."
						persistent-hint
						hint="Give us a name or nick-name to help us find you"
						style="font-size:2em"
          ></v-text-field>


	        <v-btn
						color="info"
						large
						block
						class="mt-4"
					>
					<v-icon left dark>mdi-signal-variant</v-icon>
					<h2>Request Drink Cart!</h2>
					</v-btn>
				</v-container>
		</v-card-text>
		</v-card>
  </v-flex>
</template>

<script>
import Beer from '$comp/misc/Beer'

export default {
  components: { Beer },
  data: () => ({
    name: "",
		showLogo: false,
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
	mounted() {
		this.showLogo = true;
	}
}
</script>

<style>
/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
  transition: all 1.3s ease;
}
.slide-fade-leave-active {
  transition: all .1.8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(40px);
  opacity: 0;
}
</style>
