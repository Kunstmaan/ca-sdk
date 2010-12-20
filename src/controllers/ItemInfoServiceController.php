<?php

  /**
   * getItem: returns all the fields and there values
   * getAttributes: returns all the attributes:
   *   attribute_id (the id of the attribute)
   *     attribute_index (the index of the attribute, this is for repeatable fields)
   *       elemnt_id
   *       value_id
   *       display_value
   * getAttributesByElement: the same as getAttributes but for a specific attribute_id
   * getAttributesForDisplay: returns only the value of the selected attribute
   * getLabels: returns the labels in all languages and mode (preferred, nonpreferred, all)
   * getLabelForDisplay: returns the label to show
   * getObjectRepresentations: returns all the representations of the selected object
   * getPrimaryObjectRepresentation: returns only the one annotated with getPrimary
   * getRelationships: returns the relations bewteen two items
   *
   */
  class ItemInfoServiceController extends BaseServiceController {

    protected $serviceLocation = "/iteminfo/ItemInfo";

    public function __construct($config=null) {
      parent::__construct($config);
    }

    /**
     * with the element_id we can obtain following things:
     * ca_metadata_element_labels: contains label and description in a certain language
     * ca_metadata_elements: contains element_code and settings
     */
    public function getItem($type, $itemId) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId
      );
      $result_arr = $this->call('getItem', $params, true, true);
      $resultInstance = $this->getInstanceByTable($type, $itemId, $this, $result_arr);
      return $resultInstance;
    }

    public function getItems($type, $itemIds) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      if(!is_array($itemIds)) {
        $item = $this->getItem($type, $itemIds);
        return array($itemIds => $item);
      }
      $params = array(
        'type' => $type,
        'item_ids' => $itemIds
      );

      $result_arr = $this->call('getItems', $params, true, true);

      $result = array();
      foreach($result_arr as $itemId => $item_raw) {
        $result[$itemId] = $this->getInstanceByTable($type, $itemId, $this, $item_raw);
      }

      return $result;
    }

    /**
     * array('tiny', 'mediumlarge', 'original')
     */
    public function getPrimaryObjectRepresentation($objectId, $versions=null) {

      $params = array(
        'object_id' => $objectId,
        'versions' => $versions
      );
      $result_arr = $this->call('getPrimaryObjectRepresentation', $params, true, true);
      return $result_arr;
    }

    public function getObjectRepresentations($objectId, $versions=null) {

      $params = array(
        'object_id' => $objectId,
        'versions' => $versions
      );
      $result_arr = $this->call('getObjectRepresentations', $params, true, true);
      return $result_arr;
    }

    public function getLabelForDisplay($type, $itemId) {
      $params = array(
        'type' => $type,
        'item_id' => $itemId
      );
      $result = $this->call('getLabelForDisplay', $params);
      return $result;
    }

    /*
     * $mode = preferred, nonpreferred or all
     */
    public function getLabels($type, $itemId, $mode='all') {
      $params = array(
        'type' => $type,
        'item_id' => $itemId,
        'mode' => $mode
      );
      $result_arr = $this->call('getLabels', $params);
      return $result_arr;
    }

    /**
     * Returns text of attributes in the user's currently selected locale, or else falls back to whatever locale is available
     *
     * @param string $type can be one of: [ca_objects, ca_entities, ca_places, ca_occurrences, ca_collections, ca_list_items]
     * @param int $item_id primary key
     * @param string $attribute_code_or_id
     * @param string $template
     * @param array $options Supported options:
     *  delimiter = text to use between attribute values; default is a single space
     *  convertLinkBreaks = if true will convert line breaks to HTML <br/> tags for display in a web browser; default is false
     * @return string
     */
    public function getAttributesForDisplay($type, $itemId, $attributeCodeOrId, $template=null, $options=null) {
      $params = array(
        'type' => $type,
        'item_id' => $itemId,
        'attribute_code_or_id' => $attributeCodeOrId,
        'template' => $template,
        'options' => $options
      );
      $result_arr = $this->call('getAttributesForDisplay', $params);
      return $result_arr;
    }

    public function getMetadataForElement($elementId) {
      $params = array(
        'element_id' => $elementId
      );
      $result_arr = $this->call('getMetadataForElement', $params);
      return $result_arr;
    }

    public function getAttributes($type, $item_id) {

      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId
      );
      $result_arr = $this->call('getAttributes', $params);
      return $result_arr;
    }

   public function getAttributesByElement($type, $item_id,$attributeCodeOrId) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId,
        'attribute_code_or_id'=>$attributeCodeOrId
      );
      $result_arr = $this->call('getAttributesByElement', $params);
      return $result_arr;
    }

    public function getRelationships($type, $item_id,$related_type) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'item_id' => $itemId,
        'related_type'=>$related_type
      );
      $result_arr = $this->call('getRelationships', $params);
      return $result_arr;
    }

    public function getRelationshipTypes($type, $sub_type_id,$related_type,$related_sub_type_id) {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'sub_type_id' => $sub_type_id,
        'related_type'=>$related_type,
        'related_sub_type_id'=>$related_sub_type_id
      );
      $result_arr = $this->call('getRelationshipTypes', $params);
      return $result_arr;
    }

    public function getSets($user_id=null, $access=null, $status=null) {
      $params = array(
        'user_id' => $user_id,
        'access' => $access,
        'status' => $status
      );

      $this->setType = $options['set_type'];
      $this->tableNum = $options['table_num'];
      $this->typeId = $options['type_id'];
      $this->contentType = $options['content_type'];
      $this->itemCount = $options['item_count'];


      $results_arr = $this->call('getSets', $params);
      $results = array();
      foreach($results_arr as $result_arr) {
        $result_arr = array_pop($result_arr);
        $newSet = new Set(array(
          'set_id' => $result_arr["set_id"],
          'name' => $result_arr["name"],
          'set_code' => $result_arr["set_code"],
          'locale_id' => $result_arr["locale_id"],
          'user_id' => $result_arr["user_id"],
          'set_type' => $result_arr["set_type"],
          'table_num' => $result_arr["table_num"],
          'set_type_id' => $result_arr["type_id"],
          'content_type' => $result_arr["set_content_type"],
          'item_count' => $result_arr["item_count"],
          'item_info_service' => $this
        ));
        $results[] = $newSet;
      }
      return $results;
    }

    public function getSet($set_id, $checkAccess=array()) {
      $params = array(
        'set_id' => $set_id,
        'check_access' => $checkAccess
      );
      $result_arr = $this->call('getSet', $params);
      $name = '';
      $labels = $result_arr['display_labels'];
      while(is_array($labels) && count($labels) == 1) {
        $labels = array_pop($labels);
      }
      $name = $labels['name'];
      $newSet = new Set(array(
        'set_id' => $result_arr["set_id"],
        'name' => $name,
        'set_code' => $result_arr["set_code"],
        //'locale_id' => $result_arr["locale_id"],
        'user_id' => $result_arr["user_id"],
        'set_type' => $result_arr["set_type"],
        'table_num' => $result_arr["table_num"],
        'set_type_id' => $result_arr["type_id"],
        'content_type' => $result_arr["set_content_type"],
        'item_count' => $result_arr["item_count"],
        'item_info_service' => $this
      ));
      return $newSet;
    }

  	public function getSetItems($set_id, $full_item_description=false, $ids_only=false, $sort=null, $checkAccess=array()) {
      $params = array(
        'set_id' => $set_id,
        'full_item_desc' => $full_item_description,
        'ids_only' => $ids_only,
        'sort' => $sort,
        'check_access' => $checkAccess
      );
      $result_arr = $this->call('getSetItems', $params);
      return $result_arr;
    }

  	public function getSetsForItem($type,$item_id) {
      $params = array(
        'type' => $type,
        'item_id' => $item_id
      );
      $result_arr = $this->call('getSetsForItem', $params);
      return $result_arr;
    }

  }
?>
