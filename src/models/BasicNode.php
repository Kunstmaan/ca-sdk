<?php
  class BasicNode implements Node {

    private $primaryKey;
    private $parentId;
    private $idno;
    private $table;
    
    private $preferredLabel = array();
    private $labelsArray = array();
    
    private $itemInfoController;
    
    protected $ancestor;
    protected $children = array();

    public function __construct($primaryKey = 0, $options = array()) {
      $this->primaryKey = $primaryKey;
      $this->parentId = $options['parent_id'];
      $this->idno = $options['idno'];
      $this->table = $options['table'];
      $this->itemInfoController = $toptions['item_info_controller'];
    }
    
    public function getPrimaryKey() {
    	return $this->primaryKey;
    }
    
    public function getParentId() {
      return $this->parentId;
    }
    
    public function getTable() {
      return $this->table;
    }
    
    public function addLabel($label) {
      if(!($label instanceof Label)) {
        throw new Exception("Not a valid label.");
      }
      $this->labelsArray[$label->getLocale()][$label->getPrimaryKey()] = $label;
      if($label->isPreferred()) {
        $this->preferredLabel[$label->getLocale()] = $label;
      }
      return $this;
    }

    public function getLabels($locale = null) {
      return $this->labelsArray[$locale];
    }

    public function getPreferredLabel($locale) {
      if(isset($this->preferredLabel[$locale])) {
        return $this->preferredLabel[$locale];
      }
      if(sizeof($this->preferredLabel) > 0) {
        return $this->preferredLabel[0];
      }
      return null;
    }
    
    public function setAncestor($ancestor, $addChild = true) {
      if(!($ancestor instanceof Node) || $ancestor->getTable() != $this->getTable()) {
        throw new Exception('Cannot configure the hierarchy for this type of ancestor.');
      }
      $this->ancestor = $ancestor;
      if($addChild) {
        $ancestor->addChild($this, false); 
      }
      return $this;
    }
    
    protected function hasChild($child) {
      foreach($this->getChildren() as $c) {
        if($c->getPrimaryKey() == $child->getPrimaryKey()){
          return true;
        }
      }
      return false;
    }
    
    public function addChild($child, $addAncestor = true) {
      if(!($child instanceof Node) || $child->getTable() != $this->getTable()) {
        throw new Exception('Cannot configure the hierarchy for this type of child.');
      }
      if(!$this->hasChild($child)) {
         $this->children[] = $child; 
      }
      if($addAncestor) {
        $child->addAncestor($this, false);
      }
      return $this;
    }
    
    public function getAncestor(){
      return $this->ancestor;
    }
    
    public function getChildren() {
      return $this->children;
    }
    
    private $instance;
    
    public function load() {
      if(isset($this->instance)) {
        return $this->instance;
      }
      if(isset($this->itemInfoController) && ($this->itemInfoController instanceof ItemInfoServiceController)) {
        $resultInstance = $this->itemInfoController->getItem($this->getTable(), $this->getPrimaryKey());
        $this->instance = $resultInstance;
        return $resultInstance;
      }
    }

  }
?>