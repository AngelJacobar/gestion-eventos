import './bootstrap';

// Timer
import timer from './sesion';
window.timer = timer;




//Toaster
import '../../vendor/masmerise/livewire-toaster/resources/js';


//Tippy
import tippy from 'tippy.js'
import {delegate} from 'tippy.js';
window.tippy = tippy;

delegate('body', {
    interactive: true,
    allowHTML: true,
    target: '[data-tippy]',
    appendTo: document.body,
    content(reference) {
        const id = reference.getAttribute('data-template');
        if(id) {
            const template = document.getElementById(id);
            if(template){
                return template.innerHTML;
            }
        }
        return reference.getAttribute('data-tippy');
    },
});
