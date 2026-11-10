import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;
Alpine.start();

window.initLucide = () => {
    createIcons({ icons });
};

document.addEventListener('DOMContentLoaded', () => {
    window.initLucide();
});
