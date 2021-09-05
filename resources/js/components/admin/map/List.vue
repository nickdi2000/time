<template>

  <v-container fluid class="w-100 my-0">
    <v-card v-for="(loc, index) in locations"
            class="mx-auto my-2 "
            outlined
            :key="index">
      <v-list-item three-line>
        <v-list-item-content>
          <v-list-item-title class="text-h4 mb-1">
            <b>{{loc.name}}</b>
          </v-list-item-title>
          <v-list-item-subtitle>
							 <v-alert
						      border="left"
						      colored-border
						      type="success"
						      elevation="2"
						    >
								<v-icon small>mdi-format-quote-open</v-icon>	{{ loc.comments }} <v-icon small>mdi-format-quote-close</v-icon>
						    </v-alert>
					</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-card-actions>
        <v-btn text x-small
               color="primary"
               @click="revealInfo(index)">
          More Details <v-icon>vdi-menu-down</v-icon>
        </v-btn>

      </v-card-actions>

      <v-expand-transition>
        <v-alert v-if="isRevealed(index)"
                 class="transition-fast-in-fast-out v-card--reveal mx-2 px-2 my-2 py-2"
                 color="primary"
                 border="left"
                 elevation="2"
                 colored-border
                 icon="mdi-silverware">
          <div>
            nothing
          </div>

        </v-alert>

      </v-expand-transition>

    </v-card>
  </v-container>

</template>

<script>
import axios from 'axios'

  export default {
    props: ['locations'],
    data() {
      return {
        revealed: null,
      }
    },
    methods: {
      revealInfo(i){
        this.revealed = this.revealed ? null : i;
      },
      isRevealed(i){
        return this.revealed == i;
      }
    }
  }

</script>
