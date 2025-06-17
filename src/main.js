/**
 * main.js
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Plugins
import { registerPlugins } from '@/plugins'

// Components
import App from './App.vue'
import caixa_dashboard from './components/CaixaDashboard.vue'

// Composables
import { createApp } from 'vue'

// Styles
import 'unfonts.css'

const app = createApp(App)
registerPlugins(app)
app.component( 'caixa_dash',caixa_dashboard)
app.mount('#app')
