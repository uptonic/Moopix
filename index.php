<?php
/*
#####################################################
This page defines the photo display pages

FileName:   index.php
Author:     Uptonic
Version:    2011.05.16
#####################################################
*/

// Include external files
require_once(dirname(__FILE__).'/scripts/protos.class.php');
require_once(dirname(__FILE__).'/scripts/protos.utils.php');
require_once(dirname(__FILE__).'/scripts/function.resize.php');
require_once(dirname(__FILE__).'/scripts/fxl_template.inc.php');
require_once(dirname(__FILE__).'/scripts/config.php');

// new instance of Protos Class
$protos = new Protos($xmlFile, $alb, $cat, $set);


/* Initialize templating engine
---------------------------------------------------*/

// Set the template file for this view
$templateFile = ($set == NULL ? 'includes/index.inc.php' : 'includes/set.inc.php');

// New template instance
$fxlt = new fxl_template($templateFile);

// Find template blocks
$fxlt_album 	= $fxlt->get_block('album');
$fxlt_category	= $fxlt_album->get_block('category');
$fxlt_image 	= $fxlt->get_block('image');
$fxlt_set	 	= $fxlt->get_block('set');


/* Build listing of all albums and their categories
---------------------------------------------------*/

// Loop through albums to build menu structure
foreach($protos->getAllAlbums() as $a => $album){
    
	// Set album name & ID
	$fxlt_album->assign('ALBUM_NAME', $album->getAttribute('name'));
	$fxlt_album->assign('ALBUM_TITLE', cleanName($album->getAttribute('name'))); // name without dashes or underscores
	
	// If the loop album is the current one selected append class
	($alb == $album->getAttribute('name')) ? $fxlt_album->assign('ALBUM_SELECTED', ' class="selected"') : NULL;
	
	// Get categories in this album
	$categories = $protos->xpath->query("//album[".($a+1)."]/category");
	
	// Loop through each album category
	foreach($categories as $c => $category){
		
		// If the loop category is the current one selected append class
		($alb == $album->getAttribute('name') && $cat == $category->getAttribute('name')) ? $fxlt_category->assign('CATEGORY_SELECTED', ' class="selected"') : NULL;
		
		// DEfine other category attributes
		$fxlt_category->assign('ALBUM_NAME', $album->getAttribute('name'));        
		$fxlt_category->assign('CATEGORY_NAME', $category->getAttribute('name'));
		$fxlt_category->assign('CATEGORY_TITLE', cleanName($category->getAttribute('name'))); // name without dashes or underscores
        $fxlt_album->assign('category', $fxlt_category);
        $fxlt_category->clear();
    }
	
	// Append album to template and clear buffer
    $fxlt->assign('album', $fxlt_album);
    $fxlt_album->clear();
}


/* Build image display for this set
---------------------------------------------------*/

if($set == NULL){
	// If no set is specified, let's build a menu showing all sets in this category
	foreach($protos->getCategorySets() as $cs => $catSet){
		
		// Break sets to new row if max reached
		if($cs%$sets_per_row == 0) { $fxlt_set->assign('SET_FIRST', ' class="first"'); }
		
		// Grab first thumbnail for each set
		$t = $protos->getSetThumbnail($catSet->getAttribute('name'));
		
		// Define the path to the image for display
		$thumb_src = $protos->getBasePath().'/'.$catSet->getAttribute('name').'/'.$t->item(0)->getAttribute('src');
		
		// Assign the name for this set
		$fxlt_set->assign('SET_NAME', $catSet->getAttribute('name'));
		$fxlt_set->assign('SET_MODIFIED', _ago($catSet->getAttribute('data-last-modified')));
		$fxlt_set->assign('SET_DESCRIPTION', $catSet->getAttribute('description'));
		$fxlt_set->assign('SET_COUNT', $protos->getSetCount($catSet->getAttribute('name')));
		
		// Treat PDFs a little differently, loading a blank image instead
		if($t->item(0)->getAttribute('data-extension') == "pdf") {
			$fxlt_set->assign('SET_THUMB_SRC', $pdf_thumb);
		} else if ($t->item(0)->getAttribute('data-extension') == "mov") {
			$fxlt_set->assign('SET_THUMB_SRC', $mov_thumb);
		} else {
			$fxlt_set->assign('SET_THUMB_SRC', resize($thumb_src, $resize_settings));
		}
		
		// Append image to page
		$fxlt->assign('set', $fxlt_set);

		// Clear the buffer
	    $fxlt_set->clear();
	
	}
} else {
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

// Assign the currently-viewed album a title
$fxlt->assign('THIS_PAGE_TITLE', cleanName($protos->getAlbumName()) ." - ". cleanName($protos->getCategoryName()));
$fxlt->assign('THIS_ALBUM_NAME', $protos->getAlbumName());
$fxlt->assign('THIS_ALBUM_TITLE', cleanName($protos->getAlbumName()));
$fxlt->assign('THIS_CATEGORY_NAME', $protos->getCategoryName());
$fxlt->assign('THIS_CATEGORY_TITLE', cleanName($protos->getCategoryName()));
$fxlt->assign('THIS_SET_NAME', $protos->getSetName());
$fxlt->assign('THIS_SET_DESCRIPTION', $protos->getSetDescription());


/* Display template
---------------------------------------------------*/

// Write to page
$fxlt->display();
?>