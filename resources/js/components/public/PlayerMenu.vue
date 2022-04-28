<template>

  <v-overlay opacity="0.8">
    <v-container v-if="showOrder" fluid justify-center>
      <transition-group name="slide-fade">
        <v-btn block class="mb-2" @click="removeItem(i)" color="error" v-for="(o, i) in order" :key="'item-' + i + o.id">
          <v-icon left>{{ o.display_icon }}</v-icon>{{ o.title }}
        </v-btn>
    </transition-group>
    </v-container>

    <v-container fluid justify-center v-else>
      <p> {{ menu.description}} </p>

      <v-sheet elevation="4" class="px-2 py-2" v-if="!selectedType">
        <span v-for="item in menu.items" :key="item.id">
          <span v-if="item.active">
                <v-btn
                    v-if="item.is_category"
                    class="mx-1 my-2"
                    color="warning"
                    @click="selectedType = item"
                    >
                    <v-icon top>{{ item.display_icon}}</v-icon>
                    {{ item.title }}
                  </v-btn>

                  <v-btn
                    v-else
                    class="mx-1 my-2"
                    color="info"
                    @click="addItem(item)"
                    >
                    <v-icon>mdi-plus</v-icon> {{ item.title }}
                  </v-btn>
              </span>
            </span>
      </v-sheet>

      <v-expand-transition>
        <v-sheet elevation="4" class="px-2 py-2 my-0 transition-fast-in-fast-out v-card--reveal" v-if="selectedType">

          <h4>{{ selectedType.title }}</h4>
          <v-btn class="my-2"
                 color="info"
                 @click="addItem(type)"
                 block
                 v-for="type in selectedType.sub_items"
                 :key="type.id">
            <v-icon>mdi-plus-circle</v-icon> {{type.title}}
          </v-btn>

          <v-btn color="dark" class="mt-4" @click="selectedType = null">
            <v-icon>mdi-arrow-left</v-icon> Back
          </v-btn>

        </v-sheet>
      </v-expand-transition>
    </v-container>


      <div class="my-4 py-2 mx-2" v-if="order.length" transition="fade-transition">
        <v-btn color="success" @click="$emit('submit-order')">Submit Order</v-btn>
        <v-btn @click="showOrder = !showOrder" color="info">
          <v-icon>{{ showOrder ? 'mdi-plus' : 'mdi-cart'}}</v-icon> ({{ order.length }}) </v-btn>
          <br/>
          <v-btn v-if="savedOrder.length" class="mt-3" @click="$emit('submit-order')" small>CLOSE</v-btn>
      </div>

  </v-overlay>

</template>

<script>

  import api from '~/api'

  export default {
    props: ['course', 'savedOrder'],
    data: () => ({
      menu: {},
      selectedType: null,
      order: [],
      showOrder: false
    }),
    mounted() {
      this.fetchMenu();
      console.log("saved order:", this.savedOrder);
      //get order from parent if it was already requested
      if(this.savedOrder){
        this.order = this.savedOrder;
      }
    },
    methods: {
      async fetchMenu() {
        const menu = await api.getMenu(this.course.id, true)
        this.menu = menu.data
      },
      async addItem(item) {
        console.log(item)
        this.order.push(item)
      },
      removeItem(index){
        this.order.splice(index,1);
        console.log("length: ", this.order.length);
        if(!this.order.length){
          this.selectedType = null;
          this.showOrder = false;
        }

      }
    },
    watch: {
      order: {
        deep: true,
        handler(){
          console.log("emitting order");
          this.$emit('update-order', this.order)
        }

      }
    }
  }

</script>

<style>

  .slide-fade-enter-active {
    transition: all 0.1s;
  }
  .slide-fade-leave-active {
    transition: all 0.1s cubic-bezier(1, 0.9, 1, 0.1);
  }
  .slide-fade-enter, .slide-fade-leave-to
  /* .slide-fade-leave-active below version 2.1.8 */ {
    transform: translateY(5px);
    opacity: 0;
  }

</style>
