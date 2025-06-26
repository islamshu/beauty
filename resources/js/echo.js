import Echo from 'laravel-echo';
import Reverb from '@laravel/reverb';

window.Echo = new Echo({
    broadcaster: 'reverb',
    host: `${import.meta.env.VITE_REVERB_SCHEME ?? 'http'}://${import.meta.env.VITE_REVERB_HOST ?? 'localhost'}:${import.meta.env.VITE_REVERB_PORT ?? 8080}`,
    enabledTransports: ['ws', 'wss'],
});