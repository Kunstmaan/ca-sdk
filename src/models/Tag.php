<?php
  class Tag {

    public $primaryKey;
    private $userId;
    private $localeId;
    private $text;
    private $createdOn;
    private $access;
    private $ipAddress;
    private $moderatedOn;
    private $modertatedByUserId;

    public function __construct($options = array()) {
      $this->primaryKey = $options['tag_id'];
      $this->localeId = $options['locale_id'];

      if(is_array($options['values'])) {
        $values = $options['values'];
        $this->setUserId($values['user_id']);
        $this->setText($values['tag']);
        $this->setCreatedOn($values['created_on']);
        $this->setAccess($values['access']);
        $this->setIpAddress($values['ip_addr']);
        $this->setModeratedOn($values['moderated_on']);
        $this->setModertatedByUserId($values['moderated_by_user_id']);
      }
    }

    public function getPrimaryKey() {
      return $this->primaryKey;
    }

    public function getUserId() {
      return $this->userId;
    }

    public function getLocaleId() {
      return $this->localeId;
    }

    public function getText() {
      return $this->text;
    }

    public function getCreatedOn() {
      return $this->createdOn;
    }

    public function getAccess() {
      return $this->access;
    }

    public function getIpAddress() {
      return $this->ipAddress;
    }

    public function getModeratedOn() {
      return $this->moderatedOn;
    }

    public function getModertatedByUserId() {
      return $this->modertatedByUserId;
    }

    public function setUserId($userId) {
      $this->userId = $userId;
      return $this;
    }

    public function setLocaleId($localeId) {
      $this->localeId = $localeId;
      return $this;
    }

    public function setText($text) {
      $this->text = $text;
      return $this;
    }

    public function setCreatedOn($createdOn) {
      $this->createdOn = $createdOn;
      return $this;
    }

    public function setAccess($access) {
      $this->access = $access;
      return $this;
    }

    public function setIpAddress($ipAddress) {
      $this->ipAddress = $ipAddress;
      return $this;
    }

    public function setModeratedOn($moderatedOn) {
      $this->moderatedOn = $moderatedOn;
      return $this;
    }

    public function setModertatedByUserId($modertatedByUserId) {
      $this->modertatedByUserId = $modertatedByUserId;
      return $this;
    }

  }

?>
