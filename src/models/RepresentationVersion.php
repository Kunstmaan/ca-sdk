<?php
  class RepresentationVersion {

    private $url;

    private $width;
    private $height;

    private $fileName;

    private $info = array();

    public function __construct($url, $info = array()) {
      $this->url = $url;
      $this->info = $info;
      $this->fileName = $info['FILENAME'];

      $properties = $info['PROPERTIES'];
      $this->width = $properties['width'];
      $this->height = $properties['height'];
    }

    public function getUrl(){
      return $this->url;
    }

    public function getMime() {
      return $this->info['MIMETYPE'];
    }

    public function getInfo() {
      return $this->info;
    }

    public function getWidth() {
      return $this->width;
    }

    public function getHeight() {
      return $this->height;
    }

    public function getFileName() {
      return $this->fileName;
    }

  }

?>
