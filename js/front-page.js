var container = document.querySelector('#masonry');
var msnry = new Masonry( container, {
	itemSelector: '.featured-post',
	isAnimated: false,
	"gutter": 0,
	"columnWidth":1,
	"transitionDuration": 0 
});