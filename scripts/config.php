<?php

/* Basic settings for the protos
---------------------------------------------------*/

// Set default timezone
date_default_timezone_set("America/Denver");

// Default settings
$_MOO = array();
$_MOO['site_name']        = "Randall Levensaler";   // Name of the site
$_MOO['resize_w']         = 200;                    // Default thumbnail width
$_MOO['resize_h']         = 150;                    // Default thumbnail height
$_MOO['images_per_row']   = 4;                      // Number of thumbnails per row
$_MOO['pdf_thumb']        = "img/thumb_pdf.gif";    // Default thumbnail image for PDF files
$_MOO['mov_thumb']        = "img/thumb_mov.gif";    // Default thumbnail image for MOV files
$_MOO['xml_file']         = "images.xml";           // Location of images XML file


/*Do not edit below this line
---------------------------------------------------*/

// Thumbnail resize settings
$_MOO['resize_settings'] = array('w'=>$_MOO['resize_w'],'h'=>$_MOO['resize_h'],'crop'=>1);

// Get params from query string
$alb = getRequestField('alb');

?>