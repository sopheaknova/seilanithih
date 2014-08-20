var $ = jQuery.noConflict();

// Detect Mobile Touch Support
var eventClick = 'click';
var eventHover = 'mouseover mouseout';

(function($){
  if ('ontouchstart' in document.documentElement) {
    $('html').addClass('touch');
    eventClick = 'touchon touchend';
    eventHover = 'touchstart touchend';
  } else {
    $('html').addClass('no-touch');
  }
})(jQuery); 



jQuery(document).ready(function($) {

  // Hover plus icon sub-menu  
  $('#nav-container a, .nav-child-container, .mobile-menu-trigger').bind( eventHover, function(event) {
    $(this).toggleClass('hover');    
  });

  // multi-level menu 
  $('.nav-child-container').bind( eventClick, function(event) {
    event.preventDefault();
    var $this = $(this);
    var ul = $this.next('ul');
    var ulChildrenHeight = ul.children().length * 46;

    if(!$this.hasClass('active')){
      $this.toggleClass('active');
      ul.toggleClass('active');
      ul.height(ulChildrenHeight + 'px');
    }else{
      $this.toggleClass('active');
      ul.toggleClass('active');
      ul.height(0);
    }
  });

  /* Sidebar Functionality */
  
  var opened = false;
  $('#menu-trigger').bind(eventClick, function(event) {
    $('#content-container').toggleClass('active');
    $('#sidemenu').toggleClass('active');
    if(opened){
      opened = false;
      setTimeout(function() {
        $('#sidemenu-container').removeClass('active');
      }, 500);
    } else {
      $('#sidemenu-container').addClass('active');
      opened = true;
    }
  });
    
  $('.mobile-nav a').bind('click', function(event) {
    event.preventDefault();
    var path = $(this).attr('href');
    $('#content-container').toggleClass('active');
    $('#sidemenu').toggleClass('active');
    setTimeout(function() {
      window.location = path;
    }, 500);
  });

  // Swipe menu support 
  /*$('.touch-gesture #content').hammer().on('swiperight', function(event) {
    $('#content-container').addClass('active');
    $('#sidemenu').addClass('active');
    if(opened){
      opened = false;
      setTimeout(function() {
        $('#sidemenu-container').removeClass('active');
      }, 500);
    } else {
      $('#sidemenu-container').addClass('active');
      opened = true;
    }
  });
  
  $('.touch-gesture #content').hammer().on('swipeleft', function(event) {
    $('#content-container').removeClass('active');
    $('#sidemenu').removeClass('active');
    if(opened){
      opened = false;
      setTimeout(function() {
        $('#sidemenu-container').removeClass('active');
      }, 500);
    } else {
      $('#sidemenu-container').addClass('active');
      opened = true;
    }
  });*/

  // Check if the child menu has an active item. If yes, then it will expand the menu by default. 
  var $navItems = $('.mobile-nav ul li');

  $navItems.each(function(index){
    if ($(this).hasClass('current-menu-item')) {
      $parentUl = $(this).parent();
      $parentUl.height($parentUl.children('li').length * 46 + "px");
      $parentUl.prev().addClass('active');
      $parentUl.addClass('active');
      $anchor = $parentUl.prev();
      $anchor.children('.nav-child-container').addClass('active');
    }
  });

});