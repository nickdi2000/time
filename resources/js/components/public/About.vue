<template>
  <v-content>
    <v-container fluid justify-center class="my-4">
      <v-card fluid class="mx-3 py-2 px-3">
        <v-container class="mx-auto">
          <h1>{{$app_name}}</h1>
          <p><i>Connecting golfers with cart attendants, in just a few easy ‘clicks’⛳</i></p>
        </v-container>
        <v-alert raised>
          {{$app_name}} is a browser-based app (meaning users don’t need to download an application on their phone) that easily and efficiently connects cart attendants to golfers out on the course. When a golfer is hungry or thirsty, they simply scan a QR code to bring up CaddySnack and ding a virtual ‘bell’. This will then notify the cart attendants where they are being requested. The result? Happy golfers and increased purchases. It’s a hole in one! We provide the easy-to-use app for your golfers and attendants to use on their own phones, and all you have to do is choose where to put our QR code stickers — whether on your scorecards, at the front desk, or wherever else.
          <br/>
          <v-btn color="default" class="my-4">Sign-up</v-btn>
        </v-alert>


      </v-card>



	  </v-container>
				<PublicFooter />
	  </v-content>
</template>

<script>
import PublicFooter from '$comp/ui/PublicFooter';

export default {
  components: {PublicFooter}
}
</script>
