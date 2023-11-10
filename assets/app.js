/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import 'tw-elements';
import 'htmx.org';
window.htmx = require('htmx.org');

// Initialization for ES Users
import {
    Datepicker,
    Collapse,
    Dropdown,
    Input,
    Ripple,
    initTE,
    Carousel
} from "tw-elements";

initTE({ Input, Ripple, Collapse, Dropdown, Carousel, Datepicker });

const datepickerDisableFuture = document.getElementById('datepicker-disable-future');
new Datepicker(datepickerDisableFuture, {
    disableFuture: true
});
