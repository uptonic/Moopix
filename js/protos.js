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
	
	// // Attach fancybox for all other images
	// 	$("a[rel=video]").fancybox({
	// 		'titlePosition'	: 'inside',
	// 		'overlayOpacity' : 0.8,
	// 		'overlayColor' : '#1a1a1a',
	// 		'width' : 640,
	// 		'height' : '480',
	// 		'type': 'iframe',
	// 		'titleFormat': function(title, currentArray, currentIndex, currentOpts) {
	// 			return '<div class="pop_zoom"><a href="'+this.href+'" target="_blank">View Full-Size</a></div><span><strong>' + (currentIndex + 1) + ' of ' + currentArray.length + ':</strong> ' + this.title + '</span>';
	// 		}
	// 	});
				
	// Only load images in the viewport
	$("img").lazyload({ 
		placeholder : "img/loading_static.gif",
		effect : "fadeIn"
	});
	
	// Find all images and dim them out
	$("li").css('opacity', 0.7);
	$("div.thumb_zoom").css('opacity',0.0);
	
	$("li").hover(function(){
		$(this).fadeTo('fast', 1.0);
		$("div.thumb_zoom", this).fadeTo('fast', 0.5);
	}, function(){
		$(this).fadeTo('fast', 0.7);
		$("div.thumb_zoom", this).fadeTo('fast', 0.0);
	});
	
	$("div.thumb_zoom").hover(function(){
		$(this).css('opacity', 1.0);
	}, function(){
		$(this).css('opacity', 0.3);
	});
	
	$("#jump-menu").change(function() {
		var val = $(this).val();
		if (val != '') {
			location.href = val;
		}
	});
});