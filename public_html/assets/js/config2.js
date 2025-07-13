/*======================================================

	Item Name: Freecart – Ecommerce HTML Lite Template.
	Author: DiversityThemes
	Version: 1.0
	Copyright 2021
	Author URI: https://codecanyon.net/user/diversitythemes

========================================================*/
/*======================================================
[ Table of Contents For CONTAIN JS ]

- Layout
- Bg-skin
- Dark mode

========================================================*/


"use strict";

jQuery(document).ready(function ($) {

/* layout options*/
(function() {
	$('<div class="layout-switcher">'+
	'<a href="#" class="layout-option-box in-out">'+
			'<i class="ti-settings ti-spin"></i>'+
	'</a>'+
	'<div class="option-box-title">'+
			'<h3>Select Layout</h3>'+
		'</div>'+
		'<ul class="layout-panel">'+
		'<li class="layout"><a class="lout" id="layout-1">Boxed (1140px)</a></li>'+
		'<li class="layout"><a class="lout" id="layout-2">Mid Box (1366px)</a></li>'+
		'<li class="layout"><a class="lout" id="layout-3">Mid Box (1440px)</a></li>'+
		'<li class="layout"><a class="lout" id="layout-4">Wide Box (1600px)</a></li>'+
	'</ul>'+
'</div>').appendTo($('body'));
})();

$(".layout-option-box").on("click", function (e) {
	e.preventDefault();
	if ($(this).hasClass("in-out")) {
		$(".layout-switcher").stop().animate({right: "0px"}, 100);
		if ($(".color-option-box").not("in-out")) {
			$(".skin-switcher").stop().animate({right: "-158px"}, 100);
			$(".color-option-box").addClass("in-out");
		}
		if ($(".bg-option-box").not("in-out")) {
			$(".bg-switcher").stop().animate({right: "-158px"}, 100);
			$(".bg-option-box").addClass("in-out");
		}
	} else {
		$(".layout-switcher").stop().animate({right: "-158px"}, 100);
	}
	
	$(this).toggleClass("in-out");
	return false;
	
});

var windows= window.screen.availWidth;

$('#layout-1').on('click', function(e) {
	if (windows >= 1366){
		$('.site-loader').show();
		$(".container").addClass("max-width-1140");
		$(".container").removeClass("max-width-1366");
		$(".container").removeClass("max-width-1440");
		$(".container").removeClass("max-width-1600");
		setTimeout(function(){ $('.site-loader').fadeOut(); }, 1500);
	}else{
		alert('Please check it in 1366 or above screen resolution !!!');
	}
});

$('#layout-2').on('click', function(e) {
	if (windows >= 1366){
		$('.site-loader').show();
		$(".container").addClass("max-width-1366");
		$(".container").removeClass("max-width-1140");
		$(".container").removeClass("max-width-1440");
		$(".container").removeClass("max-width-1600");
		setTimeout(function(){ $('.site-loader').fadeOut(); }, 1500);
	}else{
		alert('Please check it in 1366 or above screen resolution !!!');
	}
});

$('#layout-3').on('click', function(e) {
	if (windows >= 1440){
		$('.site-loader').show();
		$(".container").addClass("max-width-1440");
		$(".container").removeClass("max-width-1366");
		$(".container").removeClass("max-width-1140");
		$(".container").removeClass("max-width-1600");
		setTimeout(function(){ $('.site-loader').fadeOut(); }, 1500);
	}else{
		alert('Please check it in 1440 or above screen resolution !!!');
	}
});

$('#layout-4').on('click', function(e) {
	if (windows >= 1600){
		$('.site-loader').show();
		$(".container").addClass("max-width-1600");
		$(".container").removeClass("max-width-1366");
		$(".container").removeClass("max-width-1440");
		$(".container").removeClass("max-width-1140");
		setTimeout(function(){ $('.site-loader').fadeOut(); }, 1500);
	}else{
		alert('Please check it in 1600 or above screen resolution !!!');
	}
});

/* bg skin */
(function() {
	$('<div class="bg-switcher">'+
	'<a href="#" class="bg-option-box in-out">'+
			'<i class="ti-image"></i>'+
	'</a>'+
	'<div class="option-box-title">'+
			'<h3>Backgroung</h3>'+
		'</div>'+
		'<ul class="bg-panel">'+
		'<li class="bg"><a class="back-bg-1" id="bg-1">Background-1</a></li>'+
		'<li class="bg"><a class="back-bg-2" id="bg-2">Background-2</a></li>'+
		'<li class="bg"><a class="back-bg-3" id="bg-3">Background-3</a></li>'+
		'<li class="bg"><a class="back-bg-4" id="bg-4">Default</a></li>'+
	'</ul>'+
'</div>').appendTo($('body'));
})();

$(".bg-option-box").on("click", function (e) {
	e.preventDefault();
	if ($(this).hasClass("in-out")) {
		$(".bg-switcher").stop().animate({right: "0px"}, 100);
		if ($(".color-option-box").not("in-out")) {
			$(".skin-switcher").stop().animate({right: "-158px"}, 100);
			$(".color-option-box").addClass("in-out");
		}
		if ($(".layout-option-box").not("in-out")) {
			$(".layout-switcher").stop().animate({right: "-158px"}, 100);
			$(".layout-option-box").addClass("in-out");
		}
	} else {
		$(".bg-switcher").stop().animate({right: "-158px"}, 100);
	}
	
	$(this).toggleClass("in-out");
	return false;
	
});
$('.back-bg-1').on('click', function(e) {
	var id = $(this).attr("id");
	$("body").addClass("body-bg-1");
	$("body").removeClass("body-bg-2");
	$("body").removeClass("body-bg-3");
	$("body").removeClass("body-bg-4");
   $("#bg-switcher-css").attr("href", "assets/css/backgrounds/" + id + ".css");
	e.preventDefault();
});
$('.back-bg-2').on('click', function(e) {
	var id = $(this).attr("id");
	$("body").addClass("body-bg-2");  
	$("body").removeClass("body-bg-1");
	$("body").removeClass("body-bg-3");
	$("body").removeClass("body-bg-4");
   $("#bg-switcher-css").attr("href", "assets/css/backgrounds/" + id + ".css");
	e.preventDefault();
});
$('.back-bg-3').on('click', function(e) {
	var id = $(this).attr("id");
	$("body").addClass("body-bg-3");
	$("body").removeClass("body-bg-1");
	$("body").removeClass("body-bg-2");
	$("body").removeClass("body-bg-4");
   $("#bg-switcher-css").attr("href", "assets/css/backgrounds/" + id + ".css");
	e.preventDefault();
});
$('.back-bg-4').on('click', function(e) {
	var id = $(this).attr("id");
	$("body").addClass("body-bg-4");
	$("body").removeClass("body-bg-1");
	$("body").removeClass("body-bg-2");
	$("body").removeClass("body-bg-3");
   $("#bg-switcher-css").attr("href", "assets/css/backgrounds/" + id + ".css");
	e.preventDefault();
});

/* Dark mode */
(function() {
	$('<div class="dark-mode">'+
	'<a href="javascript:void(0)" class="dark-option-box in-out">'+
			'<span class="dark-moon" id="dark-0"></span>'+
	'</a>'+
'</div>').appendTo($('body'));
})();

$('.dark-moon').on('click', function(e) {
	$('.site-loader').show();
	if($(this).hasClass("light-sun")){
		$(this).removeClass('light-sun');	
		$("#dark-css").remove();
	}
	else{  
		$(this).addClass('light-sun');
		$('<link rel="stylesheet" id="dark-css" href="assets/css/dark.css">').appendTo($('head'));
	} 
	e.preventDefault();
	setTimeout(function(){ $('.site-loader').fadeOut(); }, 1000);
});
});