<?php
/*
#####################################################
Builds XML file for a gallery based on the filesystem

FileName:   images.php
Author:     Uptonic
Version:    2011.05.16
#####################################################
*/

// Include class file
require_once(dirname(__FILE__).'/scripts/protos.utils.php');
require_once(dirname(__FILE__).'/scripts/function.recurse.php');
require_once(dirname(__FILE__).'/scripts/config.php');

// Get file structure
$albums = scan_directory_recursively('albums');

// Let's build some XML
$doc = new DOMDocument("1.0", "UTF-8");
$doc->formatOutput = TRUE;

// Create root node for the gallery
$r = $doc->createElement( "gallery" );
$doc->appendChild($r);

// Cycle through albums
foreach($albums as $album) {
	
	// Ignore albums that don't contain content
	if($album['content'] != NULL){
	
		// New album tag
		$a = $doc->createElement('album');
		$a->setAttribute('name', $album['name']);
		$a->setAttribute('modified', $album['modified']);
	
		// Expecting subfolders like "prototypes" and "wireframes"
		foreach($album['content'] as $category) {
		
			// Ignore categories that don't contain any prototypes
			if($category['content'] != NULL){

				// New category tag
				$c = $doc->createElement('category');
				$c->setAttribute('name', $category['name']);
				$c->setAttribute('modified', $category['modified']);
				
				// Sort the date sets so newest is first
				$category['content'] = orderDesc($category['content'], 'name');

				// Build the list of images in each album
				foreach($category['content'] as $set) {
					
					// Ignore any datefolder that doesn't contain images
					if($set['content'] != NULL){
						
						// New subfolder tag
						$g = $doc->createElement('set');
						$g->setAttribute('name', $set['name']);
						$g->setAttribute('modified', $set['modified']);
						
						// Sort the images so newest is first
						$set['content'] = orderAsc($set['content'], 'file');
						
						foreach($set['content'] as $image) {
							if($image['extension'] == "txt"){
								
								// Read in text file and use contents for description								
								$f = $image['path'].'/'.$image['file'];
								$fh = fopen($f, 'r');
								$contents = fread($fh, filesize($f));
								fclose($fh);
								
								// Add description attribute to this set if available
								$g->setAttribute('description', $contents);
								
							} else {
								$img = $doc->createElement('img');

								//$img->setAttribute('path', $image['path']);
								$img->setAttribute('src', $image['file']);
								$img->setAttribute('width', $image['width']);
								$img->setAttribute('height', $image['height']);
								$img->setAttribute('title', getImageTitle($image['file']));
								$img->setAttribute('data-extension', $image['extension']);
								$img->setAttribute('data-last-modified', $image['modified']);

								$g->appendChild($img);
							}
						}
						
						$c->appendChild($g);					
					}
				}

				// Close the category tag
				$a->appendChild($c);
			}		
		}
		
		// Close the album tag
		$r->appendChild($a);
	}
}

//header('Content-Type: text/xml');
//echo $doc->saveXML();

$doc->save("images.xml");
header('Location: images_success.php');
?>