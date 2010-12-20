<?php
  class CataloguingServiceController extends BaseServiceController {

    protected $serviceLocation = "/cataloguing/Cataloguing";

    public function __construct($config=null) {
      parent::__construct($config);
    }

   public function add($type, $fieldInfo) {
     $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'fieldInfo' => $fieldInfo
      );
      $result_arr = $this->call('add', $params);
      return $result_arr;
    }

   public function editLabel($type, $itemId,$labelId,$labelDataArray,$localeId,$isPreferred) {
     $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId,
        'label_id' => $labelId,
        'label_data_array' => $labelDataArray,
        'localeID' => $localeId,
        'is_preferred' => $isPreferred
      );
      $result_arr = $this->call('editLabel', $params);
      return $result_arr;
    }

  public function editAttribute($type, $itemId,$attributeId,$attributeCodeOrId,$attributeDataArray) {
     $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId,
        'attribute_id' => $attributeId,
        'attribute_code_or_id' => $attributeCodeOrId,
        'attribute_data_array' => $attributeDataArray
      );
      $result_arr = $this->call('editAttribute', $params);
      return $result_arr;
    }

    public function addRelationship($type, $itemId,$relatedType,$relatedItemId,$relationshipTypeId,$sourceInfo) {
     $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }

      $params = array(
        'type' => $type,
        'item_id' => $itemId,
        'related_type' => $relatedType,
        'related_item_id' => $relatedItemId,
        'relationship_type_id' => $relationshipTypeId,
        'source_info' => $sourceInfo
      );
      $result_arr = $this->call('addRelationship', $params);
      return $result_arr;
    }

    public function addObjectRepresentation($objectId,$mediaURL,$typeId,$localeId,$status,$access,$isPrimary) {
      $params = array(
        'object_id' => $objectId,
        'media_url' => $mediaURL,
        'type_id' => $typeId,
        'locale_id' => $localeId,
        'status' => $status,
        'access' => $access,
        'is_primary' => $isPrimary
      );
      $result_arr = $this->call('addObjectRepresentation', $params);
      return $result_arr;
    }

    public function addLabel($type,$itemId,$labelDataArray,$localeId,$isPreferred) {
     $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId,
        'label_data_array' => $labelDataArray,
        'locale_id' => $localeId,
        'is_preferred' => $isPreferred
      );
      $result_arr = $this->call('addLabel', $params);
      return $result_arr;
    }

    public function addAttributes($type,$itemId,$attributeListArray) {
     $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId,
        'attribute_list_array' => $attributeListArray
      );
      $result_arr = $this->call('addAttributes', $params);
      return $result_arr;
    }

  public function addAttribute($type,$itemId,$attributeCodeOrId,$attributeDataArray) {
     $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId,
        'attribute_code_or_id' => $attributeCodeOrId,
        'attribute_data_array' => $attributeDataArray
      );
      $result_arr = $this->call('addAttribute', $params);
      return $result_arr;
    }

    public function remove($type, $itemId) {
     $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId
      );
      $result_arr = $this->call('remove', $params);
      return $result_arr;
    }

    public function removeAllAttributes($type, $itemId) {
     $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId
      );
      $result_arr = $this->call('removeAllAttributes', $params);
      return $result_arr;
    }

  	public function removeAllLabels($type, $itemId) {
     $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId
      );
      $result_arr = $this->call('removeAllLabels', $params);
      return $result_arr;
    }

    public function removeAttribute($type, $itemId,$attributeId) {
     $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId,
        'attribute_id' => $attributeId
      );
      $result_arr = $this->call('removeAttribute', $params);
      return $result_arr;
    }

  	public function removeLabel($type, $itemId,$labelId) {
     $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_d' => $itemId,
        'label_id' => $labelId
      );
      $result_arr = $this->call('removeLabel', $params);
      return $result_arr;
    }

    public function removeObjectRepresentation($representationId) {
      $params = array(
        'representation_id' => $representationId
      );
      $result_arr = $this->call('removeObjectRepresentation', $params);
      return $result_arr;
    }

    public function removeRelationship($type,$relatedType,$relationId) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'related_type' => $relatedType,
        'relation_id' => $relationId
      );
      $result_arr = $this->call('removeRelationship', $params);
      return $result_arr;
    }

    public function replaceAttribute($type,$itemId,$attributeCodeOrId,$attributeDataArray) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId,
        'attribute_code_or_id' => $attributeCodeOrId,
        'attribute_data_array' => $attributeDataArray
      );
      $result_arr = $this->call('replaceAttribute', $params);
      return $result_arr;
    }

    public function update($type,$itemId,$fieldInfo) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId,
        'fieldInfo' => $fieldInfo
      );
      $result_arr = $this->call('update', $params);
      return $result_arr;
    }

    public function updateAttributes($type,$itemId,$attributeListArray) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId,
        'attribute_list_array' => $attributeListArray
      );
      $result_arr = $this->call('updateAttributes', $params);
      return $result_arr;
    }

    public function updateRelationship($type,$relatedType,$relationId,$relationshipTypeId,$sourceInfo) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'related_type' => $relatedType,
        'relation_id' => $relationId,
        'relationship_type_id' => $relationshipTypeId,
        'source_info' => $sourceInfo,
      );
      $result_arr = $this->call('updateRelationship', $params);
      return $result_arr;
    }

  }
?>