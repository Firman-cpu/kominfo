import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;
Alpine.start();

window.initLucide = () => {
    createIcons({ icons });
};

document.addEventListener('DOMContentLoaded', () => {
    window.initLucide();
});
