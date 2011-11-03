<?php
/*
#####################################################
Builds XML file for a gallery based on the filesystem

FileName:   images.php
Author:     Uptonic
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
						
		foreach($album['content'] as $image) {
			if($image['extension'] == "txt"){
				
				// Read in text file and use contents for description								
				$f = $image['path'].'/'.$image['file'];
				$fh = fopen($f, 'r');
				$contents = fread($fh, filesize($f));
				fclose($fh);
				
				// Add description attribute to this set if available
				$a->setAttribute('description', $contents);
				
			} else {
				$img = $doc->createElement('img');

				//$img->setAttribute('path', $image['path']);
				$img->setAttribute('src', $image['file']);
				$img->setAttribute('width', $image['width']);
				$img->setAttribute('height', $image['height']);
				$img->setAttribute('title', getImageTitle($image['file']));
				$img->setAttribute('data-extension', $image['extension']);
				$img->setAttribute('data-last-modified', $image['modified']);

				$a->appendChild($img);
			}
		}
		
		// Close the album tag
		$r->appendChild($a);
	}
}

$doc->save("images.xml");
header('Location: images_success.php');
?>