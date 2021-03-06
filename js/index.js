jQuery(function($) {

	var html = $('html');
	var viewport = $(window);

	/* ==========================================================================
	   Code Highlight
	   ========================================================================== */

	function highlight() {
		$('pre code').each(function(i, e) {
		    hljs.highlightBlock(e)
		});
	}
	highlight();

	/* ==========================================================================
	   Align Footer Menu Items
	   ========================================================================== */

	if($('#footer-navigation ul').length > 0) {
		function footerMenu() {
			/* Dynamic equal width in Footer-Menu */
			var footerList = $('#footer-navigation li').not('#footer-navigation li li');
			var maxHeight = -1;
			var heights = footerList.map(function () {
				return $(this).height();
			}).get(),
			maxHeight = Math.max.apply(null, heights);
			footerList.each(function() {
				$(this).height('auto');
				$(this).height(maxHeight);
			});
			var c = footerList.length;
			var n = 100 / c;
			if((viewport.width() < 960) && (viewport.width() > 640)) {
				switch(c) {
					case (c = 4 || 8):
						footerList.css('width', '25%');
						break;
					case (c = 6 || 9):
						footerList.css('width', '33.333%');
						break;
					default:
						footerList.css('width', n + '%');
				}
			} else {
				switch(c) {
					case (c == 4 || 8):
						footerList.css('width', '25%');
						break;
					case (c == 12):
						footerList.css('width', '16.666%');
						break;
					case (c == 5 || 10 || 15):
						footerList.css('width', '20%');
						break;
					default:
						footerList.css('width', n + '%');
				}
			}	
		}
		footerMenu();
		viewport.on({
			'resize': function() {
				footerMenu();
			},
			'orientationchange': function() {
				footerMenu();
			}
		});
	}

	/* ==========================================================================
	   Header Navigation
	   ========================================================================== */


	if(html.hasClass('no-touch')) {
		var lastScrollTop = 0;
		viewport.scroll(function(event){
			var st = $(this).scrollTop();
			if (st > lastScrollTop){				
				if(!html.hasClass('active-menu') || !html.hasClass('active-search')) {
					// scroll at least 72px from top
					if (st > (lastScrollTop + 8)) {
						if (html.scrollTop() > 128) {
							html.removeClass('state-nav-is-visible');
							html.addClass('state-nav-is-hidden');
						}
					}
				}
			} else {
				// show navigation
				html.removeClass('state-nav-is-hidden');
				html.addClass('state-nav-is-visible');
			}
			lastScrollTop = st;
		});
	}

	var navWidth = $('#navigation').width();
	var logoWidth = $('#logo').width();
	var searchWidth = $('#search-handler').width();

	function navCollapse() {
		var headerWidth = $('#header').width();

		if ((logoWidth + navWidth + searchWidth) > (headerWidth - 144)) {
			html.addClass('hidden-menu');
		} else {
			html.removeClass('hidden-menu');
			html.removeClass('active-menu');
			$('#navigation-handler').removeClass('active');
		}
		
	};
	navCollapse();
	viewport.on({
		'resize': function() {
			navCollapse();
		},
		'orientationchange': function() {
			navCollapse();
		}
	});
	
	

	$('#navigation-handler').click(function() {
		$(this).toggleClass('active');
		html.toggleClass('active-menu').removeClass('active-search');
		$('#search-handler').removeClass('active');
		$('#search').removeClass('open');
	});

	$('#search-handler').click(function() {
		$(this).toggleClass('active');
		html.toggleClass('active-search').removeClass('active-menu');
		$('#navigation-handler').removeClass('active');

		$('#search').toggleClass('open');
		$('#search .searchform-input').focus();
		$('#search-close').show();
	});
	
	/* ==========================================================================
	   Responsive Videos
	   ========================================================================== */

	$('.post-content').fitVids();
	$('.post-video').fitVids();
	
	/* ==========================================================================
	   Parallax
	   ========================================================================== */
	
	if(html.hasClass('no-touch')) {
	
		$('[data-type]').each(function() {
			$(this).data('speed', $(this).attr('data-speed'));
		});
		
		$('[data-type="prlx"]').each(function() {
			var self = $(this);
			var coverPosition = 0;
		
			function prlx() {
				var windowPosition = viewport.scrollTop();
				(windowPosition > 0) ? coverPosition = Math.floor(windowPosition * self.data('speed')) : coverPosition = 0;
				var opc = 1 - windowPosition / 400;
				if(self.hasClass('page-header-cover')) {
					opc = opc * 0.875;
				}
				self.css({
					'-ms-transform' : 'translate(0px, ' + coverPosition + 'px)',
					'-webkit-transform' : 'translate3d(0px, ' + coverPosition + 'px, 0px)',
					'transform' : 'translate3d(0px, ' + coverPosition + 'px, 0px)',
					'opacity' : opc
				});
			}
			prlx();
			viewport.on({
				'scroll': function() {
					prlx();
				},
				'resize': function() {
					prlx();
				},
				'orientationchange': function() {
					prlx();
				}
			});
		});
	}
});
