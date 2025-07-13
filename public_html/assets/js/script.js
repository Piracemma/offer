/*======================================================

	Item Name: Freecart – Ecommerce HTML Lite Template.
	Author: Ashish Maraviya
	Version: 1.0
	Copyright 2021

========================================================*/
/*======================================================
[ Table of Contents For CONTAIN JS ]

- Page Loader
- On responsive media window reload
- On Page Load Modal on page - HOME
- Send mail on contact us page
- Close top discount nav js
- On Site Load Modal Window - HOME
- Top Navbar Menu - HOME
- Search button Full Screen Modal Window - HOME
- On Cart Click Toggle Right Sidebar - HOME
- Product-Slider On Main Page - Home
- Product-Filter As Per Cateogry On Main Page - Home
- Product gallery js - Product gallery page
- Category | Brand | Blog | Instagram Slider - Home
- New Product Slider On Shop Product Page
- Add To Cart Toast up - Common
- Scroll to Top - Common
- Light Box Image On Click Preview - Common
========================================================*/

"use strict";

/*-------------------------------------------------------------------
	Page Loader
-------------------------------------------------------------------*/

$(window).on('load', function () {
	$('.site-loader').fadeOut();
});

$(window).on('resize', function() {
	var screenlarge = screen.width;
	if (screenlarge >= 992) {
		$('.site-loader').show();
		setTimeout(function () {
			$('.site-loader').fadeOut();
		}, 500);
	}
});

