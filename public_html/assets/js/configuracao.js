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
})