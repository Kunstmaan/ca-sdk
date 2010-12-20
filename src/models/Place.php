<?php
  class Place extends BaseModel {

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

    protected $table = "ca_places";
    protected $primary_key_name = "place_id";

    public function __construct($primaryKey, $itemInfoController, $valuesArray) {
      parent::__construct($primaryKey, $itemInfoController, $valuesArray);
    }

  }
?>