jQuery(document).ready(function ($) {

	/*-------------------------------------------------------------------
		Send Mail
	-------------------------------------------------------------------*/
	
	$("#subscribe_btn").on("click", function send_mail()
	{
		var user_name = $("#user_name").val();	
		var user_email = $("#user_email").val();	
		var user_message = $("#user_message").val();	
		var valid_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;	
		
		if(user_name == "" || user_message == "" || user_email == "")
		{ 
			$('#warning').hide();
			$('#success').hide();
			$('#require').fadeIn();	
			setTimeout(function wait()
			{
				$('#require').fadeOut(); 
			}, 3000);	
		}
		else if(valid_email.test(user_email) == false)
		{
			$('#success').hide();
			$('#require').hide();	
			$('#warning').fadeIn();	
			setTimeout(function wait()
			{
				$('#warning').fadeOut(); 
			}, 3000);
		}
		else
		{
			$('#warning').hide();
			$('#success').hide();
			$('#require').hide();
			
			$.ajax({
				type: "POST", 
				data:{email:user_email, name:user_name, message:user_message},
				url: "https://loopinfosol.in/template_monster/ashish/freecart/assets/mail/send_mail_controller.php",
				success: function(result){
					
					if(result == 1)
					{
						$('#user_name').val('');
						$('#user_email').val('');
						$('#user_message').val('');
						
						$('#success').fadeIn();
						setTimeout(function wait()
						{
							$('#success').fadeOut();		
						}, 3000);				
					}
					else
					{
						$('#failed').fadeIn();
						setTimeout(function wait()
						{
							$('#failed').fadeOut();		
						}, 3000);	
					}					
				}
			});
		}
	});

	/*-------------------------------------------------------------------
		Top Navbar Menu - HOME
	-------------------------------------------------------------------*/
	// On Hove of Each of The Menu iCon
	$('.md-dropdown').hover(
		function () {
			var screenlarge = screen.width;
			if (screenlarge >= 992) {
				$(".md-dropdown-menu").removeAttr("style");
				$(".column-list").removeAttr("style");

				$(this).children('.md-dropdown-menu').addClass('md-dropdown-menu-show');
				$('.md-dropdown:has(.md-dropdown-menu-show)').addClass('menu-active');
				$(this).find('.ti-angle-down').addClass('drop-icon');
			}
		},
		function () {
			var screenlarge = screen.width;
			if (screenlarge >= 992) {
				$(".md-dropdown-menu").removeAttr("style");
				$(".column-list").removeAttr("style");
				$(this).children('.md-dropdown-menu').removeClass('md-dropdown-menu-show');
				$('.md-dropdown:not(.md-dropdown-menu-show)').removeClass('menu-active');
				$(this).find('.ti-angle-down').removeClass('drop-icon');
			}
		}
	)

	// On Hove of Each of The Sub-Menu iCon
	$('.md-sub-dropdown').hover(
		function () {
			var screenlarge = screen.width;
			if (screenlarge >= 992) {
				$(".md-dropdown-menu").removeAttr("style");
				$(".column-list").removeAttr("style");
				$(".md-submenu").removeAttr("style");
				$(this).children('.md-submenu').addClass('md-submenu-show');
				$('.md-sub-dropdown:has(.md-submenu-show)').addClass('sub-menu-active');				
				$(this).parent().find('>.md-submenu').removeClass('sub-drop-open');
				$('.md-sub-dropdown .dropdown-list').parent().find('>.md-submenu').removeClass('sub-drop-open');
			}
		},
		function () {
			var screenlarge = screen.width;
			if (screenlarge >= 992) {
				$(".md-dropdown-menu").removeAttr("style");
				$(".column-list").removeAttr("style");
				$(".md-submenu").removeAttr("style");
				$(this).children('.md-submenu').removeClass('md-submenu-show');
				$(this).parent().children('.md-sub-dropdown:not(.md-submenu-show)').removeClass('sub-menu-active');
				$(this).find('.ti-angle-right').removeClass('sub-drop-icon');
				$('.md-sub-dropdown .dropdown-list').parent().find('>.md-submenu').removeClass('sub-drop-open');
			}
		}
	)

	// For Smaller Device Size
	$('.md-nav-link').on('click', function (e) {
		var screen_size = screen.width;
		if (screen_size <= 991) {
			$('.md-submenu').removeClass('sub-drop-open');
			$('.md-sub-dropdown').removeClass('sub-menu-active');

			var is_class = $(this).parent().find('.md-dropdown-menu').hasClass('drop-open');
			if (is_class) {
				$(this).parent().find('.md-dropdown-menu').removeClass('drop-open');
			} else {
				$(this).parent().find('.md-dropdown-menu').addClass('drop-open');
			}
		}
	});

	$('.md-dropdown').on('click', function (e) {
		var screen_size = screen.width;
		if (screen_size <= 991) {
			var is_class = $(this).parent().find('.md-dropdown-menu').hasClass('drop-open');
			if (is_class) {

				$(this).siblings().find('.md-dropdown-menu').slideUp();
				$(this).siblings().find('.md-dropdown-menu').removeClass('drop-open');
				$(this).find('.md-dropdown-menu').slideDown();
				// console.log('first');

				$('.md-dropdown:has(.drop-open)').addClass('menu-active');
				$(this).siblings().removeClass('menu-active');

				$(this).siblings().find('.md-submenu').slideUp();
				$(this).siblings().find('.column-list').slideUp();
			} else {
				$(this).parent().find('.md-dropdown-menu').slideUp();
				console.log('second');
				$('.column-list').slideUp();
				$('.md-submenu').slideUp();
			}
		}
	});

	// Sub-Navbar Onclick Event
	$('.md-sub-dropdown .dropdown-list').on('click', function (e) {
		var screen_size = screen.width;
		if (screen_size <= 991) {

			$(this).parent().find('>.md-submenu').slideDown();
			var is_class = $(this).parent().find('>.md-submenu').hasClass('sub-drop-open');
			if (is_class) {
				$(this).parent().removeClass('sub-menu-active');
				$(this).parent().find('>.md-submenu').slideUp();
				$(this).parent().find('>.md-submenu').removeClass('sub-drop-open');			
			} else {
				$(this).parent().addClass('sub-menu-active');
				$(this).parent().find('>.md-submenu').slideDown();	
				$(this).parent().find('>.md-submenu').addClass('sub-drop-open');	
			}
		}
	});

	// Dropdown Item Title On Click Event
	$('.dropdown-item-title').on('click', function (e) {
		var screen_size = screen.width;
		if (screen_size <= 991) {
			$('.dropdown-item-title').siblings('.column-list').stop().slideUp();
			$(this).parent().find('>.column-list').stop().slideToggle();
		}
	});

	// Mega Menu Navbar
	$('.navbar-toggler-btn').on('click', function (e) {
		var screen_size = screen.width;
		if (screen_size <= 991) {
			$('.menu-bar-overlay').fadeIn();
			$('.mega-navbar').addClass('mega-navbar-show');
			$(this).parent().addClass('menu-bar-index');
		}
	});

	$('.menu-bar-overlay, .nav-cls').on('click', function (e) {
		var screen_size = screen.width;
		if (screen_size <= 991) {
			$('.menu-bar-overlay').fadeOut();
			$('.mega-navbar').removeClass('mega-navbar-show');
			setTimeout(function () {
				$('.menu-bar').removeClass('menu-bar-index');
			}, 300);
		}
	});

	// Menu hover tooltips
	$('[data-toggle="tooltip"]').tooltip();

	/*------------------------------------------------------------------
		Search button Full Screen Modal Window - HOME
	------------------------------------------------------------------*/

	$('.search-toggle-btn').on('click', function (e) {
		$('.search-panel-full').slideDown();
		$('body').css("overflow", "hidden");
	})

	$('.search-close').on('click', function (e) {
		$('.search-panel-full').slideUp();
		$('body').css("overflow", "auto");
	})

	/*------------------------------------------------------------------
		On Cart Click Toggle Right Sidebar - HOME 
	------------------------------------------------------------------*/

	$(".toggle-cart").on("click", function () {
		$(".toggle-cart-bar").fadeIn();
		$(".cart-bar").addClass("toggle-cart-swipe");
	});

	$(".cart-bar-cls-btn").on("click", function () {
		$(".cart-bar").removeClass("toggle-cart-swipe");
		$(".toggle-cart-bar").fadeOut();
	});

	$(".toggle-cart-bar").on("click", function () {
		$(".cart-bar").removeClass("toggle-cart-swipe");
		$(".toggle-cart-bar").fadeOut();
	});

	/*------------------------------------------------------------------
		New Product-Slider On Main Page - Home
	------------------------------------------------------------------*/
	$('.new-slider').slick({
		dots: false,
		infinite: true,
		speed: 600,
		slidesToShow: 4,
		slidesToScroll: 1,
		adaptiveHeight: true,
		arrows: true,
		autoplay: true,
		autoplaySpeed: 2000,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 4,
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					arrows: false,
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					arrows: false,
				}
			}
		]
	});


	/*------------------------------------------------------------------
		Product tab Slider On Main Page - Home
	------------------------------------------------------------------*/
	$('.product-items-active').slick({
		dots: false,
		infinite: true,
		speed: 600,
		slidesToShow: 3,
		slidesToScroll: 1,
		adaptiveHeight: true,
		arrows: true,
		autoplay: true,
		autoplaySpeed: 2000,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					arrows: false,
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					arrows: false,
				}
			}
		]
	});

	/*------------------------------------------------------------------
		Product-Filter As Per Cateogry On Main Page - Home
	------------------------------------------------------------------*/

	$('.products-row ul li').on("click", function () {
		$('.products-row ul li').removeClass('active');
		$(this).addClass('active');

		var data = $(this).attr('data-filter');

		if ('.newproduct' == data) {

			if ($(data).hasClass('newproduct relatedproducts') || $(data).hasClass('newproduct bestsellers')) {
				$('.newproduct').fadeIn();
			} else {
				$('.relatedproducts').hide();
				$('.bestsellers').hide();
				$('.newproduct').fadeIn();
			}

		} else if ('.relatedproducts' == data) {

			if ($(data).hasClass('relatedproducts newproduct') || $(data).hasClass('relatedproducts bestsellers')) {
				$('.relatedproducts').fadeIn();
			} else {
				$('.newproduct').hide();
				$('.bestsellers').hide();
				$('.relatedproducts').fadeIn();
			}

		} else if ('.bestsellers' == data) {

			if ($(data).hasClass('bestsellers relatedproducts') || $(data).hasClass('bestsellers newproduct')) {
				$('.bestsellers').fadeIn();
			} else {
				$('.newproduct').hide();
				$('.bestsellers').fadeIn();
				$('.relatedproducts').hide();
			}

		}
	});


	//shopping cart
	(function () {
		$("#cart").on("click", function () {
			$(".shopping-cart").fadeToggle("fast");
		});
	})();

	/*------------------------------------------------------------------
		Product gallery js - Product gallery page
	------------------------------------------------------------------*/
	$('.popup-gallery').magnificPopup({
		type: 'image',
		mainClass: 'mfp-with-zoom',
		gallery: {
			enabled: true,
		},
		zoom: {
			enabled: true,
			duration: 300,
			easing: 'ease-in-out',
			opener: function (openerElement) {
				return openerElement.is('img') ? openerElement : openerElement.find('img');
			}
		}
	});

	/*------------------------------------------------------------------
		Category | Brand | Blog | Instagram Slider - Home
	------------------------------------------------------------------*/
	// Category banner Slider
	$('.category-banner-slider').slick({
		dots: false,
		infinite: true,
		speed: 600,
		slidesToShow: 3,
		slidesToScroll: 1,
		adaptiveHeight: true,
		arrows: true,
		autoplay: true,
		autoplaySpeed: 2000,
		responsive: [
			{
				breakpoint: 1921,
				settings: {
					slidesToShow: 4,
				}
			},
			{
				breakpoint: 1367,
				settings: {
					slidesToShow: 4,
				}
			},
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 4,
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					arrows: false,
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 2,
					arrows: false,
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					arrows: false,
				}
			},
		]
	});

	// Brand Slider
	$('.customer-logos').slick({
		slidesToShow: 6,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 3000,
		arrows: false,
		dots: false,
		pauseOnHover: false,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 4
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 3
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 2
				}
			}]
	});

	// Blog Slider
	$('#blog-carousel').slick({
		dots: false,
		infinite: true,
		speed: 600,
		slidesToShow: 3,
		slidesToScroll: 1,
		adaptiveHeight: true,
		arrows: true,
		autoplay: true,
		autoplaySpeed: 1500,
		responsive: [
			{
				breakpoint: 1366,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					arrows: false,
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					arrows: false,
				}
			}
		]
	});

	// Instagram Slider
	$('.insta-post').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 3000,
		arrows: false,
		dots: false,
		pauseOnHover: false,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 4
				}
			},
			{
				breakpoint: 820,
				settings: {
					slidesToShow: 3
				}
			},

			{
				breakpoint: 767,
				settings: {
					slidesToShow: 2
				}
			}]
	});
	// insta slider 2
	$('.insta-post-2').slick({
		slidesToShow: 6,
		slidesToScroll: 1,
		autoplay: true,
		autoplaySpeed: 3000,
		arrows: false,
		dots: false,
		pauseOnHover: false,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 4
				}
			},
			{
				breakpoint: 820,
				settings: {
					slidesToShow: 3
				}
			},

			{
				breakpoint: 767,
				settings: {
					slidesToShow: 2
				}
			}]
	});

	/*------------------------------------------------------------------
		New Product Slider On Shop Product Page
	------------------------------------------------------------------*/

	// Filter Icon OnClick Open Cart Toggle Sidebar
	$(".sidebar-toggle-icon").on("click", function () {
		$(".toggle-side-bar").fadeIn();
		$(".sidebar-wrapper").addClass("toggle-sidebar-swipe");
	});
	$(".side-bar-cls-btn").on("click", function () {
		$(".sidebar-wrapper").removeClass("toggle-sidebar-swipe");
		$(".toggle-side-bar").fadeOut();
	});
	$(".toggle-side-bar").on("click", function () {
		$(".sidebar-wrapper").removeClass("toggle-sidebar-swipe");
		$(".toggle-side-bar").fadeOut();
	});

	var product_count = $('.cart-bar-body .product-card').length;

	$(".remove-product").on("click", function () {
		$(this).closest(".product-card").remove();

		if (product_count == 1) {
			$('.cart-bar-body').html('<div class="product-card"><p class="emp-msg">Your cart is empty!</p></div>');
		}
		product_count--;
	});

	/*------------------------------------------------------------------
		On Remove iCon Click Remove Item - CART PAGE 
	------------------------------------------------------------------*/

	// var product_count = $('.cart-bar-body .product-card').length;

	var cart_product_count = $('.cart-table-borderless tbody tr').length;

	$(".mobie-cart-none span").on("click", function () {
		$(this).closest("tr").remove();
		if (cart_product_count == 1) {
			$('.cart-table-borderless tbody').html('<tr><td class="emp-cart-msg">Your cart is empty!</td></tr>');
		}
		cart_product_count--;
	});


	// Sidebar New Product Sldier	
	jQuery("#new-product-slider").owlCarousel({
		autoplay: false,
		lazyLoad: true,
		rewind: true,
		margin: 45,
		responsiveClass: true,
		autoplayTimeout: 7000,
		smartSpeed: 800,
		dots: false,
		nav: true,
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 1
			},
			1024: {
				items: 1
			},
			1366: {
				items: 1
			}
		}
	});

	// Price Range Slider
	$(function () {

		$("#slider-range").slider({
			range: true,
			min: 0,
			max: 100,
			values: [10, 90],
			slide: function (event, ui) {
				$("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
			}
		});

		$("#amount").val("$" + $("#slider-range").slider("values", 0) +
			" - $" + $("#slider-range").slider("values", 1));
	});

	//	Product Grid | List View
	$(".grid-product .grid-menu").on("click", function () {
		$('.product-grid-list').removeClass('grid-view list-view').addClass($(this).data('view'));
	})

	// Product Image On Hover Zoom In/Out
	$(function () {
		$('.zoom-image').each(function () {
			var originalImagePath = $(this).find('img').data('original-image');
			$(this).zoom({
				url: originalImagePath,
				magnify: 1
			});
		});
	});

	$(function () {
		$('.add').on('click', function () {
			var $qty = $(this).closest('p').find('.qty');
			var currentVal = parseInt($qty.val());
			if (!isNaN(currentVal)) {
				$qty.val(currentVal + 1);
			}
		});
		$('.minus').on('click', function () {
			var $qty = $(this).closest('p').find('.qty');
			var currentVal = parseInt($qty.val());
			if (!isNaN(currentVal) && currentVal > 0) {
				$qty.val(currentVal - 1);
			}
		});
	});

	// Thumbnail
	/*var urls = [
		'assets/img/product/g-p4.jpg',
		'assets/img/product/g-p11.jpg',
		'assets/img/product/g-p12.jpg'
	];

	var options = {
		//thumbLeft:true,
		//thumbRight:true,
		//thumbHide:true,
		//width:300,
		//height:500,
	};

	$('#image-thumbnail').zoomy(urls, options);*/

	

	//GERAR IMAGENS ABA PRODUTO

	/*$.ajax({
		url: 'product-img.php',
		method: 'GET',
		dataType: 'json',
		success: function(data) {
			var urls = data.caminho;
			$('#image-thumbnail').zoomy(urls);//ver se consigo passar direto atraves de declarar uma variavel js e incluir o php como valor
		}
	});*/


	if (typeof viewId !== 'undefined') {
		let uri = '/produto_img?id=' + viewId;
		$.ajax({
			url: uri,
			method: 'GET',
			dataType: 'json',
			success: function(data) {               
				var urls = data.caminho;
				$('#image-thumbnail').zoomy(urls);
			}
		});
	}
	

	//FIM GERAR IMAGEM
	



	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-36251023-1']);
	_gaq.push(['_setDomainName', 'jqueryscript.net']);
	_gaq.push(['_trackPageview']);

	/*------------------------------------------------------------------
		Wishlist Page - product remove
	------------------------------------------------------------------*/
	$(".delete").on("click", function () {
		$(this).closest('.remove-product').fadeOut();
	});

	/*------------------------------------------------------------------
		Accordion Collapse In FAQ Page
	------------------------------------------------------------------*/

	var vendasVendedor = document.getElementById("vendas-vendedor");

if (vendasVendedor) {

	function buscarVendas() {
		$.ajax({
		url: '/api_vendas',
		method: 'GET',
		success: function(data) {
			// Atualize o conteúdo do elemento com o ID "vendas-container" com o HTML retornado.
			$('#vendas-vendedor').html(data);
		},
		error: function(xhr, status, error) {
			console.error(error); // Trate erros, se necessário
		}
		});
	}

	function verificarPendentes() {
		var retorno;
		$.ajax({
			url: '/api_venda_pendente',
			method: 'GET',
			success: function(data) {

				if(data == 'true') {

					buscarVendas();
		
				}
				
			}
		})

	}

	buscarVendas();

	setInterval(verificarPendentes, 60000);

}

	// Accordion Active
	var acc = document.getElementsByClassName("accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function () {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			if (panel.style.maxHeight) {
				panel.style.maxHeight = null;
			} else {
				panel.style.maxHeight = panel.scrollHeight + "px";
			}
		});
	}

	/*------------------------------------------------------------------
		Add To Cart Toast up - Common
	------------------------------------------------------------------*/
	$(".cart-like-search .ti-shopping-cart").on("click", function (e) {

		var msg = 'item added to your cart.';
		$.notify({
			message: "<b>Success ! </b>" + msg

		}, {
			type: 'success',
			timer: 300
		});
	});

	$(".cart-like-search .ti-heart").on("click", function (e) {

		var msg = 'item added to your wishlist.';
		$.notify({
			message: "<b>Success ! </b>" + msg

		}, {
			type: 'info',
			timer: 300
		});
	});

	/*------------------------------------------------------------------
		Scroll to Top - Common
	------------------------------------------------------------------*/
	// Scroll UP
	$(window).scroll(function () {
		if ($(this).scrollTop() > 50) {
			$('.up-scroll:hidden').stop(true, true).fadeIn();
		} else {
			$('.up-scroll').stop(true, true).fadeOut();
		}
	});

	// Scroll UP
	$(function () { $(".scroll").on("click", function () { $("html,body").animate({ scrollTop: $(".top").offset().top }, "1000"); return false }) })

	/*------------------------------------------------------------------
		Light Box Image On Click Preview - Common
	------------------------------------------------------------------*/
	//light box product page
	class ImageViewer {
		constructor(selector) {
			this.selector = selector;
			$(this.secondaryImages).on("click", () => this.setMainImage(event));
			$(this.mainImage).on("click", () => this.showLightbox(event));
			$(this.lightboxClose).on("click", () => this.hideLightbox(event));
		}

		get secondaryImageSelector() {
			return '.secondary-image';
		}

		get mainImageSelector() {
			return '.main-image';
		}

		get lightboxImageSelector() {
			return '.lightbox';
		}

		get lightboxClose() {
			return '.lightbox-controls-close';
		}

		get secondaryImages() {
			var secondaryImages = $(this.selector).find(this.secondaryImageSelector).find('img')
			return secondaryImages;
		}

		get mainImage() {
			var mainImage = $(this.selector).find(this.mainImageSelector);
			return mainImage;
		}

		get lightboxImage() {
			var lightboxImage = $(this.lightboxImageSelector);
			return lightboxImage;
		}

		setLightboxImage(event) {
			var src = this.getEventSrc(event);
			this.setSrc(this.lightboxImage, src);
		}

		setMainImage(event) {
			var src = this.getEventSrc(event);
			this.setSrc(this.mainImage, src);
		}

		getSrc(node) {
			var image = $(node).find('img');
		}

		setSrc(node, src) {
			var image = $(node).find('img')[0];
			image.src = src;
		}

		getEventSrc(event) {
			return event.target.src;
		}

		showLightbox(event) {
			this.setLightboxImage(event);
			$(this.lightboxImageSelector).addClass('show');
		}

		hideLightbox() {
			$(this.lightboxImageSelector).removeClass('show');
		}
	}

	new ImageViewer('.image-viewer');

	/*------------------------------------------------------------------
		Popup de novidade
	------------------------------------------------------------------*/
	setTimeout(function () {
		$(".recent-purchase").stop().slideToggle('slow');
	  }, 15000);
	$(".recent-close").click(function () {
		$(".recent-purchase").stop().slideToggle('slow');
	});

	/*------------------------------------------------------------------
		Whatsapp chat
	------------------------------------------------------------------*/

	$(document).ready(function () {
		// chat widget open/close duration
		$('wc-style1').launchBtn({ openDuration: 400, closeDuration: 300 });
	});

	// chat panel open/close function
	(function ($) {
		'use strict';

		$.fn.launchBtn = function (options) {
			var mainBtn, panel, clicks, settings, launchPanelAnim, closePanelAnim, openPanel, boxClick;

			mainBtn = $(".wc-button");
			panel = $(".wc-panel");
			clicks = 0;

			//default settings
			settings = $.extend({
				openDuration: 600,
				closeDuration: 200,
				rotate: true
			}, options);

			//Open panel animation
			launchPanelAnim = function () {
				panel.animate({
					opacity: "toggle",
					height: "toggle"
				}, settings.openDuration);
			};

			//Close panel animation
			closePanelAnim = function () {
				panel.animate({
					opacity: "hide",
					height: "hide"
				}, settings.closeDuration);
			};

			//Open panel and rotate icon
			openPanel = function (e) {
				if (clicks === 0) {
					if (settings.rotate) {
						$(this).removeClass('rotateBackward').toggleClass('rotateForward');
					}

					launchPanelAnim();
					clicks++;
				} else {
					if (settings.rotate) {
						$(this).removeClass('rotateForward').toggleClass('rotateBackward');
					}

					closePanelAnim();
					clicks--;
				}
				e.preventDefault();
				return false;
			};

			//Allow clicking in panel
			boxClick = function (e) {
				e.stopPropagation();
			};

			//Main button click
			mainBtn.on('click', openPanel);

			//Prevent closing panel when clicking inside
			panel.click(boxClick);

			//Click away closes panel when clicked in document
			$(document).click(function () {
				closePanelAnim();
				if (clicks === 1) {
					mainBtn.removeClass('rotateForward').toggleClass('rotateBackward');
				}
				clicks = 0;
			});
		};
	}(jQuery));
	/*(function () {
		$('<div class="skin-switcher">' +
			'<a href="#" class="color-option-box in-out">' +
			'<i class="ti-palette ti-spin"></i>' +
			'</a>' +
			'<div class="option-box-title">' +
			'<h3>Select Color</h3>' +
			'</div>' +
			'<ul>' +
			'<li class="colors"><span class="skin-color" id="skin-1"></span></li>' +
			'<li class="colors"><span class="skin-color" id="skin-2"></span></li>' +
			'<li class="colors"><span class="skin-color" id="skin-3"></span></li>' +
			'<li class="colors"><span class="skin-color" id="skin-4"></span></li>' +
			'<li class="colors"><span class="skin-color" id="skin-5"></span></li>' +
			'<li class="colors"><span class="skin-color" id="skin-6"></span></li>' +
			'</ul>' +
			'</div>').appendTo($('body'));
	})();*/

	/*$(".color-option-box").on("click", function (e) {
		e.preventDefault();
		if ($(this).hasClass("in-out")) {
			$(".skin-switcher").stop().animate({ right: "0px" }, 100);
			if ($(".layout-option-box").not("in-out")) {
				$(".layout-switcher").stop().animate({ right: "-158px" }, 100);
				$(".layout-option-box").addClass("in-out");
			}
			if ($(".bg-option-box").not("in-out")) {
				$(".bg-switcher").stop().animate({ right: "-158px" }, 100);
				$(".bg-option-box").addClass("in-out");
			}
		} else {
			$(".skin-switcher").stop().animate({ right: "-158px" }, 100);
		}

		$(this).toggleClass("in-out");
		return false;

	});*/

	/*$('.skin-color').on('click', function (e) {

		$('.site-loader').show();

		var id = $(this).attr("id");
		$("#skin-switcher-css").attr("href", "assets/css/colors/" + id + ".css");
		e.preventDefault();

		setTimeout(function () { $('.site-loader').fadeOut(); }, 1000);
	});*/

	/*----------------------------- Color Hover To Image Change -------------------------------- */

	var $ecproduct = $('.fc-product-tab,.shop-pro-inner,.fc-new-product,.fc-releted-product,.fc-checkout-pro').find('.fc-opt-swatch');

	function initChangeImg($opt) {
		$opt.each(function () {
			var $this = $(this),
				ecChangeImg = $this.hasClass('fc-change-img');

			$this.on('mouseenter', 'li', function () {
				var $this = $(this);
				var $load = $(this).find('a');

				var $proimg = $this.closest('.fc-product-inner').find('.fc-pro-image');

				if (!$load.hasClass('loaded')) {
					$proimg.addClass('pro-loading');
				}

				var $loaded = $(this).find('a').addClass('loaded');

				$this.addClass('active').siblings().removeClass('active');
				if (ecChangeImg) {
					hoverAddImg($this);
				}
				setTimeout(function () {
					$proimg.removeClass("pro-loading");
				}, 1000);
				return false;
			});


		});
	}

	function hoverAddImg($this) {
		var $optData = $this.find('.fc-opt-clr-img'),
			$opImg = $optData.attr('data-src'),
			$opImgHover = $optData.attr('data-src-hover') || false,
			$optImgWrapper = $this.closest('.fc-product-inner').find('.fc-pro-image'),
			$optImgMain = $optImgWrapper.find('.image img.main-image'),
			$optImgMainHover = $optImgWrapper.find('.image img.hover-image');
		if ($opImg.length) {
			$optImgMain.attr('src', $opImg);
		}
		if ($opImg.length) {
			var checkDisable = $optImgMainHover.closest('img.hover-image');
			$optImgMainHover.attr('src', $opImgHover);
			if (checkDisable.hasClass('disable')) {
				checkDisable.removeClass('disable');
			}
		}
		if ($opImgHover === false) {
			$optImgMainHover.closest('img.hover-image').addClass('disable');
		}

	}



	$(window).on('load', function () {
		initChangeImg($ecproduct);
	});
	$("document").ready(function () {
		initChangeImg($ecproduct);
	});


	/*----------------------------- Size Hover To Active -------------------------------- */

	$('.fc-opt-size').each(function () {
		$(this).on('mouseenter', 'li', function () {
			var $this = $(this);
			var $old_data = $this.find('a').attr('data-old');
			var $new_data = $this.find('a').attr('data-new');
			var $old_price = $this.closest('.fc-pro-content').find('.old-price');
			var $new_price = $this.closest('.fc-pro-content').find('.new-price');

			$old_price.text($old_data);
			$new_price.text($new_data);

			$this.addClass('active').siblings().removeClass('active');
		});
	});
	/*----------------------------- Single Product Color and Size Click to Active -------------------------------- */

	$(document).ready(function () {
		$(".single-pro-content .fc-pro-variation .fc-pro-variation-content li").click(function () {
			$(this).addClass('active').siblings().removeClass('active');
		});
	});

});



