<template>
    <span>
      <v-btn  color="success"
              small @click="updateStatus(4)"
              title="Mark Served"
              v-if="mix_playerIsActive()"
              >
        <v-icon small>check</v-icon>
      </v-btn>

     <v-menu
            bottom
            left
          >
      <template v-slot:activator="{ on, attrs }">
              <v-btn
                dark
                v-bind="attrs"
                v-on="on"
                color="dark"
                small
                class="mx-2"
              >
                <v-icon>mdi-menu-down</v-icon>
              </v-btn>
            </template>

            <v-list>
              <v-list-item class="py-0">SET STATUS</v-list-item>
              <v-list-item
                v-for="(item, i) in mix_adminOptions()"
                :key="i"
              >
                <v-btn @click="updateStatus(item.status_id)">{{ item.title }}</v-btn>
              </v-list-item>
            </v-list>
        </v-menu>
      </span>
</template>

<script>
import getStatus from '~/mixins/getStatus'

export default {
    mixins: [getStatus],
    data: () => ({

    }),
    methods: {
      updateStatus(status_id){
        this.$emit('update-status', status_id);
      }
    }
  }
</script>

<style>


</style>
