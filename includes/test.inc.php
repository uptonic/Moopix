<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>{PAGE_TITLE} | {SITE_NAME}</title>
	
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="imagetoolbar" content="false" />
	<meta name="copyright" content="" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="index, follow" />
	<meta name="MSSmartTagsPreventParsing" content="true" />
	
	<script src="js/jquery-1.4.3.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/protos.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.lazyload.js" type="text/javascript" charset="utf-8"></script>
	<script src="fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript" charset="utf-8"></script>
	
	<link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" title="" charset="utf-8">
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="" charset="utf-8">
	<link rel="stylesheet" href="css/grid.css" type="text/css" media="screen" title="" charset="utf-8">
</head>

<body>
  <!-- START menu -->
  <div>
    <h3><a href="?alb={ALBUM_NAME}">{ALBUM_TITLE}</a></h3>
  </div>
  <!-- END menu -->
  
  <div id="body-wrapper" class="container_12">
		
		<div id="title" class="grid_9">
			<h2>Title will go here.</h2>
		</div>
		
		<div class="clear"></div>
		
		<div class="grid_12">
			<ul class="set_list">
				<!-- START album -->
				<li{SET_FIRST}>
					<div class="image_wrapper">
						<div class="side_title_wrapper">
							<h4>{ALBUM_TITLE}</h4>
							<h5>{ALBUM_COUNT} items</h5>
						</div>
						
						<a href="?alb={ALBUM_NAME}" title="{IMAGE_NAME}">
						  <img src="{ALBUM_THUMB_SRC}" alt="" height="{ALBUM_THUMB_HEIGHT}" width="{ALBUM_THUMB_WIDTH}" />
						</a>
					</div>
				</li>
				<!-- END album -->
			</ul>
		</div>
		
		<div class="clear"></div>
		
		<div class="grid_12" style="margin-top:30px">
  	  <p style="font-size:11px;border-top:1px solid #ccc;padding-top:10px"><a id="publish_images" href="images.php">Publish Images...</a></p>
  	</div>
		
	</div>
</body>
</html>