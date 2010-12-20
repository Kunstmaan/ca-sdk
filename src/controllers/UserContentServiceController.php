<?php
  class UserContentServiceController extends BaseServiceController {

    protected $serviceLocation = "/usercontent/UserContent";

    public function __construct($config=null) {
      parent::__construct($config);
    }

    public function createUser($username,$email,$fname,$lname,$password) {
      $params = array(
        'username' => $username,
        'email' => $email,
        'fname' => $fname,
        'lname' => $lname,
        'pwd' => $password,
      );
      $result_arr = $this->call('createUser', $params);

      if(isset($result_arr['user_id'])) {
        $user = new User(array(
          'user_id' => $result_arr["user_id"],
          'values' => $result_arr
        ));
        return $user;
      }
      return null;
    }

    public function getUser($username_or_id) {
      $client = $this->getClient();
      $params = array(
        'username_or_id' => $username_or_id
      );
      $result_arr = $this->call('getUser', $params, true, true);
      if(count($result_arr) < 1){
        return null;
      }else{
        $user = new User(array(
          'user_id' => $result_arr["user_id"],
          'values' => $result_arr
        ));
        return $user;
      }
    }

   public function resetPassword($userid, $password) {
      $client = $this->getClient();
      $params = array(
        'userid' => $userid,
        'password' => $password
      );
      $result_arr = $this->call('resetPassword', $params);

      if(isset($result_arr['user_id'])) {
        $user = new User(array(
          'user_id' => $result_arr["user_id"],
          'values' => $result_arr
        ));
        return $user;
      }
      return null;
    }

    public function getComments($type,$item_id) {
      $params = array(
        'type' => $type,
        'item_id' => $item_id
      );
      $result_arr = $this->call('getComments', $params, true, true);
      return $result_arr;
    }

    public function addComment($type, $item_id, $comment,$email,$name, $locale_id, $access,$rating,$user_id=null) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $item_id,
        'comment' => $comment,
        'email' => $email,
        'name' => $name,
        'locale_id' => $locale_id,
        'access' => $access,
        'user_id' => $user_id
      );
      $result_arr = $this->call('addComment', $params);
      return $result_arr;
    }

    public function getTags($type,$item_id) {
      $params = array(
        'type' => $type,
        'item_id' => $item_id
      );
      $result_arr = $this->call('getTags', $params, true, true);
      return $result_arr;
    }

    public function getAverageRating($type, $item_id, $moderation_status=true) {
      $params = array(
        'type' => $type,
        'item_id' => $item_id,
        'moderation_status' => $moderation_status
      );
      $result_arr = $this->call('getAverageRating', $params);
      return $result_arr;
    }

   public function getTotalRatings($type, $item_id, $moderation_status=true) {
      $params = array(
        'type' => $type,
        'item_id' => $item_id,
        'moderation_status' => $moderation_status
      );
      $result_arr = $this->call('getTotalRatings', $params);
      return $result_arr;
    }

    public function rateObject($type, $item_id, $rating, $moderation_status=true,$user_id=null) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $item_id,
        'rating' => $rating,
        'access' => $moderation_status,
        'user_id' => $user_id
      );
      $result = $this->call('rateObject', $params);
      return $result;
    }

   public function addItemToSet($set_id,$type,$item_id,$type_id=2,$set_item_info_array=array()) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'set_id' => $set_id,
        'type' => $type,
        'item_id' => $item_id,
        'type_id' => $type_id,
        'set_item_info_array' => $set_item_info_array
      );
      $result_arr = $this->call('addItemToSet', $params);
      return $result_arr;
    }

   public function addSet($type, $type_id=3, $user_id=1, $set_code='', $label='', $localeId=null, $access=0, $status=1) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'type_id' => $type_id,
        'user_id' => $user_id,
        'set_code' => $set_code,
        'label' => $label,
        'locale_id' => $localeId,
        'access' => $access,
        'status' => $status
      );
      $result_arr = $this->call('addSet', $params);
      return $result_arr;
    }

   public function addTag($type, $item_id, $tag, $locale=null, $access=null, $moderator=null,$user_id=null) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $item_id,
        'tag' => $tag,
        'locale_id' => $locale,
        'access' => $access,
        'moderator' => $moderator,
        'user_id' => $user_id
      );
      $result_arr = $this->call('addTag', $params);
      return $result_arr;
    }

   public function removeItemFromSet($set_id,$set_item_id) {
      $params = array(
          'set_id' => $set_id,
          'set_item_id' => $set_item_id
        );
      $result_arr = $this->call('removeItemFromSet', $params);
      return $result_arr;
    }

   public function removeSet($set_id) {
      $params = array(
        'set_id' => $set_id
      );
      $result_arr = $this->call('removeSet', $params);
      return $result_arr;
    }

    public function updateSet($set_id, $set_code=null, $label=null, $localeId=null, $access=null, $status=null) {
      $params = array(
        'set_id' => (int) $set_id,
        'set_code' => $set_code,
        'label' => $label,
        'locale_id' => $localeId,
        'access' => $access,
        'status' => $status
      );
      $result_arr = $this->call('updateSet', $params);
      return $result_arr;
    }

    public function updateSetItem($set_item_id,$set_item_info_array) {
      $params = array(
        'set_item_id' => $set_item_id,
        'set_item_info_array'=>$set_item_info_array
      );
      $result_arr = $this->call('updateSetItem', $params);
      return $result_arr;
    }

  }
?>
