/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
/* var $ = require('jquery'); ou let $ = require('jquery'); */
let $ = require('jquery'); // ES2017

// require('../css/app.css');
// require('select2');
// OR
// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import  'select2';

/*
$('select').select2();
let $contactButton = $('#contactButton');
$contactButton.click(function (e) {
    e.preventDefault();
    $('#contactForm').slideDown();
    $contactButton.slideUp();
});
*/
// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
