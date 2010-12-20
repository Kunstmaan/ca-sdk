<?php
  class Representation {

    private $primaryKey;

    private $primary;

    private $originalFilename;

    private $versions = array();

    private $annotations = array();

    private $mimeType;

    public function __construct($options = array()) {
      $this->primaryKey = $options['representation_id'];
      $this->originalFilename = $options['original_filename'];
      $this->primary = $options['is_primary'];
      $this->mimeType = $options['mime_type'];
    }

    public function getPrimaryKey() {
      return $this->primaryKey;
    }

    public function isPrimary(){
      return $this->primary;
    }

    public function getMimeType() {
      return $this->mimeType;
    }

    public function addVersion($name, $url, $info) {
      $this->versions[$name] = new RepresentationVersion($url, $info);
    }

    public function getVersion($name) {
      return $this->versions[$name];
    }

    public function getOriginalFileName() {
      return $this->originalFilename;
    }

    public function addAnnotation($id, $info) {
      $this->annotations[$id] = $info;
    }

    public function getAnnotation($id) {
      return $this->annotations[$id];
    }

    public function getAnnotations() {
      return $this->annotations;
    }

  }

?>
