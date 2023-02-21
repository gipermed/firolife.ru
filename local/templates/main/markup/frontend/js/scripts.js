'use strict';

$(document).ready(function(){
	
	/* header-contacts */
	
	$(document).on('click', '.header-contacts-open', function(){
		$('.header-contacts').toggleClass('active');
		return false;
	})
	
	$(document).on('click', function(event){
		if($(event.target).closest('.header-contacts').length) return;
		$('.header-contacts').removeClass('active');
	})
	
	/* header-nav */

	$(document).on('click', '.header-nav-open', function(event){
		$('html').addClass('header-nav-opened header-nav-is-open');
		return false;
	})

	$(document).on('click', '.header-nav-close', function(event){
		closeHeaderNav();
		return false;
	})

	$(document).on('click', function(event){
		if($(event.target).closest('.header-nav-open, .header-nav').length) return;
		closeHeaderNav();
	})

	function closeHeaderNav(){
		if(!$('html').hasClass('header-nav-is-open')) return;
		$('html').removeClass('header-nav-is-open');
		setTimeout(() => {
			$('html').removeClass('header-nav-opened');
		}, 400)
	}
	
	/* header-catalog */
	
	$(document).on('click', '.header-catalog-open', function(){
		$(this).toggleClass('active');
		$('.header-catalog-menu-level-1').slideToggle(400);
		return false;
	})
	
	function positionMenuMarker(li){
		const span = li.children('a').children('span')
		const width = span.innerWidth()
		const position = li.position().left + (li.innerWidth() - width) / 2;
		$('.header-catalog-menu-marker').css({
			transform: 'translateX('+ position +'px)',
			width: width
		})
	}
	
	positionMenuMarker($('.header-catalog-menu-level-1>li.current-menu-item'));
	
	$(document).on('mouseenter', '.header-catalog-menu-level-1>li', function(){
		positionMenuMarker($(this))
	})
	
	$(document).on('mouseleave', '.header-catalog-menu-level-1>li', function(){
		positionMenuMarker($('.header-catalog-menu-level-1>li.current-menu-item'));
	})
	
	$(document).on('click', '.header-nav-is-open .header-catalog-menu-level-1>.menu-item-has-children>a', function(event){
		const li = $(this).closest('li');
		if(li.hasClass('current')) return false;
		if(li.hasClass('active')){
			li.find('.header-catalog-menu-level-2 .menu-item-has-children').removeClass('active current').slideDown(400);
			li.find('.header-catalog-menu-level-2 .menu-item-has-children .header-catalog-menu-view-all').slideUp(400);
			li.find('.header-catalog-menu-level-2').children('.header-catalog-menu-view-all').slideDown(400);
			li.find('.header-catalog-menu-level-2 ul').slideUp(400);
			li.removeClass('active').addClass('current');
		}else{
			if(li.children('ul').find('.header-catalog-sub-menu-list').length){
				li.addClass('active');
			}else{
				li.addClass('current');
			}
			li.parent().children('li:not(.header-catalog-menu-view-all)').not(li).slideUp(400);
			li.parent().children('.header-catalog-menu-view-all').slideDown(400);
			li.find('.header-catalog-menu-level-2').children('.header-catalog-menu-view-all').show(0);
			li.children('.header-catalog-sub-menu').slideDown(400);
		}
		return false;
	})
	
	$(document).on('click', '.header-nav-is-open .header-catalog-sub-menu-list>.menu-item-has-children>a', function(event){
		const li = $(this).closest('li');
		if(li.hasClass('current')) return false;
		if(li.hasClass('active')){
			li.children('ul').find('.menu-item-has-children').removeClass('active current').slideDown(400);
			li.children('ul').find('.menu-item-has-children .header-catalog-menu-view-all').slideUp(400);
			li.children('ul').children('.header-catalog-menu-view-all').slideDown(400);
			li.children('ul').find('ul').slideUp(400);
			li.removeClass('active').addClass('current');
		}else{
			if(li.children('ul').find('.header-catalog-sub-menu-list').length){
				li.addClass('active');
			}else{
				li.addClass('current');
				li.closest('ul').closest('li').removeClass('current').addClass('active');
			}
			li.parent().children('li').not(li).slideUp(400);
			li.children('ul').children('.header-catalog-menu-view-all').show(0);
			li.children('ul').slideDown(400);
		}
		return false;
	})
	
	$(document).on('click', '.header-catalog-menu-close-sub-menu>a', function(){
		$('.header-catalog-menu-level-1 .menu-item-has-children').removeClass('active current').slideDown(400);
		$('.header-catalog-menu-level-1 .header-catalog-menu-view-all').slideUp(400);
		$('.header-catalog-sub-menu').slideUp(400);
		$('.header-catalog-menu-level-2 ul').slideUp(400);
		return false;
	})
	
	/* header-nav-mobile-about-toggle */
	
	$(document).on('click', '.header-nav-mobile-about-toggle', function(){
		$(this).toggleClass('active');
		$('.header-nav-mobile-about-menu').slideToggle(400);
		return false;
	})
	
	/* sliders */
	
	$('.promo-slider').each(function(index){
		const t = $(this);
		const slider = new Swiper(this, {
			speed: 600,
			loop: true,
			watchSlidesVisibility: true,
			navigation: {
				nextEl: t.find('.slider-arrow-next')[0],
				prevEl: t.find('.slider-arrow-prev')[0],
			},
			pagination: {
				el: t.closest('.promo-slider-section').find('.slider-dots')[0],
				type: 'bullets',
				clickable: true
			},
		});
	})
	
	$('.category-section-products-slider, .youtube-slider').each(function(index){
		const t = $(this);
		const slider = new Swiper(this, {
			speed: 600,
			watchSlidesVisibility: true,
			navigation: {
				nextEl: t.find('.slider-arrow-next')[0],
				prevEl: t.find('.slider-arrow-prev')[0],
			},
			breakpoints: {
				0:	{
					slidesPerView: 2,
					spaceBetween: 6,
				},
				480: {
					slidesPerView: 3,
					spaceBetween: 6,
				},
				1024: {
					slidesPerView: 2,
					spaceBetween: 10,
				},
				1200: {
					slidesPerView: 3,
					spaceBetween: 10,
				},
				1440: {
					slidesPerView: 3,
					spaceBetween: 30,
				}
			}
		});
	})
	
	$('.brands-slider').each(function(index){
		const t = $(this);
		const slider = new Swiper(this, {
			speed: 400,
			watchSlidesVisibility: true,
			loop: true,
			autoplay: {
				delay: 4000,
			},
			navigation: {
				nextEl: t.closest('.brands-section').find('.slider-arrow-next')[0],
				prevEl: t.closest('.brands-section').find('.slider-arrow-prev')[0],
			},
			breakpoints: {
				0:	{
					slidesPerView: 'auto',
					spaceBetween: 6,
				},
				1024: {
					slidesPerView: 4,
					spaceBetween: 8,
				},
				1200: {
					slidesPerView: 6,
					spaceBetween: 8,
				},
				1440: {
					slidesPerView: 8,
					spaceBetween: 26,
				}
			}
		});
	})
	
	$('.product-gallery-slider').each(function(){
		const t = $(this);
		const navSlider = new Swiper(t.closest('.product-gallery').find('.product-gallery-nav-slider')[0], {
			speed: 400,
			slideToClickedSlide: true,
			slidesPerView: 5,
			spaceBetween: 5,
			watchSlidesVisibility: true,
			watchSlidesProgress: true,
			direction: 'vertical',
		});
		const slider = new Swiper(this, {
			speed: 400,
			watchSlidesVisibility: true,
			thumbs: {
			  swiper: navSlider,
			},
			navigation: {
				nextEl: t.closest('.product-gallery').find('.slider-arrow-next')[0],
				prevEl: t.closest('.product-gallery').find('.slider-arrow-prev')[0],
			},
			on: {
				slideChange: function () {
					const realIndex = this.realIndex;
					const activeSlide = t.closest('.product-gallery').find('.product-gallery-nav-slider .swiper-slide').eq(realIndex);
					const nextSlide = activeSlide.next();
					const prevSlide = activeSlide.prev();
					if(nextSlide.length && !nextSlide.hasClass('swiper-slide-visible')) {
						this.thumbs.swiper.slideNext()	
					}else if(prevSlide.length && !prevSlide.hasClass('swiper-slide-visible')) {
						this.thumbs.swiper.slidePrev()	
					}
			  }
			}
		});
	})
	
	$('.products-slider').each(function(index){
		const t = $(this);
		const slider = new Swiper(this, {
			speed: 400,
			watchSlidesVisibility: true,
			navigation: {
				nextEl: t.find('.slider-arrow-next')[0],
				prevEl: t.find('.slider-arrow-prev')[0],
			},
			breakpoints: {
				0:	{
					slidesPerView: 2,
					spaceBetween: 6,
				},
				480: {
					slidesPerView: 3,
					spaceBetween: 6,
				},
				768: {
					slidesPerView: 4,
					spaceBetween: 6,
				},
				1200: {
					slidesPerView: 5,
					spaceBetween: 10,
				},
				1440: {
					slidesPerView: 5,
					spaceBetween: 28,
				}
			}
		});
	})
	
	$('.product-review-imgs-slider').each(function(index){
		const t = $(this);
		const slider = new Swiper(this, {
			speed: 400,
			watchSlidesVisibility: true,
			navigation: {
				nextEl: t.closest('.product-review-imgs').find('.slider-arrow-next')[0],
				prevEl: t.closest('.product-review-imgs').find('.slider-arrow-prev')[0],
			},
			breakpoints: {
				0:	{
					slidesPerView: 3,
					spaceBetween: 12,
				},
				768: {
					slidesPerView: 5,
					spaceBetween: 30,
				},
				1440: {
					slidesPerView: 5,
					spaceBetween: 50,
				}
			}
		});
	})
	
	$('.contacts-shop-slider').each(function(){
		let slider;
		const t = $(this);
		initSlider();
		$(window).on('resize', initSlider)
		function initSlider(){
			if($(window).width() < 1024){
				if(!slider){
					const shopFancy = t.find('.contacts-shop-img:last').data('fancybox');
					t.find('.contacts-shop-img:first').attr('data-fancybox', shopFancy);
					t.closest('.contacts-shop').find('.hidden-tablet .contacts-shop-img').removeAttr('data-fancybox');
					slider = new Swiper(t[0], {
						speed: 400,
						loop: false,
						slidesPerView: 'auto',
						spaceBetween: 32,
						watchSlidesVisibility: true,
						navigation: {
							nextEl: t.find('.slider-arrow-next')[0],
							prevEl: t.find('.slider-arrow-prev')[0],
						},
						breakpoints: {
							0: {
								slidesPerView: 1,
								spaceBetween: 0,
							},
							480: {
								slidesPerView: 2,
								spaceBetween: 8,
							},
							768: {
								slidesPerView: 2,
								spaceBetween: 20,
							}
						}
					});
				}
			}else{
				if(slider){
					t.find('.visible-tablet .contacts-shop-img').removeAttr('data-fancybox');
					slider.destroy(true, true);
					slider = null;
				}
			}
		}
	})
	
	$('.articles-slider').each(function(index){
		const t = $(this);
		const slider = new Swiper(this, {
			speed: 400,
			watchSlidesVisibility: true,
			navigation: {
				nextEl: t.find('.slider-arrow-next')[0],
				prevEl: t.find('.slider-arrow-prev')[0],
			},
			breakpoints: {
				0:	{
					slidesPerView: 1,
					spaceBetween: 6,
				},
				480: {
					slidesPerView: 2,
					spaceBetween: 6,
				},
				768: {
					slidesPerView: 3,
					spaceBetween: 6,
				},
				1200: {
					slidesPerView: 4,
					spaceBetween: 10,
				},
				1440: {
					slidesPerView: 4,
					spaceBetween: 28,
				}
			}
		});
	})
	
	/* product-item-favorites */
	
	$(document).on('click', '.add-to-favorites-btn', function(){
		$(this).toggleClass('active');
		return false;
	})
	
	/* add-to-cart-btn */
	
	$(document).on('click', '.product-item-btn, .product-btn', function(){
		const t = $(this);
		if(t.data('text') && t.data('text-active')){
			if(t.hasClass('active')){
				t.text(t.data('text'));
			}else{
				t.text(t.data('text-active'));
			}
		}
		t.toggleClass('active');
		return false;
	})
	
	/* tabs */

	$(document).on('click', '.tabs-nav a', function(event){
		const t = $(this);
		const li = t.parent();
		const tab = t.attr('href');
		const tabs = t.closest('.tabs-nav').data('tabs');
		if(li.hasClass('active')) return false;
		t.closest('.tabs-nav').find('li').removeClass('active');
		$(tabs).find('.tab-block').removeClass('active');
		li.addClass('active');
		$(tab).addClass('active');
		return false;
	})
	
	/* modal */

	let isOpenModal = false;

	$(document).on('click', '.modal-open-btn', function(){
		const t = $(this);
		const modal = t.data('modal') || t.attr('href');
		openModal(modal);
		return false;
	})

	$(document).on('click', '.modal-close-btn, .modal-close-link', function(){
		closeModal();
		return false;
	})

	function closeModal(){
		$.fancybox.close(true);
	}

	function openModal(modal){
		let timeout = 0;
		if($('html').hasClass('fancybox-is-open')) isOpenModal = true;
		if(isOpenModal) timeout = 399;
		closeModal();
		setTimeout(function(){
			$.fancybox.open({
				src  : modal,
				type : 'inline',
				opts : getFancyboxModalOpts(modal)
			})
			setTimeout(function(){
				isOpenModal = false;
			}, 400)
		}, timeout)
	}

	function getScrollbarWidth(){ 
		 const div = $('<div style="width:50px;height:50px;overflow:hidden;position:absolute;top:-200px;left:-200px;"><div style="height:100px;"></div></div>'); 
		 $('body').append(div); 
		 const w1 = $('div', div).innerWidth(); 
		 div.css('overflow-y', 'scroll'); 
		 const w2 = $('div', div).innerWidth(); 
		 $(div).remove(); 
		 return (w1 - w2); 
	}

	function getFancyboxModalOpts(modal){
		const scrollbarWidth = getScrollbarWidth();
		return {
			smallBtn: false,
			toolbar: false,
			touch: false,
			animationDuration: 400,
			beforeLoad: function(){
				if(!$('html').hasClass('fancybox-is-open')){
					$('html').addClass('fancybox-is-open').css({
						marginRight: scrollbarWidth
					})
				}
			},
			afterLoad: function(){
				setTimeout(function(){
					$(modal).addClass('active');
				},0)
			},
			beforeClose: function(){
				$(modal).addClass('close');
				setTimeout(function(){
					$(modal).removeClass('active close');
				}, 400)
			},
			afterClose: function(){
				if(isOpenModal) return;
				$('html').removeClass('fancybox-is-open').css({
					marginRight: 0
				})
			}
		}
	}
	
	/* password-input-type-toggle */
	
	$(document).on('click', '.password-input-type-toggle', function(){
		const t = $(this);
		const input = t.closest('.form-block').find('.input');
		if(t.hasClass('active')){
			input.attr('type', 'password');
		}else{
			input.attr('type', 'text');
		}
		t.toggleClass('active');
		return false;
	})
	
	/* checkbox */

	$(document).on('change', '.checkbox-input', function(){
		const t = $(this);
		if(t.prop('checked')){
			t.closest('label').addClass('active');
		}else{
			t.closest('label').removeClass('active');
		}
	})
	
	/* catalog-sort-link */
	
	$(document).on('click', '.catalog-sort-link', function(){
		$(this).toggleClass('active');
		return false;
	})
	
	/* range slider */
	
	$('.range-slider').each(function(){
		const slider = $(this);
		const wrapp = slider.closest('.range-slider-wrapp');
		const inputFrom = wrapp.find('.range-input-from');
		const inputTo = wrapp.find('.range-input-to');
		const min = slider.data('min');
		const max = slider.data('max');
		const valueFrom = slider.data('value-from');
		const valueTo = slider.data('value-to');
		const step = slider.data('step') || 1;
		slider.slider({
			min: min,
			max: max,
			values: [valueFrom, valueTo],
			range: true,
			step: step,
			slide:function(event, ui){
				inputFrom.val(replacePriceValue(ui.values[0]));
				inputTo.val(replacePriceValue(ui.values[1]));
			}
		});
		let value;
		inputFrom.on('blur', function(){
			const t = $(this);
			const val = parseInt(t.val().replace(' ', ''));
			const valueInputTo = parseInt(inputTo.val().replace(' ', '')) || valueTo;
			if(!val){
				t.val(value);
				return;
			}
			if(val < min || val > valueInputTo){
				t.val(min)
			}
			slider.slider('values', [t.val(), valueInputTo]);
			t.val(replacePriceValue(t.val()))
		})
		inputTo.on('blur', function(){
			const t = $(this);
			const val = parseInt(t.val().replace(' ', ''));
			const valueInputFrom = parseInt(inputFrom.val().replace(' ', '')) || valueFrom;
			if(!val){
				t.val(value);
				return;
			}
			if(val > max || val < valueInputFrom){
				t.val(max)
			}
			slider.slider('values', [valueInputFrom, t.val()]);
			t.val(replacePriceValue(t.val()))
		})
		$('.range-input').on({
			focus: function(){
				value = $(this).val();
				$(this).val('');
			},
			keypress: function(event){
				let key, keyChar;
				if (event.keyCode) key = event.keyCode;
				else if(event.which) key = event.which;
				if(key==13){
					$(this).trigger('blur');
					return false;
				}
				if(key==null || key==0 || key==8 || key==9 || key==39 || key==48) return true;
				keyChar=String.fromCharCode(key);
				if(!/[1-9]/.test(keyChar))	return false;
			}
		})
	})

	function replacePriceValue(str){
		str = str.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
		return str.replace('.',',');
	}
	
	/* catalog-filter-menu-more-toggle */
	
	$(document).on('click', '.catalog-filter-menu-more-toggle', function(){
		const t = $(this);
		if(t.hasClass('active')){
			t.text(t.data('text'));
		}else{
			t.text(t.data('text-active'));
		}
		t.toggleClass('active');
		t.closest('.catalog-filter-section').find('.catalog-filter-menu-more').slideToggle(400);
		return false;
	})
	
	/* catalog-filter */

	$(document).on('click', '.catalog-filter-open', function(event){
		$('html').addClass('catalog-filter-opened catalog-filter-is-open');
		return false;
	})

	$(document).on('click', '.catalog-filter-close', function(event){
		closeCatalogFilter();
		return false;
	})

	$(document).on('click', function(event){
		if($(event.target).closest('.catalog-filter-open, .catalog-filter').length) return;
		closeCatalogFilter();
	})

	function closeCatalogFilter(){
		if(!$('html').hasClass('catalog-filter-is-open')) return;
		$('html').removeClass('catalog-filter-is-open');
		setTimeout(() => {
			$('html').removeClass('catalog-filter-opened');
		}, 400)
	}
	
	/* catalog-view-more-btn */
	
	$(document).on('click', '.catalog-view-more-btn', function(){
		$(this).closest('.read-more-btn-wrapp').fadeOut(400);
		$('.catalog-row').addClass('active');
		return false;
	})
	
	/* catalog-nav-open */
	
	$(document).on('click', '.catalog-nav-open', function(){
		if(!$('.catalog-menu-mobile').length) return;
		const t = $(this);
		if(t.hasClass('active')){
			closeCatalogNav();
		}else{
			t.addClass('active');
			$('.catalog-nav').addClass('active');
		}
	})
	
	$(document).on('click', function(event){
		if($(event.target).closest('.catalog-nav').length) return;
		closeCatalogNav();
	})
	
	function closeCatalogNav(){
		$('.catalog-nav-open').removeClass('active');
		$('.catalog-nav').removeClass('active');
	}
	
	/* modal-adult */
	
	// localStorage.clear();
	
	if($('.modal-adult').length && !localStorage.getItem('is-adult')){
		openModal('#modal-adult');
	}
	
	$(document).on('click', '.modal-adult-ok', function(){
		localStorage.setItem('is-adult', true);
		$('body').removeClass('is-not-adult', true);
		return false;
	})
	
	/* product-size-list */
	
	$(document).on('click', '.product-size-list a', function(){
		$(this).closest('.product-size-list').find('li').removeClass('active');
		$(this).parent().addClass('active');
		return false;
	})
	
	/* product-color-list */
	
	$(document).on('click', '.product-color-list a', function(){
		const t = $(this);
		const color = t.data('color');
		t.closest('.product-color-list').find('li').removeClass('active');
		t.parent().addClass('active');
		t.closest('.product-color').find('.product-color-selected').text(color);
		return false;
	})
	
	/* select-number */

	;(function(){
		$(document).on('click', '.select-number-btn', function(event){
			event.preventDefault();
			const t = $(this);
			const wrapp = t.closest('.select-number');
			const input = wrapp.find('.select-number-input');
			let val = input.val();
			const min = input.data('min') || 0;
			const max = input.data('max') || Infinity;
			const step = input.data('step') || 1;
			const desc = input.data('desc') || '';
			val = val.replace(desc, '');
			val = +val;
			if(t.hasClass('select-number-btn-minus')){
				wrapp.find('.select-number-btn-plus').removeClass('disabled');
				if(val - step == min) t.addClass('disabled');
				if(val == min) return;
				input.val( val - step + desc ).trigger('input');
			}else{
				wrapp.find('.select-number-btn-minus').removeClass('disabled');
				if(val + step == max) t.addClass('disabled');
				if(val == max) return;
				input.val( val + step + desc ).trigger('input');
			}
		})

		let value;
		$(document).on('focus', '.select-number-input', function(){
			value = $(this).val();
			$(this).val('');
		})
		$(document).on('blur', '.select-number-input', function(){
			const t = $(this);
			const wrapp = t.closest('.select-number');
			let val = t.val();
			const min = t.data('min') || 0;
			const max = t.data('max') || Infinity;
			const desc = t.data('desc') || '';
			val = val.replace(desc, '');
			val = +val;
			if(!val){
				t.val(value);
				return;
			}
			if(val <= min){
				t.val(min + desc);
				wrapp.find('.select-number-btn-minus').addClass('disabled');
				wrapp.find('.select-number-btn-plus').removeClass('disabled');
				return;
			}
			if(val >= max){
				t.val(max + desc);
				wrapp.find('.select-number-btn-plus').addClass('disabled');
				wrapp.find('.select-number-btn-minus').removeClass('disabled');
				return;
			}
			wrapp.find('.select-number-btn').removeClass('disabled');
			t.val(val + desc);
		})
		$(document).on('keypress', '.select-number-input', function(event){
			let key, keyChar;
			if (event.keyCode) key = event.keyCode;
			else if(event.which) key = event.which;
			if(key==13){
				$(this).trigger('blur').trigger('input');
				return false;
			}
			if(key==null || key==0 || key==8 || key==9 || key==39 ) return true;
			keyChar=String.fromCharCode(key);
			if(!/[0-9]/.test(keyChar))	return false;
		})
	})();
	
	/* toggle-mobile-link */
	
	$(document).on('click', '.toggle-mobile-link', function(){
		const t = $(this);
		if(t.hasClass('active')){
			t.find('span').text(t.data('text'));
		}else{
			t.find('span').text(t.data('text-active'));
		}
		t.toggleClass('active');
		t.closest('.toggle-mobile-wrapp').find('.toggle-mobile-block').toggleClass('active');
		return false;
	})
	
	/* product-expected-btn-add */
	
	$(document).on('click', '.product-expected-btn-add', function(){
		const t = $(this);
		const state = $('.product-state-expected');
		if(t.hasClass('active')){
			t.text(t.data('text'));
			state.text(state.data('text'));
		}else{
			t.text(t.data('text-active'));
			state.text(state.data('text-active'));
			openModal('#modal-expected-add');
		}
		t.toggleClass('active');
		return false;
	})
	
	/* fancybox */

	$('[data-fancybox]').fancybox(getFancyboxOptions())

	function getFancyboxOptions(){
		return {
			hash: false,
			buttons: [
				'thumbs',
				'close'
			],
			btnTpl: {
				arrowLeft: `<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left">
					<svg width="24" height="24"><use xlink:href="#icon-arrow-down"/></svg>
				</button>`,
				arrowRight: `<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right">
					<svg width="24" height="24"><use xlink:href="#icon-arrow-down"/></svg>
				</button>`,
				thumbs: `<button data-fancybox-thumbs class="fancybox-button fancybox-button--thumbs" >
					<svg width="24" height="24"><use xlink:href="#icon-grid"/></svg>
				</button>`,
				close: `<button data-fancybox-close class="fancybox-button fancybox-button--close">
					<svg width="24" height="24"><use xlink:href="#icon-close"/></svg>
				</button>`
			},
			transitionEffect: 'slide',
			transitionDuration: 600,
			parentEl: 'html',
			iframe: {
				tpl:'<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" allowfullscreen allow="autoplay; fullscreen" src=""></iframe>',
				preload: false
			},
			onUpdate: function(instance, current){
				if(current.type !== 'iframe') return;
				set16x9(current);
			}
		}
	}

	function set16x9(current){
		const	ratio = 16 / 9;
		const video = current.$content;
		if(video){
			video.hide();
			let width = current.$slide.width();
			let height = current.$slide.height() - 50;
			if(height * ratio > width){
				height = width / ratio;
			}else{
				width = height * ratio;
			}
			video.css({
				width: width,
				height: height
			}).show();
		}
	}

	/* rating-select */
	
	$('.rating-select').each(function(){
		const t = $(this);
		const input = t.find('.rating-select-input');
		t.on('mousemove', event => {
			const x = event.clientX;
			const position = x - t.offset().left;
			const starWidth = t.width() / 5;
			if(position <= starWidth){
				setRating(1);
			}
			if(position <= starWidth * 2  && position > starWidth){
				setRating(2);
			}
			if(position <= starWidth * 3  && position > starWidth * 2){
				setRating(3);
			}
			if(position <= starWidth * 4  && position > starWidth * 3){
				setRating(4);
			}
			if(position > starWidth * 4){
				setRating(5);
			}
		})
		t.on('click', () => {
			t.toggleClass('active');
		})
		t.on('mouseout', () => {
			if(!t.hasClass('active')){
				setRating(0);
			}
		})
		function setRating(star){
			const starWidth = t.width() / 5;
			t.find('.rating-state').width(starWidth * star);
			if(star){
				input.val(star);
			}else{
				input.val('');
			}
		}
	})
	
	/* product-review-form */
	
	$(document).on('click', '.product-review-add-btn', function(){
		const t = $(this);
		if(t.hasClass('active')){
			t.text(t.data('text'));
		}else{
			t.text(t.data('text-active'));
		}
		t.toggleClass('active');
		t.closest('.product-tab-section').find('.product-review-form').fadeToggle(400);
		return false;
	})
	
	$(document).on('click', '.product-review-form-close', function(){
		$(this).closest('.product-tab-section').find('.product-review-add-btn').trigger('click');
		return false;
	})
	
	$(document).on('keyup input', '.product-review-form-input', function(){
		const t = $(this);
		const maxlength = Number(t.attr('maxlength'));
		let value = t.val();
		const length = value.length;
		if(length > maxlength){
			value = value.slice(0, maxlength);
		}
		t.val(value);
		t.closest('.form-block').find('.product-review-form-input-letters').text(value.length)
	})
	
	$(document).on('change', '.product-review-form-img input', function(){
		const t = $(this);
		const files = t[0].files;
		const label = t.closest('.product-review-form-img');
		if(!files){
			label.find('img').remove();
			label.removeClass('active');
			return;
		}
		const file = files[0];
		const reader = new FileReader();
		reader.readAsDataURL(file);
		reader.onloadend = () => {
			label.addClass('active');
			const img = `<img src="${reader.result}" alt="">`;
			label.find('span').html(img);
		}
	})
	
	/* contacts-shop-schema-print */
	
	$(document).on('click', '.contacts-shop-schema-print', function(){
		const src = $(this).closest('.contacts-shop-col').find('.contacts-shop-img').attr('href');
		let popup;
		popup = window.open(src);
		popup.onbeforeunload = closePrint;
		popup.onafterprint = closePrint;
		popup.focus();
		popup.print();
		function closePrint(){
			 if(popup) popup.close();
		}
		return false;
	})
	
	/* contacts-map */

	if($('.contacts-map').length){
		$.getScript('https://api-maps.yandex.ru/2.1/?lang=ru_RU', initMap)
	}
	function initMap(){
		ymaps.ready(function () {
			const canvas = $('.contacts-map');
			const lat = canvas.data('lat');
			const lng = canvas.data('lng');
			const zoom = $(window).width() < 480 ? canvas.data('zoom-mobile') : canvas.data('zoom');
			const myMap = new ymaps.Map(canvas[0], {
				center: [lat, lng],
				zoom: zoom,
				controls: ['zoomControl']
			}, {
				searchControlProvider: 'yandex#search'
			});
			myMap.behaviors.disable('scrollZoom');
			$('.contacts-shop').each(function(){
				const t = $(this);
				const lat = t.data('lat');
				const lng = t.data('lng');
				const balloonContent = t.find('.contacts-shop-address').html();
				const myPlacemark = new ymaps.Placemark(
					[lat, lng],
					{
						balloonContent: balloonContent,
					},
					{
						preset: 'islands#redDotIcon'
					});
				myMap.geoObjects.add(myPlacemark);
			})
		})
	}
	
	/* faq */

	$(document).on('click', '.faq-item-toggle', function(){
		const t = $(this);
		if(t.hasClass('active')){
			close();
		}else{
			close();
			t.addClass('active');
			t.closest('.faq-item').find('.faq-item-body').slideDown(400);
		}
		function close(){
			const faq = t.closest('.faq');
			faq.find('.faq-item-toggle').removeClass('active');
			faq.find('.faq-item-body').slideUp(400);
		}
		return false;
	})
	
	/* cart */
	
	$(document).on('change', '.cart-select-all .checkbox-input', function(){
		if($(this).prop('checked')){
			$('.cart-item-checkbox .checkbox-input').prop('checked', true).trigger('change');
		}else{
			$('.cart-item-checkbox .checkbox-input').prop('checked', false).trigger('change');
		}
	})
	
	$(document).on('input', '.cart-item .select-number-input', function(){
		const t = $(this);
		const unit = t.closest('.cart-item').find('.cart-item-number-unit');
		if(Number(t.val() > 1)){
			unit.addClass('active')
		}else{
			unit.removeClass('active')
		}
	})
	
	/* ordering-form */
	
	$(document).on('input change', '.ordering-form [required]', function(){
		const form = $(this).closest('.ordering-form');
		let validForm = true
		form.find('[required]').each(function(){
			const t = $(this);
			if(t.attr('type') === 'checkbox'){
				if(!t.prop('checked')){
					validForm = false;
					return false;
				}
			}else if(t.attr('type') === 'radio'){
				let radioChecked = false;
				$('[name="'+ t.attr('name') +'"]').each(function(){
					if($(this).prop('checked')){
						radioChecked = true;
						return false;
					}
				})
				if(!radioChecked) validForm = false;
			}else{
				if(!t.val()){
					validForm = false;
					return false;
				}
			}
		})
		if(validForm){
			form.find('.submit').removeAttr('disabled');
		}else{
			form.find('.submit').attr('disabled', true);
		}
	})
	
	/* ordering-section-title-toggle */
	
	$(document).on('click', '.ordering-section-title-toggle', function(){
		$(this).toggleClass('active').closest('.ordering-section').find('.ordering-section-body').slideToggle(400);
	})
	
	/* radio */

	$(document).on('change', '.radio-input', function(){
		const t = $(this);
		const name = t.attr('name');
		$(`[name="${name}"]`).closest('label').removeClass('active');
		if(t.prop('checked')){
			t.closest('label').addClass('active');
		} else{
			t.closest('label').removeClass('active');
		}
	})
	
	/* ordering-delivery-city-select */
	
	$(document).on('click', '.ordering-delivery-city-select-input', function(){
		const t = $(this);
		const wrapp = t.closest('.ordering-delivery-city-select');
		t.trigger('blur');
		if(wrapp.hasClass('active')){
			wrapp.removeClass('active');
		}else{
			wrapp.addClass('active');
			setTimeout(() => wrapp.find('.ordering-delivery-city-select-search-input').trigger('focus'), 100)
		}
	})
	
	$(document).on('click', function(event){
		if($(event.target).closest('.ordering-delivery-city-select').length) return;
		$('.ordering-delivery-city-select').removeClass('active');
	})
	
	/* modal-thanks */
	
	if($('#modal-thanks').length){
		openModal('#modal-thanks');
	}
	
	/* cabinet-menu */
	
	$(document).on('click', '.cabinet-menu .current-menu-item a', function(){
		$(this).closest('.cabinet-menu-wrapp').toggleClass('active');
		return false;
	})
	
	$(document).on('click', function(event){
		if($(event.target).closest('.cabinet-menu-wrapp').length) return;
		$('.cabinet-menu-wrapp').removeClass('active');
	})
	
	/* cabinet-profile-form */
	
	$(document).on('input', '.cabinet-profile-form input', function(){
		$(this).closest('.cabinet-profile-form').find('.submit').removeAttr('disabled')
	})
	
	/* cabinet-profile-del-btn */
	
	$(document).on('click', '.cabinet-profile-del-btn', function(){
		$(this).addClass('active');
		return false;
	})
	
	/* cabinet-address */
	
	$(document).on('click', '.cabinet-address-add-btn', function(){
		$('.cabinet-address-add, .cabinet-address-new').slideToggle(400);
		return false;
	})
	
	$(document).on('click', '.cabinet-address-new .cabinet-address-form-del', function(){
		$('.cabinet-address-add, .cabinet-address-new').slideToggle(400);
		return false;
	})
	
	$(document).on('submit', '.cabinet-address-form', function(event){
		const t = $(this);
		const title = t.find('.cabinet-address-input-title').val();
		const city = t.find('.cabinet-address-input-city').val();
		const comment = t.find('.cabinet-address-input-comment').val();
		const isMain = t.find('.cabinet-address-input-main').prop('checked');
		let data = city;
		let item;
		t.find('.cabinet-address-input-data').each(function(){
			const value = $(this).val();
			if(!value) return;
			const inputTitle = $(this).closest('.form-block').find('.form-block-title').text().toLowerCase();
			data += `, ${inputTitle} ${value}`
		})
		if(t.closest('.cabinet-address-new').length){
			const form = t.clone();
			item = $($('#cabinet-address-item').html());
			$('.cabinet-address-list').append(item);
			item.find('.cabinet-address-item-form').append(form);
			$('.cabinet-address-add, .cabinet-address-new').slideToggle(400);
			t.find('.input').val('');
			t.find('.cabinet-address-input-main').prop('checked', false)
			t.find('.cabinet-address-form-main-checkbox').removeClass('active');
			t.find('.cabinet-address-input-city').val(t.find('.cabinet-address-input-city').data('value-default'));
		}else{
			item = t.closest('.cabinet-address-item');
			item.find('.cabinet-address-item-form, .cabinet-address-item-body').slideToggle(400);
		}
		item.find('.cabinet-address-item-title').text(title);
		item.find('.cabinet-address-item-city').text(city);
		item.find('.cabinet-address-item-data').text(data);
		item.find('.cabinet-address-item-comment').text(comment);
		if(isMain){
			$('.cabinet-address-input-main').prop('checked', false)
			$('.cabinet-address-form-main-checkbox').removeClass('active');
			item.find('.cabinet-address-input-main').prop('checked', true);
			item.find('.cabinet-address-form-main-checkbox').addClass('active');
		}else{
			item.find('.cabinet-address-input-main').prop('checked', false);
			item.find('.cabinet-address-form-main-checkbox').removeClass('active');
		}
		return false;
	})
	
	$(document).on('click', '.cabinet-address-item-edit', function(){
		const item = $(this).closest('.cabinet-address-item');
		item.find('.cabinet-address-item-form, .cabinet-address-item-body').slideToggle(400);
		return false;
	})
	
	$(document).on('click', '.cabinet-address-item .cabinet-address-form-del, .cabinet-address-item-del', function(){
		const item = $(this).closest('.cabinet-address-item');
		item.fadeOut(400, () => item.remove());
		return false;
	})
	
	$(document).on('input', '.cabinet-address-item .cabinet-address-input-title', function(){
		const t = $(this);
		const item = t.closest('.cabinet-address-item');
		item.find('.cabinet-address-item-title').text(t.val());
		return false;
	})
	
	$(document).on('input', '.cabinet-address-item .cabinet-address-input-city', function(){
		const t = $(this);
		const item = t.closest('.cabinet-address-item');
		item.find('.cabinet-address-item-city').text(t.val());
		return false;
	})
	
	/* order-cart-link */
	
	$(document).on('click', '.order-cart-link', function(){
		$(this).closest('.order-cart').toggleClass('active').find('.order-cart-body').slideToggle(400);
		return false;
		
	})
	
	/* form-ajax */
	
	$(document).on('submit', '.form-ajax', function(event){
		event.preventDefault()
		const sentModal = $(this).data('modal-sent');
		const t = $(this);
		t.find('.submit').attr('disabled', true);
		t.ajaxSubmit({
			clearForm: true,
			success: data => {
				closeModal();
				t.find('.submit').removeAttr('disabled');
				openModal(sentModal);
			}
		});
		return false;
	})
	
	/* cookie-submit */
	
	if(!localStorage.getItem('cookie-submit')){
		$('.cookie').addClass('active');
	}
	
	$(document).on('click', '.cookie-submit', function(){
		$('.cookie').slideUp(400);
		localStorage.setItem('cookie-submit', 1);
		return false;
	})
	
	/* scroll-btn */
	
	$(window).on('load scroll resize', function(){
		if($(this).scrollTop() > 0){
			$('.scroll-btns').addClass('active');
		}else{
			$('.scroll-btns').removeClass('active');
		}
	})
	
	$(document).on('click', '.scroll-btn', function(){
		const t = $(this);
		if(t.data('scroll') === 'top'){
			scrollToBlock('body')
		}
		if(t.data('scroll') === 'bottom'){
			scrollToBlock('.footer')
		}
		return false;
	})
	
	function scrollToBlock(to, speed, offset){
		if(typeof to === 'string') to = $(to);
		if(!to[0]) return;
		offset = offset || 0;
		speed = speed || 1000;
		$('html, body').stop().animate({
			scrollTop: to.offset().top - offset
		}, speed);
	}
	
	/* page-favorites */
	
	$(document).on('click', '.page-favorites .product-item-favorites', function(){
		$(this).addClass('disabled').closest('.products-col').fadeOut(400);
		return false;
	})
	
	/* product-item-await-remove */
	
	$(document).on('click', '.product-item-await-remove', function(){
		$(this).addClass('disabled').closest('.products-col').fadeOut(400);
		return false;
	})
	
	/* modal-thanks */
	
	if($('#modal-password-change').length){
		openModal('#modal-password-change');
	}
	
});

