<?php
  class SearchServiceController extends BaseServiceController {

    protected $serviceLocation = "/search/Search";

    public function __construct($config=null) {
      parent::__construct($config);
    }

    public function getRecentlyAddedItems($itemLimit, $checkAccess=array(), $hasRepresentations) {
      $params = array(
        'item_limit' => $itemLimit,
        'check_access' => $checkAccess,
        'has_representations' => $hasRepresentations
      );
      $object_ids = $this->call('getRecentlyAddedItems', $params, true, true);
      $itemInfoController = new ItemInfoServiceController($this->getServiceConfiguration());
      $result_arr = array();
      foreach($object_ids as $key => $values_arr) {
        $resultInstance = new Object($key, $itemInfoController, $values_arr);
        $result_arr[$key] = $resultInstance;
      }
      return $result_arr;
    }

    public function getRandomItems($itemLimit, $checkAccess=array(), $hasRepresentations) {
      $params = array(
        'item_limit' => $itemLimit,
        'check_access' => $checkAccess,
        'has_representations' => $hasRepresentations
      );
      $object_ids = $this->call('getRandomItems', $params, true, true);

      $itemInfoController = new ItemInfoServiceController($this->getServiceConfiguration());
      $result_arr = array();
      foreach($object_ids as $key => $values_arr) {
        $resultInstance = new Object($key, $itemInfoController, $values_arr);
        $result_arr[$key] = $resultInstance;
      }
      return $result_arr;
    }

    public function getMostViewedItems($itemLimit, $checkAccess=array(), $hasRepresentations) {
      $params = array(
        'item_limit' => $itemLimit,
        'check_access' => $checkAccess,
        'has_representations' => $hasRepresentations
      );
      $object_ids = $this->call('getMostViewedItems', $params, true, true);

      $itemInfoController = new ItemInfoServiceController($this->getServiceConfiguration());
      $result_arr = array();
      foreach($object_ids as $key => $values_arr) {
        $resultInstance = new Object($key, $itemInfoController, $values_arr);
        $result_arr[$key] = $resultInstance;
      }
      return $result_arr;
    }

    public function getHighestRated($itemLimit=1, $moderationStatus=true, $checkAccess=array(), $hasRepresentations=true) {
      $params = array(
        'pb_moderation_status' => $moderationStatus,
        'pn_num_to_return' => $itemLimit,
        'check_access' => $checkAccess,
        'has_representations' => $hasRepresentations
      );
      $object_ids = $this->call('getHighestRated', $params, true, true);

      $itemInfoController = new ItemInfoServiceController($this->getServiceConfiguration());
      $result_arr = array();
      foreach($object_ids as $key => $values_arr) {
        $resultInstance = new Object($key, $itemInfoController, $values_arr);
        $result_arr[$key] = $resultInstance;
      }

      return $result_arr;
    }

    public function search($type, $query, $sort, $appendToSearch, $sort_direction = 'asc'){
      $params = array(
        'type' => $type,
        'query' => $query,
        'sort' => $sort,
        'appendToSearch' => $appendToSearch,
      	'sort_direction' => $sort_direction,
      );
      $object_ids = $this->call('search', $params, true, true);
      return $object_ids;
    }

  }
?>
