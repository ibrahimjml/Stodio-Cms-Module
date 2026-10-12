import Alpine from '@core/alpine';
import { createPopper } from '@popperjs/core';
import collapse  from '@alpinejs/collapse';

Alpine.plugin(collapse);

if (! window.__alpineStarted) {
    Alpine.start();
    window.__alpineStarted = true;
}

window.createPopper = createPopper;


