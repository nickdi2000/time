import Axios from 'axios'
import router from './router'
//import store from './store'

  var baseURL = process.env.MIX_API_URL + "/api/";
  console.log("API URL:" , process.env.MIX_API_URL);

  const axios = Axios.create({
      baseURL: baseURL
  });

  const DEBUG = process.env.VUE_APP_ENV !== "production";

axios.interceptors.request.use(request => {
    const api_token = localStorage.getItem('token');

    if (api_token) {
        request.headers.Authorization = 'Bearer ' + api_token;
    }

    return request;
});

axios.interceptors.response.use((response,metrics) => {

			return response;
		},
		error => {
    //if (error.response.status === 401) {
    if (error) {
        //localStorage.removeItem('token');
        //store.commit('unsetUser');
        console.log("Error from API.js", error);
        return error.response;
        /*
        if(router.currentRoute.path != '/'){
          router.push('/');
        }
        */

    }

    return error.response;
});


export default {
     'getApiToken': async function (email, password) {
        const response = await axios.post('auth/token', {
            'email': email,
            'password': password,
            'device_name': 'webapp'
        });

        return response.data;
    },

    getUser: async function () {
        const response = await axios.get('auth/user');

        return response.data.data;
    },
    //login is actually register because its single-use game
    login: async function (data) {
      const response = await axios.post('register', data);
      return response.data;
    },
    saveCourseData: async function (data){
      const response = await axios.put('course/' + data.id, data);
      console.log("api res: ", response);
			//this.$toast.success(res.data.message);
      return response.data;
    },
    getCourseData: async function (id) {
      const response = await axios.get('course/' + id);
      return response.data;
    },
    findClosestCourse: async function (data) {
      //data is location object returned from geoLocate browser
      let coords = {
        longitude: data.longitude,
        latitude: data.latitude
      };
      console.log("thecoords -- ", coords.longitude);
      const response = await axios.post('course/find-closest', coords);
      return response.data;
    },
    updateCourseCoords: async function (id, data) {
      let coords = {
        longitude: data.longitude,
        latitude: data.latitude
      };
      const response = await axios.put('course/' + id, coords);

      return response.data;
    },
    updatePlayer: async function (id, data){
      const response = await axios.put("player/" + id, data);
      return response.data;
    },
    storePlayer: async function (data){
      const response = await axios.post("player/", data);
      return response.data;
    },
    getPlayer: async function (id){
      const response = await axios.get("player/" + id);
      return response;
    },
    deletePlayer: async function (id){
      const response = await axios.delete('player/' + id);
          return response.data;

    },
    createOrUpdateMenu: async function(data){
      //create or update based on if data, should contain courseID
      const response = await axios.post("menu/create", data);
      return response.data;
    },
    getMenu: async function (course_id, hideInactive = false){
      let url = "menu-by-course/" + course_id;
      let data = { hide: hideInactive };
      const response = await axios.post(url, data);
      return response.data;
    },
    deleteMenuItem: async function (id){
      const response = await axios.delete("menu-item/" + id);
      return response.data;
    },
    createMenuItem: async function (data){
      const response = await axios.post("menu-item/create", data);
      return response.data;
    },
    updateMenuItem: async function (data, id){
      const response = await axios.post("menu-item/update/" + id, data);
      return response.data;
    },
    clearAll: async function (course_id){
      const response = await axios.post("clear-all-players/" + course_id);
      return response.data;
    }
};
