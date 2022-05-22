<template>
    <v-bottom-sheet
      v-model="showDrawer"

    >
    <v-sheet>
      <v-list-item>
        <v-list-item-avatar>
          <v-img src="https://cdn-icons-png.flaticon.com/512/147/147186.png"></v-img>
        </v-list-item-avatar>

      <v-list-item-title>{{ appName }} </v-list-item-title>

      </v-list-item>
    </v-sheet>
      <v-sheet
        class="text-center"
        >
      <v-divider></v-divider>

      <v-sheet class="my-2 mx-2">
        <slot></slot>
      </v-sheet>

    </v-sheet>

    </v-bottom-sheet>

</template>

<script>
  export default {
    props: ['drawer', 'loading'],
    data () {
      return {
        items: [
          { title: 'Home', icon: 'mdi-view-dashboard' },
          { title: 'About', icon: 'mdi-forum' },
        ],
        appName: process.env.MIX_APP_NAME,
        showDrawer: false
      }
    },
    watch: {
      showDrawer(){
        if(!this.showDrawer){
            this.$emit('update', this.showDrawer);
        }

      },
      drawer(){
        this.showDrawer = this.drawer;
      }
    }
  }
</script>
