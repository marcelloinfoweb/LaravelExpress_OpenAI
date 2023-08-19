import './bootstrap';
import dashboard from "./components/dashboard.js";

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.data('dashboard', dashboard)

Alpine.start();
