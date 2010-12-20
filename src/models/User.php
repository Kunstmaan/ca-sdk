<?php
  class User {


    public $userId;
    private $userName;
    private $firstName;
    private $lastName;
    private $email;
    private $active;
    private $password;
    private $userClass;

    public function __construct($options = array()) {
      $this->userId = $options['user_id'];
      if(is_array($options['values'])) {
        $values = $options['values'];
        $this->setUserName($values['user_name']);
        $this->setFirstName($values['fname']);
        $this->setLastName($values['lname']);
        $this->setEmail($values['email']);
        $this->setActive($values['active']);
        $this->setPassword($values['password']);
        $this->setUserClass($values['userclass']);
      }
    }


    public function getUserId() {
      return $this->userId;
    }

  	public function getUserName() {
      return $this->userName;
    }

  	public function getFirstName() {
      return $this->firstName;
    }

  	public function getLastName() {
      return $this->lastName;
    }

  	public function getEmail() {
      return $this->email;
    }

  	public function isActive() {
      return $this->active;
    }

  	public function getPassword() {
      return $this->password;
    }

  	public function getUserClass() {
      return $this->userClass;
    }

    public function setUserName($name) {
      $this->userName = $name;
      return $this;
    }

  	public function setFirstName($name) {
      $this->firstName= $name;
      return $this;
    }

  	public function setLastName($name) {
      $this->lastName = $name;
      return $this;
    }

  	public function setEmail($mail) {
      $this->email = $mail;
      return $this;
    }

  	public function setActive($active) {
      $this->active = $active;
      return $this;
    }

  	public function setPassword($p) {
      $this->password = $p;
      return $this;
    }

  	public function setUserClass($user_class) {
      $this->userClass = $user_class;
      return $this;
    }

  }

?>
