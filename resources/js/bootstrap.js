import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

console.log('KEY:', import.meta.env.VITE_REVERB_APP_KEY);
console.log('HOST:', import.meta.env.VITE_REVERB_HOST);
console.log('PORT:', import.meta.env.VITE_REVERB_PORT);
console.log('SCHEME:', import.meta.env.VITE_REVERB_SCHEME);

window.Echo = new Echo({
    broadcaster: 'reverb',

    key: import.meta.env.VITE_REVERB_APP_KEY,

    wsHost: import.meta.env.VITE_REVERB_HOST,

    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,

    wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,

    forceTLS: false,

    enabledTransports: ['ws', 'wss'],

    withCredentials: true,

    authEndpoint: '/broadcasting/auth',

    auth: {
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute('content')
        }
    }
});

console.log('ECHO READY');