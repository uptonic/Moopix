<?php

/* Basic settings for the protos
---------------------------------------------------*/

// Set default timezone
date_default_timezone_set("America/Denver");

// Default settings
$config = array();
$config['site_name']        = "Randall Levensaler";   // Name of the site
$config['image_thumb_w']    = 200;                    // Default thumbnail width
$config['image_thumb_h']    = 150;                    // Default thumbnail height
$config['image_album_w']    = 700;                    // Default album image width
$config['image_album_h']    = 500;                    // Default album image height
$config['images_per_row']   = 3;                      // Number of thumbnails per row
$config['pdf_thumb']        = "img/thumb_pdf.gif";    // Default thumbnail image for PDF files
$config['mov_thumb']        = "img/thumb_mov.gif";    // Default thumbnail image for MOV files
$config['xml_file']         = "images.xml";           // Location of images XML file
$config['album_path']       = "albums";               // Folder where you store your albums

/*Do not edit below this line
---------------------------------------------------*/

// Thumbnail resize settings
$config['image_thumb_settings'] = array(
  'w'     => $config['image_thumb_w'],
  'h'     => $config['image_thumb_h'],
  'crop'  => true,
  'scale' => true,
);

// Album image resize settings
$config['image_album_settings'] = array(
  'w'     => $config['image_album_w'],
  'scale' => false,
);

// Get params from query string
$alb = getRequestField('alb');

?>