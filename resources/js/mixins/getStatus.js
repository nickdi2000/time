export default {
  data: () => ({
    statuses: [
      'Location Not Found', //0
      'At starting Point', //1
      'Not at starting point', //2
      'Racing', // 3
      'At finish line', //4
      'Invalid' //5
    ],
    message: [
      'Location not detected.  Please set your current location.', //0
      'At the starting point. Start when ready!',
      '', //2
      'You are currently racing!', //3
      'You\'re at the finish line!', //4
      'Invalid location.  Please try again' //5

    ],
    colors: [
      'dark',
      'success',
      'warning',
      'accent',
      'info',
      'error',
    ]
  }),

  methods: {
    statusName(){
      return this.statuses[this.locationStatus];
    },
    statusColor(){
      return this.colors[this.locationStatus];
    }

  },
  computed: {
      statusMessage(){
        if (this.locationStatus == 2){
          return `We have detected your location, but you are still
          ${this.distanceToStart} meters away from the starting point.  Please go the starting point and try again.`;
        }
        return this.message[this.locationStatus];
      },
  }
}
