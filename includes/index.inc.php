<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>{THIS_PAGE_TITLE} | WSOD Prototype Extranet</title>
	
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="imagetoolbar" content="false" />
	<meta name="copyright" content="" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="index, follow" />
	<meta name="MSSmartTagsPreventParsing" content="true" />
	
	<script src="js/jquery-1.4.1.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/protos.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.lazyload.js" type="text/javascript" charset="utf-8"></script>
	<script src="fancybox/jquery.fancybox-1.3.1.pack.js" type="text/javascript" charset="utf-8"></script>
	
	<link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.1.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="css/grid.css" type="text/css" media="screen" title="" charset="utf-8">
</head>

<body>
	<div id="header">
		<div id="header-accent">
			<div id="header-nav-wrapper">
				<div id="header-nav">
					<select name="jump-menu" id="jump-menu">
						<option value="" selected="selected">Jump to...</option>
						<!-- START album -->
						<optgroup label="{ALBUM_TITLE}">
							<!-- START category -->
							<option value="?alb={ALBUM_NAME}&amp;cat={CATEGORY_NAME}">- {CATEGORY_TITLE}</option>
							<!-- END category -->
							<option value=""></option>
						</optgroup>
						<!-- END album -->
					</select>
				</div>
			</div>
		</div>
	</div>
	
	<div id="body-wrapper" class="container_12">
		
		<div id="title" class="grid_9">
			<h2>{THIS_ALBUM_TITLE} <em>&nbsp;/&nbsp;</em> <span><a href="?alb={THIS_ALBUM_NAME}&amp;cat={THIS_CATEGORY_NAME}">{THIS_CATEGORY_TITLE}</a></span></h2>
		</div>
		
		<div class="clear"></div>
		
		<div class="grid_12">
			<ul class="set_list">
				<!-- START set -->
				<li{SET_FIRST}>
					<div class="image_wrapper">
						<div class="side_title_wrapper">
							<h4>{SET_NAME}</h4>
							<h5>{SET_COUNT} items</h5>
						</div>
						<a href="?alb={THIS_ALBUM_NAME}&amp;cat={THIS_CATEGORY_NAME}&amp;set={SET_NAME}" title="{IMAGE_NAME}"><img src="{SET_THUMB_SRC}" alt="" height="150" width="200" /></a>
					</div>
				</li>
				<!-- END set -->
			</ul>
		</div>
		
		<div class="clear"></div>
		
	</div>
</body>
</html>