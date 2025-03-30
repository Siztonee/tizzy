import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { ZiggyVue } from 'ziggy-js';
import { createPinia } from 'pinia';
import { Inertia } from '@inertiajs/inertia';
import { useAuthStore } from '@/store/authStore';

import.meta.glob(['../images/**',]);

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    return pages[`./Pages/${name}.vue`];
  },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) });
    const pinia = createPinia();

    app.use(plugin)
       .use(ZiggyVue)
       .use(pinia)
       .mount(el);

    const authStore = useAuthStore();
    if (props.initialPage.props.user) {
      authStore.setUser(props.initialPage.props.user);
    }

    Inertia.on('success', (event) => {
      const authStore = useAuthStore();
      if (event.detail.page.props.user) {
        authStore.setUser(event.detail.page.props.user);
      } else {
        authStore.setUser(null); 
      }
    });
  },
});