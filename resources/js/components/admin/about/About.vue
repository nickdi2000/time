<template>
  <v-container fluid grid-list-xl>
    <v-layout row justify-center wrap>
      <v-alert
      border="top"
      colored-border
      type="info"
      elevation="2"
    >
				<h2>{{app_name}}</h2>
				Welcome to the {{app_name}} admin portal. Here you will find instructions on how to operate as a cart attendant or course manager.
			</v-alert>

      <v-alert elevation="2" class="mx-auto">
        <h3>Course Setup</h3>
        <p>Setting up the course only takes a few seconds.  The main two requirements are the course location (geo location), and the player access link (or QR code).
          Once you have entered in the course location and designated a link code, you are ready to start handing out the link/QR code and wait for the requests to role in.
          Set up your course in <router-link :to="'/course'">Course Setup</router-link>.
          <br/><br/>
          You may customize your course-link to anything you like.  It will be appended to the end of our main URL like this:
          <h4>{{$app_url}}/PEBBLE</h4>
          <v-alert type="info" outlined elevation="1">You will also be provided with a QR code that the players can scan at any time.  The QR code takes them directly to YOUR course where they can request the cart immeediately.
           Also note that their device will remember the course selection and redirect to your course anytime they re-open the site on their phones browser.
         </v-alert>

        </p>
      </v-alert>

      <v-alert elevation="2" class="mx-auto">
        <h3>The Map</h3>
        <p>The map is where all the action is.
          You can see all the golfers that have requested the drink-cart, as well as an icon indicating yourself,
          and the course's center point.

        </p>


        <v-alert type="info" border="left" v-for="icon in mapIcons" :key="icon.icon">
          <v-row no-gutters >
              <v-col cols="2">
                <v-img :src="'/images/' + icon.icon"
                  max-height="60"
                  max-width="60"
                 ></v-img>
               </v-col>

               <v-col>
                {{icon.text}}
              </v-col>
            </v-row>
          </v-alert>

        </v-alert>

			<v-alert>
				Contact: <a href="mailto:golf@webfly.io">CaddySnack@webfly.io</a>
			</v-alert>

    </v-layout>
  </v-container>
</template>

<script>

export default {
  components: {

  },

  data: () => ({
		app_name: process.env.MIX_APP_NAME,
    mapIcons: [
      {
        text: 'This is where you are.  The players cannot see this -- it is only for your own reference when you are navigating the course',
        icon: 'golf-caddy.png'
      },
      {
        text: 'This indicates a golfer that has requested a drink.  You may click on it for more info, or to remove them from the map once they have been served, or for any other reason.',
        icon: 'green-marker.png'
      },
      {
        text: `This icon represents the center point to the course.
          It\'s used to define the general location of the golf course.
          One of it\'s purposes is to validate that a golfer is in-fact on the golf course when submitting a request.
          It also acts as the default map plot-point when you first open the app.
          You may change the positioning of this at any time by dragging it on the map.`,
        icon: 'radar.png'
      }
    ]
  }),

  mounted() {

  },

  methods: {

  }
}
</script>
