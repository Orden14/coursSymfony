import './styles/app.css';
import './styles/global.scss';

const $ = require('jquery');
require('bootstrap');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
}); 
