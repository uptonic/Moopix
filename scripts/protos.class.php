<?php
/*
#####################################################
Core gallery functions

FileName: protos.class.php
Author:		Scott Upton, Wall Street On Demand
#####################################################
*/

/* Protos Class
---------------------------------------------------*/

class Protos {
	
	private $doc;
	
	private $albumNode;
	
  public $xpath;
	public $album;
	
	public $albums;
  public $albumName;
	public $albumThumbnail;
	public $albumCount;
	public $albumDescription;	
	public $albumImages;
	
	public $basePath;
	
	/**
    * Protos constructor
    *
    * @param string $d filename for XML
    * @param string $a album name from URL string
    * @return object Protos
    */

	function __construct($d=NULL, $a=NULL){
		// Convert arguments for use elsewhere in this Class
		$this->album = $a;
		
		// Read in XML file
    $this->doc = new DomDocument();
		$this->doc->load($d);
		
		// New instance of XPath for querying the XML tree
    $this->xpath = new DOMXPath($this->doc);
		
		// If no params are passed in URL, set good defaults
		$albQuery = ($a == NULL ? 'album[1]' : '//album[@name="'.$this->album.'"]');
		
		// Query XML file to find album base node
		$this->albumNode = $this->xpath->query($albQuery);
	}
	
	// Find all albums in this gallery
	function getAllAlbums(){
		$this->albums = $this->xpath->query("//album");
		return $this->albums;
	}
	
	// Returns name of current album
	function getAlbumName(){
		$this->albumName = $this->albumNode->item(0)->getAttribute('name');
		return $this->albumName;
	}
	
	// Returns the description, if available, of this album
	function getAlbumDescription(){
		$this->albumDescription = $this->albumNode->item(0)->getAttribute('description');
		return $this->albumDescription;
	}
	
	// Returns the path to the thumbnail image, if available, of this album
	function getAlbumThumbnail($a){
		$this->albumThumbnail = $this->xpath->query('album[@name="'.$a.'"]/img[1]');
		return $this->albumThumbnail;
	}
	
	
	
	
	
	/*
	
	// Returns name of current category
	function getCategoryName(){
		$this->categoryName = $this->categoryNode->item(0)->getAttribute('name');
		return $this->categoryName;
	}
	
	// Find all sets in the specified category
	function getCategorySets(){
		$this->categorySets = $this->setNode;
		return $this->categorySets;
	}
	
	// Returns name of current set within the category
	function getSetName(){
		$this->setName = $this->setNode->item(0)->getAttribute('name');
		return $this->setName;
	}
	
	// Returns the description, if available, of this set
	function getSetDescription(){
		$this->setDescription = $this->setNode->item(0)->getAttribute('description');
		return $this->setDescription;
	}
	
	// Returns the path to the thumbnail image, if available, of this set
	function getSetThumbnail($s){
		$this->setThumbnail = $this->xpath->query('set[@name="'.$s.'"]/img[1]', $this->categoryNode->item(0));
		return $this->setThumbnail;
	}
	
	// Returns the number of image items in the supplied set
	function getSetCount($s){
		$this->setCount = $this->xpath->query('set[@name="'.$s.'"]/img', $this->categoryNode->item(0));
		return $this->setCount->length;
	}
	
	// Find all images in this set
	function getSetImages(){
		$this->setImages = $this->xpath->query("img", $this->setNode->item(0));
		return $this->setImages;
	}
	*/
	
	// Returns a path string to the parent directory of images in this set
	function getBasePath(){
		$this->basePath = "albums/".preg_replace('/ /', '-', $this->getAlbumName());
		return $this->basePath;
	}
}

?>