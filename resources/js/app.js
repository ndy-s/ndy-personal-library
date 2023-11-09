import { createApp, h } from 'vue'
import {createInertiaApp, Head, Link} from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component("Link", Link)
            .component("Head", Head)
            .mount(el)
    },
    progress: {
        delay: 250,
        color: '#68D391',
        includeCSS: true,
        showSpinner: true,
    }
})
