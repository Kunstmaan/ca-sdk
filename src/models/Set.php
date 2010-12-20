<?php
  class Set {

    public $primaryKey;
    private $localeId;
    private $userId;
    private $name;
    private $setCode;
    private $setType;
    private $tableNum;
    private $setTypeId;
    private $itemCount;
    private $contentType;

    protected $itemInfoController;
    private $items = array();
    private $set_items = array();

    public function __construct($options = array()) {
      $this->primaryKey = $options['set_id'];
      $this->name = $options['name'];
      $this->setCode = $options['set_code'];
      $this->localeId = $options['locale_id'];
      $this->userId = $options['user_id'];
      $this->itemInfoController = $options['item_info_service'];
      $this->setType = $options['set_type'];
      $this->tableNum = $options['table_num'];
      $this->setTypeId = $options['set_type_id'];
      $this->contentType = $options['content_type'];
      $this->itemCount = $options['item_count'];
    }

    public function getItemIds() {
      if((!isset($this->items) || !is_array($this->items) || count($this->items) <= 0) && $this->itemInfoController != null) {
        return $this->itemInfoController->getSetItems($this->primaryKey, false, true);
      }
      $result_arr = array();
      foreach($this->items as $index => $item) {
        $result_arr[$index] = $item->getPrimaryKey();
      }
      return $result_arr;
    }

    public function getItems() {
      $this->initializeItems();
      return $this->items;
    }

    public function getItemsWithSetItemInfo() {
      $this->initializeItems();
      $result_arr = array();
      foreach($this->items as $index => $item) {
        $result_arr[$index]['item'] = $item;
        $result_arr[$index]['set_item'] = $this->set_items[$index];
      }
      return $result_arr;
    }

    private function initializeItems() {
      if((!isset($this->items) || !is_array($this->items) || count($this->items) <= 0) && $this->itemInfoController != null) {
        $result_arr = $this->itemInfoController->getSetItems($this->primaryKey, true);
        foreach($result_arr as $rank => $value) {
          $resultInstance = $this->itemInfoController->getInstanceByTableNum($this->tableNum, $value['item']['object_id'], $this->itemInfoController, $value['item']);
          $this->set_items[$rank] = $value['set_item'];
          $this->addItem($resultInstance, $rank);
        }
      }
    }

    public function addItem($item, $index=null) {
      if($index != null) {
        $this->items[$index] = $item;
      } else {
        $this->items[] = $item;
      }
    }


    public function getTableNum() {
      return $this->tableNum;
    }

    public function getPrimaryKey() {
      return $this->primaryKey;
    }

    public function getLocaleId() {
      return $this->localeId;
    }

    public function getUserId() {
      return $this->userId;
    }

    public function getName() {
      return $this->name;
    }

    public function getSetCode() {
      return $this->setCode;
    }

    public function getItemCount() {
      return $this->itemCount;
    }

    public function setPrimaryKey($primaryKey) {
      $this->primaryKey = $primaryKey;
    }

    public function setLocaleId($localeId) {
      $this->localeId = $localeId;
    }

    public function setUserId($userId) {
      $this->userId = $userId;
    }

    public function setName($name) {
      $this->name = $name;
    }

    public function setSetCode($setCode) {
      $this->setCode = $setCode;
    }

  }

?>
