<?php
  class Relationship {

    private $relationId;

    private $displayname;

    //id of the related object
    private $relatedObjectId;

    //type of the realted object e.g ca_objects,ca_places etc
    public $relatedObjectType;

    //id of ca_relationship_types
    private $relationshipTypeId;

    //type_code of ca_relationship_types e.g marker, registrar etc.
    private $relationshipTypeName;

    private $fieldMapping = array("ca_objects" => 'object_id', "ca_entities" => 'entity_id', "ca_places" => 'place_id', "ca_occurences" => 'occurence_id', "ca_collections" => 'collection_id', 'ca_list_items' => 'item_id');

    private $itemInfoController;

    public function __construct($options = array()) {
      $this->itemInfoController = $options['item_info_service'];
      $this->relationId = $options['relation_id'];
      $this->relatedObjectType = $options['related_object_type'];
    }

    public function setRelatedObjectId($resultData){
      $IdField = $this->relatedObjectType;
      $this->relatedObjectId = $resultData[$this->fieldMapping[$IdField]];
    }

    public function getPrimaryKey() {
      return $this->relationId;
    }

    public function getRelatedObject() {
      if(isset($this->relatedObjectId)){
        if($this->itemInfoController == null) {
         //throw new Exception('Item info controller can not be null.');
         return null;
        }
        return $this->itemInfoController->getItem($this->relatedObjectType, $this->relatedObjectId);
      }
    }

    public function setDisplayName($name) {
      $this->displayname = $name;
    }

    public function getDisplayName() {
      return $this->displayname;
    }

    public function setRelationshipTypeId($typeId) {
      $this->relationshipTypeId = $typeId;
    }

    public function setRelationshipTypeName($typeName) {
      $this->relationshipTypeName = $typeName;
    }

    public function getRelationshipTypeName() {
      return $this->relationshipTypeName;
    }

    public function getRelatedObjectId() {
      return $this->relatedObjectId;
    }

    private $instance;

    public function load() {
      if(isset($this->instance)) {
        return $this->instance;
      }
      if(isset($this->itemInfoController) && ($this->itemInfoController instanceof ItemInfoServiceController)) {
        $resultInstance = $this->itemInfoController->getItem($this->relatedObjectType, $this->relatedObjectId);
        $this->instance = $resultInstance;
        return $resultInstance;
      }
    }

  }
?>