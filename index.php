<?php
/*
#####################################################
This page defines the photo display pages

FileName:   index.php
Author:     Uptonic
#####################################################
*/

// Include external files
require_once(dirname(__FILE__).'/scripts/protos.class.php');
require_once(dirname(__FILE__).'/scripts/protos.utils.php');
require_once(dirname(__FILE__).'/scripts/function.resize.php');
require_once(dirname(__FILE__).'/scripts/fxl_template.inc.php');
require_once(dirname(__FILE__).'/scripts/config.php');

// new instance of Protos Class
$protos = new Protos($xmlFile, $alb);


/* Initialize templating engine
---------------------------------------------------*/

// Set the template file for this view
//$templateFile = ($alb == NULL ? 'includes/index.inc.php' : 'includes/album.inc.php');
$templateFile = 'includes/test.inc.php';

// New template instance
$fxlt = new fxl_template($templateFile);

// Find template blocks
$fxlt_album = $fxlt->get_block('album');
$fxlt_image = $fxlt->get_block('image');


/* Build listing of all albums
---------------------------------------------------*/

// Loop through albums to build menu structure
foreach($protos->getAllAlbums() as $a => $album){
    
	// Set album name & ID
	$fxlt_album->assign('ALBUM_NAME', $album->getAttribute('name'));
	$fxlt_album->assign('ALBUM_TITLE', cleanName($album->getAttribute('name'))); // name without dashes or underscores
	
	// If the loop album is the current one selected append class
	($alb == $album->getAttribute('name')) ? $fxlt_album->assign('ALBUM_SELECTED', ' class="selected"') : NULL;
	
	// Append album to template and clear buffer
  $fxlt->assign('album', $fxlt_album);
  $fxlt_album->clear();
}


/* Build image display for this set
---------------------------------------------------*/

if($environment == "production"){
  // Loop through images in this set
  foreach($protos->getSetImages() as $i => $image){

  	// Break images to new row if max reached
  	if($i%$images_per_row == 0) { $fxlt_image->assign('IMAGE_FIRST', ' class="first"'); }

  	// Show title if available from the XML, otherwise just show the filename
  	$image_title = ($image->getAttribute('title')) ? $image->getAttribute('title') : $image->getAttribute('src');

  	// Define the path to the image for display
  	$image_src =  $protos->getBasePath().'/'.$protos->getSetName().'/'.$image->getAttribute('src');

  	// Define other image attributes
  	$fxlt_image->assign('IMAGE_TITLE', $image_title);
  	$fxlt_image->assign('IMAGE_MODIFIED', _ago($image->getAttribute('data-last-modified')));
  	$fxlt_image->assign('IMAGE_SRC', $image_src);

  	// Treat PDFs a little differently, loading a blank image instead
  	if($image->getAttribute('data-extension') == "pdf") {
  		$fxlt_image->assign('IMAGE_THUMB_SRC', $pdf_thumb);
  	} else if($image->getAttribute('data-extension') == "mov"){
  		$fxlt_image->assign('IMAGE_THUMB_SRC', $mov_thumb);
  		$fxlt_image->assign('IMAGE_REL', 'video');
  	} else {
  		$fxlt_image->assign('IMAGE_THUMB_SRC', resize($image_src, $resize_settings));
  		$fxlt_image->assign('IMAGE_REL', 'lightbox');
  	}

  	// Append image to page
  	$fxlt->assign('image', $fxlt_image);

  	// Clear the buffer
    $fxlt_image->clear();
  }
}


/* General template settings
---------------------------------------------------*/

// Set current URL params for filter links
$fxlt->assign('THIS_ALBUM_ID', $alb);
$fxlt->assign('THIS_CATEGORY_ID', $cat);

// Title element in the header
$fxlt->assign('SITE_NAME', "Randall Levensaler");
$fxlt->assign('PAGE_TITLE', cleanName($protos->getAlbumName()));

// Assign the currently-viewed album a title
$fxlt->assign('THIS_ALBUM_NAME', $protos->getAlbumName());
$fxlt->assign('THIS_ALBUM_TITLE', cleanName($protos->getAlbumName()));


/* Display template
---------------------------------------------------*/

// Write to page
$fxlt->display();
?>