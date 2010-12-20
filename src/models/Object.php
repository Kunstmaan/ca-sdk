<?php
  class Object extends BaseModel {

    protected $collectionId;
    protected $localeId;
    protected $typeId;
    protected $idno;
    protected $idnoSort;
    protected $sourceId;
    protected $sourceInfo;
    protected $hierCollectionId;
    protected $hierLeft;
    protected $hierRight;
    protected $access;
    protected $status;
    protected $deleted;

    protected $primary_representation;
    protected $representations = array();

    protected $table = "ca_objects";
    protected $primary_key_name = "object_id";

    public function __construct($primaryKey, $itemInfoController, $valuesArray) {
      parent::__construct($primaryKey, $itemInfoController, $valuesArray);
    }

    public function addObjectRepresentation($representation){
      $this->representations[] = $representation;
      if($representation->isPrimary()) {
        $primary_representation = $representation;
      }
    }

    public function getObjectRepresentations(){
      return $this->representations;
    }

    public function getPrimaryObjectRepresentation(){
      if(isset($primary_representation)) {
        return $primary_representation;
      }
      foreach($this->representations as $representation){
        if($representation->isPrimary()){
          $primary_representation = $representation;
          return $representation;
        }
      }
    }

    public function getIdNumber() {
      return $this->idno;
    }

    protected function setValuesArray($valuesArray) {
      parent::setValuesArray($valuesArray);
      if(isset($valuesArray["object_representations"]) && is_array($valuesArray["object_representations"])) {
        //read representations and save them into array of Representation
        $reprsentations = $valuesArray["object_representations"];
        foreach($reprsentations as $key => $value) {
          $representation = new Representation(array(
            'representation_id' => $key,
            'original_filename' => $value['meta_data']['original_filename'],
            'mime_type' => $value['meta_data']['mime_type'],
            'is_primary' => $value['meta_data']['is_primary']
          ));

          foreach($value['versions'] as $version => $info) {
            $representation->addVersion($version, $info['url'], $info['info']);
          }

          foreach($value['annotations'] as $annotation) {
            $representation->addAnnotation($annotation['annotation_id'], $annotation);
          }
          $this->addObjectRepresentation($representation);
        }
      }
    }
  }
?>
