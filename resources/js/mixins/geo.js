export default {
  data: () => ({

  }),

  methods: {
    async getLocation(){
      return new Promise((resolve, reject) => {
        console.log('getLocation')
        let lat = 0
        let long = 0
        let app = this
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
            pos => {
              app.loading = false
              resolve(pos.coords)
            },
            err => {
              app.loading = false
              console.log("Location err: ", err);
              reject(err)
              app.$toast.error(err.message)
            }
          )
        }
      })
    }
  }
}
