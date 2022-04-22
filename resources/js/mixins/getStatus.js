export default {
  data: () => ({
    statuses: [
      'Idle', //0
      'Requested', //1
      'Player Cancelled', //2
      'Admin-Cancelled', //3
      'Served', //4
      'Expired', //5
      'Building Order', //6
    ],
    colors: [
      'default',
      'primary',
      'error',
      'error',
      'secondary',
      'dark',
      'warning',
    ]
  }),

  methods: {
    statusName(i){
      return this.statuses[i];
    },
    statusColor(i){
      return this.colors[i];
    }
  }
}
