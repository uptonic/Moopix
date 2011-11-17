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
	
	<link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" title="" charset="utf-8">
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="" charset="utf-8">
	<link rel="stylesheet" href="css/grid.css" type="text/css" media="screen" title="" charset="utf-8">
	
	<script src="js/jquery-1.4.3.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/protos.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.lazyload.js" type="text/javascript" charset="utf-8"></script>
	<script src="fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
  <div class="container_12">
		
		<div id="header" class="grid_12">
		  &nbsp;
		</div>
		
		<div class="clear"></div>
		
		<div id="albums" class="grid_9">
			<!-- START image -->
      <p><img src="{IMAGE_SRC}" /></p>
      <!-- END image -->
		</div>
		
		<div id="menu" class="grid_3">
		  <ul>
		    <!-- START menu -->
        <li><a href="?alb={ALBUM_NAME}"{ALBUM_SELECTED}>{ALBUM_TITLE}</a></li>
        <!-- END menu -->
		  </ul>
		</div>
		
		<div class="clear"></div>
	</div>
</body>
</html>