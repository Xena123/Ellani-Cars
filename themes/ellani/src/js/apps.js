
$('.single-slider').slick({
  dots: true,
  arrows: false,
  autoplay: true
});

$('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
  slidesToShow: 16,
  asNavFor: '.slider-for',
  dots: false,
  centerMode: false,
  focusOnSelect: true,
  arrows: false
});

// CLICK FUNCTION FOR INFO MENU ON SINGLE VEHICLE PAGE
$('.c-single-vehicle__fact-group-header-1').click(function(){
    $('.c-caret-down-1').toggleClass("down"); 
    $('.c-single-vehicle__fact-group-1').toggleClass('u-display-none');
});
$('.c-single-vehicle__fact-group-header-2').click(function(){
    $('.c-caret-down-2').toggleClass("down");
    $('.c-single-vehicle__fact-group-2').toggleClass('u-flex u-flex-space-between u-flex-top');
});
$('.c-single-vehicle__fact-group-header-3').click(function(){
    $('.c-caret-down-3').toggleClass("down");
    $('.c-single-vehicle__fact-group-3').toggleClass('u-flex u-flex-space-between u-flex-top');
});
$('.c-single-vehicle__fact-group-header-4').click(function(){
    $('.c-caret-down-4').toggleClass("down");
    $('.c-single-vehicle__fact-group-4').toggleClass('u-flex u-flex-space-around u-flex-top');
});


// CLICK FUNCTION FOR BOOKING WIDGET TAB
$('.c-booking-widget-tab').click(function(){
    $('.c-booking-widget').toggleClass('u-show');
});

//CLICK FUNCTION FOR MOBILE VIEW MENU
$('.c-menu-trigger').click(function(){
    $('.c-mobile-nav-wrap').toggleClass('u-show-menu');
    $('.c-menu-trigger').toggleClass('u-move-button');
});
// Classie.js

/*!
 * classie v1.0.1
 * class helper functions
 * from bonzo https://github.com/ded/bonzo
 * MIT license
 * 
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true, unused: true */
/*global define: false, module: false */

( function( window ) {

'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

function classReg( className ) {
  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
}

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
var hasClass, addClass, removeClass;

if ( 'classList' in document.documentElement ) {
  hasClass = function( elem, c ) {
    return elem.classList.contains( c );
  };
  addClass = function( elem, c ) {
    elem.classList.add( c );
  };
  removeClass = function( elem, c ) {
    elem.classList.remove( c );
  };
}
else {
  hasClass = function( elem, c ) {
    return classReg( c ).test( elem.className );
  };
  addClass = function( elem, c ) {
    if ( !hasClass( elem, c ) ) {
      elem.className = elem.className + ' ' + c;
    }
  };
  removeClass = function( elem, c ) {
    elem.className = elem.className.replace( classReg( c ), ' ' );
  };
}

function toggleClass( elem, c ) {
  var fn = hasClass( elem, c ) ? removeClass : addClass;
  fn( elem, c );
}

var classie = {
  // full names
  hasClass: hasClass,
  addClass: addClass,
  removeClass: removeClass,
  toggleClass: toggleClass,
  // short names
  has: hasClass,
  add: addClass,
  remove: removeClass,
  toggle: toggleClass
};

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( classie );
} else if ( typeof exports === 'object' ) {
  // CommonJS
  module.exports = classie;
} else {
  // browser global
  window.classie = classie;
}

})( window );

function init() {
    window.addEventListener('scroll', function(e){
        var distanceY = window.pageYOffset || document.documentElement.scrollTop,
            shrinkOn = 300,
            header = document.querySelector("header");
        if (distanceY > shrinkOn) {
            classie.add(header,"smaller");
        } else {
            if (classie.has(header,"smaller")) {
                classie.remove(header,"smaller");
            }
        }
    });
}
window.onload = init();


// --- End Classie.js