//meus scripts
/*function alternarTipoSenha() {
    var senha = document.getElementById("senha");
    var senha1 = document.getElementById("senha1");
    var senha2 = document.getElementById("senha2");
    var tipoAtual = senha.type;

    // Alterna para o tipo de entrada oposto
    if (tipoAtual === "password") {
      senha.type = "text";
      senha1.style.display = 'none';
      senha2.style.display = 'block';
    } else {
      senha.type = "password";
      senha1.style.display = 'block';
      senha2.style.display = 'none';
    }
  }
  function alternarTipoSenha2() {
    var senha = document.getElementById("validasenha");
    var senha3 = document.getElementById("senha3");
    var senha4 = document.getElementById("senha4");
    var tipoAtual = senha.type;

    // Alterna para o tipo de entrada oposto
    if (tipoAtual === "password") {
      senha.type = "text";
      senha3.style.display = 'none';
      senha4.style.display = 'block';
    } else {
      senha.type = "password";
      senha3.style.display = 'block';
      senha4.style.display = 'none';
    }
  }

  //Validar senha

  var senha = document.getElementById('senha');
  var confsenha = senha.value;
  if(confsenha == '') {
    var validasenha = document.getElementById("validasenha");
    var confvalidasenha = validasenha.value;
    var smallsenha = document.getElementById("conferesenha");
    var textRegex = document.getElementById('conferesenharegex');

    textRegex.style.display = "none";
    smallsenha.style.display = "none";
    validasenha.style.borderColor = " #e0e0e0";
  }

  function validaSenhaRegex() {

    var validaRegex;

    var padrao = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#/])[A-Za-z\d@$!%*?&#/]{8,20}$/;

    var senha = document.getElementById('senha');
    var confsenha = senha.value;
  
    if (padrao.test(confsenha)) {

      validaRegex = true; // A senha é válida

    } else {

      validaRegex = false; // A senha é inválida

    }

    var textRegex = document.getElementById('conferesenharegex');

    if (validaRegex) {

      textRegex.style.display = "none";
      senha.style.borderColor = " #e0e0e0";

    } else {

      textRegex.style.display = "block";
      senha.style.borderColor = " #dc3545";

    }

  }

  function limpaSmal() {

    var senha = document.getElementById('senha');
    var confsenha = senha.value;

    if(confsenha == '') {

      var textRegex = document.getElementById('conferesenharegex');

      textRegex.style.display = "none";
      senha.style.borderColor = " #e0e0e0";

    }

  }

  function verifica() {

    validaSenha();

  }
  function validaSenha() {//verifica se são igauis
    var senha = document.getElementById('senha');
    var confsenha = senha.value;
    var validasenha = document.getElementById("validasenha");
    var confvalidasenha = validasenha.value;
    

    var smallsenha = document.getElementById("conferesenha");

    if(confsenha == confvalidasenha) {
        smallsenha.style.display = "none";
        validasenha.style.borderColor = " #e0e0e0";
    } else {
        smallsenha.style.display = "block";
        validasenha.style.borderColor = "#dc3545";
    }

  }

  //validador de documento
  var documento = document.getElementById('documento');
  var confdoc = documento.value;
  if(confdoc == '') {
    var textodocumento = document.getElementById("conferedocumento");
    textodocumento.style.display = "none";
    documento.style.borderColor = " #e0e0e0";
  }

  function limpaDoc() {

    var documento = document.getElementById('documento');
    var confdoc = documento.value;
    if(confdoc == '') {
      var textodocumento = document.getElementById("conferedocumento");
      textodocumento.style.display = "none";
      documento.style.borderColor = " #e0e0e0";
    }

  }

  function validarCPFCNPJ() {
    var documento = document.getElementById('documento');
    var confdocumento = documento.value;
    var numero = confdocumento.replace(/\D/g, '');
    
    if (numero.length === 11) {
        if (/^(\d)\1*$/.test(numero)) {
            return false;
        }
        
        let soma = 0;
        for (let i = 0; i < 9; i++) {
            soma += parseInt(numero[i]) * (10 - i);
        }
        
        const digito1 = (soma % 11 < 2) ? 0 : 11 - (soma % 11);
        
        soma = 0;
        for (let i = 0; i < 10; i++) {
            soma += parseInt(numero[i]) * (11 - i);
        }
        
        const digito2 = (soma % 11 < 2) ? 0 : 11 - (soma % 11);
        
        if (numero[9] == digito1 && numero[10] == digito2) {
            return true;
        }
    } else if (numero.length === 14) {
        if (/^(\d)\1*$/.test(numero)) {
            return false;
        }
        
        let soma = 0;
        let multiplicador = 5;
        for (let i = 0; i < 12; i++) {
            soma += parseInt(numero[i]) * multiplicador;
            multiplicador = (multiplicador === 2) ? 9 : multiplicador - 1;
        }
        
        const digito1 = soma % 11 < 2 ? 0 : 11 - (soma % 11);
        
        soma = 0;
        multiplicador = 6;
        for (let i = 0; i < 13; i++) {
            soma += parseInt(numero[i]) * multiplicador;
            multiplicador = (multiplicador === 2) ? 9 : multiplicador - 1;
        }
        
        const digito2 = soma % 11 < 2 ? 0 : 11 - (soma % 11);
        
        if (numero[12] == digito1 && numero[13] == digito2) {
            return true;
        }
    }
    
    return false;
}

function validadedoc() {
  var styledocumento = document.getElementById('documento');
  var textodocumento = document.getElementById('conferedocumento');

  if(validarCPFCNPJ()) {
    textodocumento.style.display = "none";
    styledocumento.style.borderColor = " #e0e0e0";
  } else {
    textodocumento.style.display = "block";
    styledocumento.style.borderColor = " #dc3545";
  }

}*/