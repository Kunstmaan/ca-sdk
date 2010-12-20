<?php
  class Label {

    public $primaryKey;
    private $locale;
    private $preferred;
    private $value;

    public function __construct($options) {
      $this->primaryKey = $options['label_id'];
      $this->locale = $options['locale'];
      $this->preferred = $options['is_preferred'];
      $this->value = $options['value'];
    }

    public function isPreferred(){
      return $this->preferred;
    }

    public function getLabel() {
      return $this->value;
    }

    public function getPrimaryKey() {
      return $this->primaryKey;
    }

    public function getLocale() {
      return $this->locale;
    }

  }

?>
