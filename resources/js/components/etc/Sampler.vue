<template>
  <v-flex sm8 md6 lg4>
    <v-card class="my-4 mx-4 d-flex" fluid>
      <div v-for="color in colors">
        <v-btn :color="color"  :key="color">{{ color }}</v-btn>
        <br/>
      </div>
    </v-card>

        <v-card class="mx-4 d-flex py-4">
          <router-link :to="'/'">Back</router-link>
        </v-card>


      <v-card class="mx-4 d-flex py-4">
      <div>
        <h3>Let us test your arithmetic.</h3>
        <p>What is the sum of the two numbers?</p>
        <div class="inline">
          <p>{{ x1 }} + {{ x2 }} =</p> <input v-model="guess"> <button v-on:click="check">Check Answer</button>
        </div>
        <button v-on:click="refresh">Refresh</button>
        <p>{{message}}</p>
      </div>
    </v-card>
  </v-flex>
</template>

<script>


export default {

  data: () => ({
    colors: ['default', 'primary', 'secondary', 'accent', 'info', 'dark', 'warning', 'error', 'light'],
       x1: Math.ceil(Math.random() * 100),
      x2: Math.ceil(Math.random() * 100),
      guess: "",
      message: ""
  }),
  methods: {
    check() {
      if (this.x1 + this.x2 === parseInt(this.guess)) {
        this.message = "SUCCESS!"
      } else {
        this.message = "TRY AGAIN"
      }
    },
    refresh() {
      this.x1 = Math.ceil(Math.random() * 100);
      this.x2 = Math.ceil(Math.random() * 100);
    }
  }
}
</script>
