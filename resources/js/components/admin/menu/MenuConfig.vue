<template>

  <v-container fluid class="w-100 my-0">
    <v-card class="px-3 my-2 py-2">
      <v-card-text>
        <div class="mx-auto">
          <ToolTip style="float:right;"
                   :message="helpMessage"
          />
          <span style="width:50%;display:inline;">
                   <v-switch
                    :label="'Activate Menu'"
                    @change="$emit('save-menu')"
                    class="mb-v pb-0"
                    v-model="menu.active"
                ></v-switch>
                </span>
        </div>

        <v-text-field v-model="menu.description"
                      @input="showSave = true"
                      label="Menu Message"
                      v-on:keyup.enter="saveLocalMenu()"
                      hint="Use this if there is a message you would like to communicate to your users regarding the menu">
        </v-text-field>
        <v-btn color="success" @click="saveLocalMenu()" small class="mt-2" v-if="showSave" :loading="loading">
          Save
          <v-icon>mdi-save</v-icon>
        </v-btn>

      </v-card-text>

    </v-card>


    <confirm ref="confirm"></confirm>
  </v-container>

</template>

<script>

  import axios from 'axios'
  import moment from 'moment'
  import api from '~/api'
  import ToolTip from '~/components/admin/shared/ToolTip'
  import confirm from '~/components/partials/Confirm'


  export default {
    props: ['menu', 'user'],
    components: { ToolTip, confirm },
    data() {
      return {
        loading: false,
        showSave: false,
        revealed: null,
        selectedItemObject: {},
        selectedItem: null,
        addFormVisible: false,
        form: {},
      }
    },
    mounted() {
    },
    computed: {
      helpMessage(){
        return `<b>Activate:</b> The app will still allow requests to be made with an inactive menu --
        the users just won\'t be able to select what they want specifically.
        This can be useful when your inventory is low or inconsistent. [NOTE: You can disable the app completely in course settings]
        <br/><br/>
        <b>Message:</b> Use this if there is a message you would like your golfers to see before they make a request
        `

      }
    },
    methods: {
          async saveLocalMenu(){
            this.loading = true;
            await this.$emit('save-menu');
            this.showSave = false;
        },
    }
  }

</script>
