$(function() {
	// Open PDFs and links to full-size image pop-outs in new window
	$("a[href$=.pdf],a[href$=.mov],.thumb_zoom a").click(function(){
		window.open(this.href);
		return false;
	});
	
	// Attach fancybox for all other images
	$("a[rel=lightbox]").fancybox({
		'titlePosition'	: 'inside',
		'overlayOpacity' : 0.8,
		'overlayColor' : '#1a1a1a',
		'autoScale': true,
		'titleFormat': function(title, currentArray, currentIndex, currentOpts) {
			return '<div class="pop_zoom"><a href="'+this.href+'" target="_blank">View Full-Size</a></div><span><strong>' + (currentIndex + 1) + ' of ' + currentArray.length + ':</strong> ' + this.title + '</span>';
		}
	});
				
	// Only load images in the viewport
	$("img").lazyload({ 
		effect : "fadeIn"
	});
	
	/*
	// Find all images and dim them out
	$("#albums li").css('opacity', 0.8);
	
	$("#albums li").hover(function(){
		$(this).fadeTo('fast', 1.0);
		$("div.thumb_zoom", this).fadeTo('fast', 0.5);
	}, function(){
		$(this).fadeTo('fast', 0.7);
		$("div.thumb_zoom", this).fadeTo('fast', 0.0);
	});
	*/
});