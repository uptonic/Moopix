<?php
/*
#####################################################
Core gallery functions

FileName:   protos.class.php
Author:		Scott Upton, Wall Street On Demand
Version:    2010.03.16
#####################################################
*/

/* Protos Class
---------------------------------------------------*/

class Protos {
	
	private $doc;
	
	private $albumNode;
	private $categoryNode;
	private $setNode;
	
    public $xpath;
	public $album;
	public $category;
	public $set;
	public $categorySets;
	
	public $albums;
  	public $albumName;
  	public $categoryName;
  	public $setName;
	public $setThumbnail;
	public $setCount;
	public $setDescription;
	public $basePath;
	
	public $setImages;
	
	
	/**
    * Protos constructor
    *
    * @param string $d filename for XML
    * @param string $a album name from URL string
    * @param string $c category name from URL string
    * @param string $s set name from URL string
    * @return object Protos
    */

	function __construct($d=NULL, $a=NULL, $c=NULL, $s=NULL){
		// Convert arguments for use elsewhere in this Class
		$this->album = $a;
		$this->category = $c;
		$this->set = $s;
		
		// Read in XML file
        $this->doc = new DomDocument();
		$this->doc->load($d);
		
		// New instance of XPath for querying the XML tree
        $this->xpath = new DOMXPath($this->doc);
		
		// If no params are passed in URL, set good defaults
		$albQuery = ($a == NULL ? 'album[1]' : '//album[@name="'.$this->album.'"]');
		$catQuery = ($c == NULL ? 'category[1]' : 'category[@name="'.$this->category.'"]');
		$setQuery = ($s == NULL ? 'set' : 'set[@name="'.$this->set.'"]');
		
		// Query XML file to find album, category, and set base nodes
		$this->albumNode = $this->xpath->query($albQuery);
		$this->categoryNode = $this->xpath->query($catQuery, $this->albumNode->item(0));
		$this->setNode = $this->xpath->query($setQuery, $this->categoryNode->item(0));
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
	
	// Returns a path string to the parent directory of images in this set
	function getBasePath(){
		$this->basePath = "albums/".preg_replace('/ /', '-', $this->getAlbumName())."/".$this->getCategoryName();
		return $this->basePath;
	}
}

?>