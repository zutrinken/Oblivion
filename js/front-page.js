var container = document.querySelector('#masonry');
var msnry = new Masonry( container, {
	itemSelector			: '.masonry-item',
	isAnimated				: false,
	gutter					: 0,
	columnWidth				: 1,
	transitionDuration		: 0
});

jQuery(function($) {
	var viewport = $(window);
	function fading() {
		$('.featured-post').each( function(){

			var bottom_of_object = $(this).position().top + $(this).outerHeight();
			var bottom_of_window = viewport.scrollTop() + viewport.height();

			if( bottom_of_window > bottom_of_object ) {
				$(this).addClass('show');
			} else {
/* 				$(this).removeClass('show'); */
			}
		});
	}
	if($('html').hasClass('no-touch')) {
		fading();
		viewport.scroll(fading);
		viewport.resize(fading);
		viewport.bind('orientationchange', function() {
			fading();
		});
	}
});