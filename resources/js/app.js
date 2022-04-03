require ('./bootstrap.js');

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
    key: process.env.MIX_GOOGLE_MAPS_KEY,
    libraries: "places"
  }
});
Vue.use(require('vue-moment'));

Vue.prototype.$app_name = process.env.MIX_APP_NAME;
Vue.prototype.$app_url = process.env.MIX_APP_URL;
Vue.prototype.$is_prod = process.env.APP_ENV == "production";

Vue.filter("address", function(address) {
	// call like: <p v-html="this.$options.filters.address(course.address)"></p>
    let addr_string = `<b>Address: </b> ${address.street_number} ${address.locality}
			<br/> <b>Country: </b> ${address.country}
			<br/> <b>Postal: </b> ${address.postal_code}
			<br/> (lon: ${address.longitude}, lat: ${address.latitude})
			`;

    if (address.name) {
        addr_string = `${address.name}: <br /> ${addr_string}`;
    }

    return addr_string;
});

export const app = new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
