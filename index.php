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
$protos = new Protos($config['xml_file'], $alb);


/* Initialize templating engine
---------------------------------------------------*/

// Set the template file for this view
$templateFile = ($alb == NULL ? 'includes/index.inc.php' : 'includes/album.inc.php');

// New template instance
$fxlt = new fxl_template($templateFile);

// Find template blocks
$fxlt_menu    = $fxlt->get_block('menu');
$fxlt_album   = $fxlt->get_block('album');
$fxlt_image   = $fxlt->get_block('image');


/* Build listing of all albums
---------------------------------------------------*/

// Loop through albums to build menu structure
foreach($protos->getAllAlbums() as $a => $album){
    
	// Set album name & ID
	$fxlt_menu->assign('ALBUM_NAME', $album->getAttribute('name'));
	$fxlt_menu->assign('ALBUM_TITLE', cleanName($album->getAttribute('name'))); // name without dashes or underscores
	$fxlt_menu->assign('ALBUM_DESCRIPTION', $album->getAttribute('description'));

	// If the loop album is the current one selected append class
	($alb == $album->getAttribute('name')) ? $fxlt_menu->assign('ALBUM_SELECTED', ' class="selected"') : NULL;
	
	// Append menu to template and clear buffer
  $fxlt->assign('menu', $fxlt_menu);
  $fxlt_menu->clear();
}


/* Build image display for this set
---------------------------------------------------*/

if($alb == NULL){
	// If no album is specified, let's build a menu showing all the albums
	foreach($protos->getAllAlbums() as $a => $album){
		
		// Break album listing to new row if max reached
		if($a%$config['images_per_row'] == 0) { $fxlt_album->assign('ALBUM_FIRST', ' class="first"'); }
		
		// Grab first thumbnail for each set
		$t = $protos->getAlbumThumbnail($album->getAttribute('name'));
		
		// Define the path to the image for display
		$thumb_src = $config['album_path'].'/'.$album->getAttribute('name').'/'.$t->item(0)->getAttribute('src');
			
		// Treat PDFs a little differently, loading a blank image instead
		if($t->item(0)->getAttribute('data-extension') == "pdf") {
			$fxlt_album->assign('ALBUM_THUMB_SRC', $config['pdf_thumb']);
		} else if ($t->item(0)->getAttribute('data-extension') == "mov") {
			$fxlt_album->assign('ALBUM_THUMB_SRC', $config['mov_thumb']);
		} else {
			$fxlt_album->assign('ALBUM_THUMB_SRC', resize($thumb_src, $config['image_thumb_settings']));
		}	
		
		// Assign the name for this set
		$fxlt_album->assign('ALBUM_THUMB_WIDTH', $config['image_thumb_w']);
		$fxlt_album->assign('ALBUM_THUMB_HEIGHT', $config['image_thumb_h']);
		$fxlt_album->assign('ALBUM_NAME', $album->getAttribute('name'));
  	$fxlt_album->assign('ALBUM_TITLE', cleanName($album->getAttribute('name')));
		$fxlt_album->assign('ALBUM_MODIFIED', _ago($album->getAttribute('data-last-modified')));
		$fxlt_album->assign('ALBUM_DESCRIPTION', $album->getAttribute('description'));
		$fxlt_album->assign('ALBUM_COUNT', $protos->getAlbumCount($album->getAttribute('name')));
		
		// Append image to page
		$fxlt->assign('album', $fxlt_album);

		// Clear the buffer
	  $fxlt_album->clear();
	}
} else {
	// Loop through images in this set
	foreach($protos->getAlbumImages($alb) as $i => $image){
		
		// Break images to new row if max reached
		//if($i%$config['images_per_row'] == 0) { $fxlt_image->assign('IMAGE_FIRST', ' class="first"'); }
		
		// Show title if available from the XML, otherwise just show the filename
		$image_title = ($image->getAttribute('title')) ? $image->getAttribute('title') : $image->getAttribute('src');
    
    // Define the path to the image for display
		$image_src =  $config['album_path'].'/'.$protos->getAlbumName().'/'.$image->getAttribute('src');
    
    echo $image_src."<br />";
    
    /*
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
	  */
	}
}


/* General template settings
---------------------------------------------------*/

// Set current URL params for filter links
$fxlt->assign('THIS_ALBUM_ID', $alb);
$fxlt->assign('THIS_CATEGORY_ID', $cat);

// Title element in the header
$fxlt->assign('SITE_NAME', cleanName($config['site_name']));
$fxlt->assign('PAGE_TITLE', cleanName($protos->getAlbumName()));

/*
// Assign the currently-viewed album a title
$fxlt->assign('THIS_ALBUM_NAME', $protos->getAlbumName());
$fxlt->assign('THIS_ALBUM_TITLE', cleanName($protos->getAlbumName()));
*/

/* Display template
---------------------------------------------------*/

// Write to page
$fxlt->display();
?>