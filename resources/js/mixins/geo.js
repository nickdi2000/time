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
    },
    geo_getDistance(pos1, pos2)
    {
        var lon1 =  pos1.lng * Math.PI / 180;
        var lon2 = pos2.lng * Math.PI / 180;
        var lat1 = pos1.lat * Math.PI / 180;
        var lat2 = pos2.lat * Math.PI / 180;

        // Haversine formula
        let dlon = lon2 - lon1;
        let dlat = lat2 - lat1;
        let a = Math.pow(Math.sin(dlat / 2), 2)
                 + Math.cos(lat1) * Math.cos(lat2)
                 * Math.pow(Math.sin(dlon / 2),2);

        let c = 2 * Math.asin(Math.sqrt(a));

        // Radius of earth in kilometers. Use 3956
        // for miles
        let r = 6371;

        // calculate the result
        let km = c * r;
        let metres = km * 1000;
        return Math.round(metres);
    }
  }
}
