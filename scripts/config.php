<?php

/* Basic settings for the protos
---------------------------------------------------*/

// Set default timezone
date_default_timezone_set("America/Denver");

// Name of the site
$site_name = "Randall Levensaler";

// Thumbnail dimensions defaults
$resize_w = 200;
$resize_h = 150;

// Thumbnail resize settings
$resize_settings = array('w'=>$resize_w,'h'=>$resize_h,'crop'=>1);

// Number of thumbnails per row
$sets_per_row = 3;
$images_per_row = 4;

// Default thumbnail image for PDF & MOV files
$pdf_thumb = "img/thumb_pdf.gif";
$mov_thumb = "img/thumb_mov.gif";

// Set data file location
$xmlFile = "images.xml";


/* Do not edit below this line
---------------------------------------------------*/

// Get params from query string
$alb = getRequestField('alb');

?>