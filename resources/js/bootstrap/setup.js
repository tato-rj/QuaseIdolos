window._ = require('lodash');

require('../_dependencies');

window.axios = require('axios').default;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted:true,
//     forceTLS: true
// });

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '8lPxlQ.lUs9xQ',
    wsHost: 'realtime-pusher.ably.io',
    wsPort: 443,
    disableStats: true,
    encrypted: true,
});
