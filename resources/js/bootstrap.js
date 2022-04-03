import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

let encrypted = process.env.MIX_PUSHER_APP_ENCRYPTED == "true" ? true : false;
let forceTLS = process.env.MIX_PUSHER_APP_FORCE_TLS == "true" ? true : false;
console.log("encrypted: " + encrypted + ", forceTLS: " + forceTLS);

var pusher_key = process.env.MIX_PUSHER_APP_KEY; //'3f07d7419a9802071b35';
console.log("key: " + pusher_key);
window.pusher = new Pusher(pusher_key, {
  cluster: 'us2'
});

/*
 * used for a local websockets service (php artisan websockets:serve) instead of pusher.com
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: false,
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssHost: window.location.hostname,
    wssPort: 6001,
    disableStats: true,
    forceTLS: forceTLS,
    enabledTransports: ['ws', 'wss']
});

*/
/* pusher.com creds */

/*
window.Echo = new Echo({
  broadcaster: 'pusher',
  key: pusher_key,
  cluster: 'us2',
  forceTLS: true
});
*/
