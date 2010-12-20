<?php
  class UtilsServiceController extends BaseServiceController {

    protected $serviceLocation = "/utils/Utils";

    public function __construct($config=null) {
      parent::__construct($config);
    }

    public function getPlacesWithRelationsToObjects($placeType, $checkAccess=array()) {
      $params = array(
        'placeType' => $placeType,
        'checkAccess' => $checkAccess
      );
      $result_arr = $this->call('getPlacesWithRelationsToObjects', $params, true, true);
      return $result_arr;
    }

    public function getCollectionsWithRelationsToObjects($checkAccess=array()) {
      $params = array(
        'checkAccess' => $checkAccess
      );
      $result_arr = $this->call('getCollectionsWithRelationsToObjects', $params, true, true);
      return $result_arr;
    }

    public function getObjectRepresentationsForObjects($objectIds=array(), $primaryOnly=false, $versions=array()) {
      $params = array(
        'objectIds' => $objectIds,
        'primaryOnly' => $primaryOnly,
        'versions' => $versions
      );
      $result_arr = $this->call('getObjectRepresentationsForObjects', $params, true, true);
      $result = array();
      foreach($result_arr as $objectrepresentations) {
        foreach($objectrepresentations as $key => $value) {
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
          $result[] = $representation;
        }
      }
      return $result;
    }

    public function getAllObjects($regenerate = true) {
       $params = array(
        'regenerate' => $regenerate
      );
      $result_arr = $this->call('getAllObjects', $params, true, true);
      $result = unserialize($result_arr);
      return $result;
    }

    public function getQueryBasedOverview($key, $regenerate = true) {
      $params = array(
        'key' => $key,
        'regenerate' => $regenerate
      );
      $result_arr = $this->call('getQueryBasedOverview', $params, true, true);
      $result = unserialize($result_arr);
      return $result;
    }

    public function sortByRating($type, $itemIds, $ascending = true) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'itemIds' => $itemIds,
      	'ascending' => $ascending,
      );
      $result_arr = $this->call('sortByRating', $params, true, true);
      return $result_arr;
    }

  }
?>
