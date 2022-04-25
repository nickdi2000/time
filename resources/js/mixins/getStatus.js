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
      'default', //0
      'info',
      'error', //2
      'warning', //3
      'success', //4
      'dark', //5
      'warning',
    ],
    actives: [0,1,6]
  }),

  methods: {
    statusName(i){
      return this.statuses[i];
    },
    statusColor(i){
      return i ? this.colors[i] : 'info';
    },
    statusType(i){
      return i == 4 ? 'success' : 'info';
    },
    mix_statusList(){
      return this.statuses;
    },
    mix_playerIsActive(i){
      if(this.actives.includes(i) || this.showInactive){
        return true;
      }
    },
    mix_adminOptions(){
      return [
        {
          'title' : 'Cancel',
          'status_id' : 3
        },
        {
          'title' : 'Requested',
          'status_id' : 1
        },
        {
          'title' : 'Expired',
          'status_id' : 5
        },
        {
          'title' : 'Served',
          'status_id' : 4
        }

      ]
    },
    mix_activeCount(){
      let count = 0;
      let active_arr = this.actives;
      this.players.map(x => {
        if (active_arr.includes(x.status_id)){
          count++;
        }
      });
      return count;
    },
    mix_compact(playerObj){
      return _.pick(playerObj, ['id', 'status_id', 'name', 'course_id']);
    }
  }
}
