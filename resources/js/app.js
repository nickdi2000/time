import 'babel-polyfill'
import Vue from 'vue'

import router from '~/router/index'
import store from '~/store/index'
import App from '$comp/App'
import '~/plugins/index'
import vuetify from '~/plugins/vuetify'
import * as VueGoogleMaps from "vue2-google-maps"

Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyAu2LdngQaedWU8hJx3L80WS_hqEYbDw7A",
    libraries: "places"
  }
});

export const app = new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
