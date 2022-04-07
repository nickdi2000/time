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
              this.loading = false
              resolve(pos.coords)
            },
            err => {
              this.loading = false
              reject(err)
              this.$toast.error(err.message)
            }
          )
        }
      })
    }
  }
}
