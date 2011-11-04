<?php

/* Basic settings for the protos
---------------------------------------------------*/

// Set default timezone
date_default_timezone_set("America/Denver");

// Default settings
$config = array();
$config['site_name']        = "Randall Levensaler";   // Name of the site
$config['resize_w']         = 200;                    // Default thumbnail width
$config['resize_h']         = 150;                    // Default thumbnail height
$config['images_per_row']   = 3;                      // Number of thumbnails per row
$config['pdf_thumb']        = "img/thumb_pdf.gif";    // Default thumbnail image for PDF files
$config['mov_thumb']        = "img/thumb_mov.gif";    // Default thumbnail image for MOV files
$config['xml_file']         = "images.xml";           // Location of images XML file
$config['album_path']       = "albums";               // Folder where you store your albums

/*Do not edit below this line
---------------------------------------------------*/

// Thumbnail resize settings
$config['resize_settings'] = array('w'=>$config['resize_w'],'h'=>$config['resize_h'],'crop'=>true,'canvas-color'=>"#ffffff");

// Get params from query string
$alb = getRequestField('alb');

?>