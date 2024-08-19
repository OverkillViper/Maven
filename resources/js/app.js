import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import '../../node_modules/flowbite-vue/dist/index.css';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import { definePreset } from '@primevue/themes';
import ToastService from 'primevue/toastservice';
import Toast from 'primevue/toast';
import Tooltip from 'primevue/tooltip';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// PrimeVue Preset
const MavenPreset = definePreset(Aura, {
    semantic: {
        primary: {
            50:  '#5740eb',
            100: '#5740eb',
            200: '#5740eb',
            300: '#5740eb',
            400: '#5740eb',
            500: '#5740eb',
            600: '#5740eb',
            700: '#5740eb',
            800: '#5740eb',
            900: '#5740eb',
            950: '#5740eb'
        },
    },
    components: {
        dialog: {
            colorScheme: {
                light: {
                    title: {
                        fontWeight: '200'
                    }
                },
            }
        }
    }
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                theme: {
                    preset: MavenPreset
                }
            })
            .use(ToastService)
            .component('Toast', Toast)
            .directive('tooltip', Tooltip)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
