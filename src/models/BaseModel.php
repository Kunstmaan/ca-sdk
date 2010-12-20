<?php
  class BaseModel implements Node{

    protected $primaryKey = 0;
    protected $parentId;

    /**
     * key = element_code
     * value = element_id
     */
    protected $attributeCodeMapping = array();

    /**
     * key = element_id
     * value = array containing metadata for this element
     */
    protected $attributeMetadata = array();

    protected $attributeExtendValues = array();

    /**
     * key = element_id
     * value = the value
     */
    protected $attributeValues = array();

    protected $relationsArray = array();

    protected $preferredLabel = array();
    protected $labelsArray = array();

    protected $totalVotes = 0;
    protected $averageRating = 0;

    protected $commentsArray = array();
    protected $tagsArray = array();

    protected $itemInfoController;

    protected $valuesArray;

    protected $ancestor;
    protected $children = array();

    public function __construct($primaryKey = 0, $itemInfoController = null, $valuesArray = array()) {
      $this->itemInfoController = $itemInfoController;
      $this->primaryKey = $primaryKey;
      $this->setValuesArray($valuesArray);
    }

    public function initializeBaseFields($valuesArray) {
      if($this->primaryKey == null && isset($valuesArray[$this->primary_key_name])) {
        $this->primaryKey = $valuesArray[$this->primary_key_name];
      }
      if(is_array($valuesArray)) {
        foreach($valuesArray as $key => $value) {
          if(!preg_match('/^'.preg_quote("_ca_attribute_")."/", $key)) {
            $func = create_function('$c', 'return strtoupper($c[1]);');
            $convertedKey = preg_replace_callback('/_([a-z])/', $func, $key);
            $this->$convertedKey = $value;
          }
        }
      }
    }

    public function getTable(){
      return $this->table;
    }

    public function getPrimaryKey(){
      return $this->primaryKey;
    }

    public function setPrimaryKey($key){
      return $this->primaryKey;
    }

    public function addRelation($relation) {
      if(!($relation instanceof Relationship)) {
        throw new Exception("Not a valid relation.");
      }
      $this->relationsArray[$relation->relatedObjectType][] = $relation;
      return $this;
    }

    public function getRelations() {
      return $this->relationsArray;
    }

    public function addLabel($label) {
      if(!($label instanceof Label)) {
        throw new Exception("Not a valid label.");
      }
      $this->labelsArray[$label->getLocale()][$label->getPrimaryKey()] = $label;
      if($label->isPreferred()) {
        $this->preferredLabel[$label->getLocale()] = $label;
      }
      return $this;
    }

    public function getLabels($locale = null) {
      return $this->labelsArray[$locale];
    }

    public function getPreferredLabel($locale) {
      if(isset($this->preferredLabel[$locale])) {
        return $this->preferredLabel[$locale];
      }
      if(sizeof($this->preferredLabel) > 0) {
        return $this->preferredLabel[0];
      }
      return null;
    }

    public function getElementId($elementCode) {
      if(!isset($this->attributeCodeMapping[$elementCode])) {
        return null;
      }
      return $this->attributeCodeMapping[$elementCode];
    }

    public function getAttributeExtendedTextValues($elementId) {
      $attribute_values = $this->getAttributeExtendedValue($elementcode);
      if(!is_numeric($elementId)) {
        $elementId = $this->getElementId($elementId);
      }
      if(!isset($this->attributeExtendValues[$elementId])) {
        return null;
      }
      $result = array();
      $opa_values = $this->attributeExtendValues[$elementId];
      if(is_array($opa_values)) {
        foreach($opa_values as $value) {
          $tmp = $value['ops_text_value'];
          if(!empty($tmp)) {
            $result[] = $tmp;
          }
        }
      }
      return $result;
    }

    public function addAttributeExtendedValue($elementId, $value) {
      $this->attributeExtendValues[$elementId][] = $value;
      return $this;
    }

    public function getAttributeExtendedValue($elementId) {
      if(!is_numeric($elementId)) {
        $elementId = $this->getElementId($elementId);
      }
      if(!isset($this->attributeExtendValues[$elementId])) {
        return null;
      }
      return $this->attributeExtendValues[$elementId];
    }

    public function getAttributeValue($elementCode) {
      $elementId = $elementCode;
      if(!is_numeric($elementId)) {
        $elementId = $this->getElementId($elementId);
      }
      return $this->attributeValues[$elementId];
    }

    public function setAttributeValue($elementCode, $elementValue) {
      $this->attributeValues[$elementCode] = $elementValue;
      return $this;
    }

    public function addAttributeMetadata($elementId, $attributeMetadata) {
      $this->attributeMetadata[$elementId] = $attributeMetadata;
      $this->attributeCodeMapping[$attributeMetadata['element_code']] = $elementId;
      return $this;
    }

    public function attributeMetadataExists($elementId) {
      return array_key_exists($elementId, $this->attributeMetadata);
    }

    public function getAttributeMetadata($elementId) {
      return $this->attributeMetadata[$elementId];
    }

    public function __get($name) {
      if(isset($this->attributeCodeMapping[$name])) {
        return $this->getAttributeValue($name);
      }
      return $this->$name;
    }

    public function getParentId() {
      return $this->parentId;
    }

    public function setAncestor($ancestor, $addChild = true) {
      if(!($ancestor instanceof Node) || $ancestor->getTable() != $this->getTable()) {
        throw new Exception('Cannot configure the hierarchy for this type of ancestor.');
      }
      $this->ancestor = $ancestor;
      if($addChild) {
        $ancestor->addChild($this, false);
      }
      return $this;
    }

    protected function hasChild($child) {
      foreach($this->getChildren() as $c) {
        if($c->getPrimaryKey() == $child->getPrimaryKey()){
          return true;
        }
      }
      return false;
    }

    public function addChild($child, $addAncestor = true) {
      if(!($child instanceof Node) || $child->getTable() != $this->getTable()) {
        throw new Exception('Cannot configure the hierarchy for this type of child.');
      }
      if(!$this->hasChild($child)) {
         $this->children[] = $child;
      }
      if($addAncestor) {
        $child->addAncestor($this, false);
      }
      return $this;
    }

    public function getAncestor(){
      return $this->ancestor;
    }

    public function getChildren() {
      return $this->children;
    }

    public function __set($name, $value) {
      if(isset($this->attributeCodeMapping[$name])) {
         $this->attributeValues[$this->attributeCodeMapping[$name]] = $value;
      } else {
        $this->$name = $value;
      }
      return $this;
    }

    public function getRelatedListItems(){
      if(isset($this->relationsArray['ca_list_items'])){
        return $this->relationsArray['ca_list_items'];
      }
    }

    public function getRelatedEntities(){
      if(isset($this->relationsArray['ca_entities'])){
        return $this->relationsArray['ca_entities'];
      }
    }

    public function getRelatedObjects(){
      if(isset($this->relationsArray['ca_objects'])){
        return $this->relationsArray['ca_objects'];
      }
    }

    public function getRelatedPlaces(){
      if(isset($this->relationsArray['ca_places'])){
        return $this->relationsArray['ca_places'];
      }
    }

    public function getRelatedCollections(){
      if(isset($this->relationsArray['ca_collections'])){
        return $this->relationsArray['ca_collections'];
      }
    }

    public function getRelatedOcurrences(){
      if(isset($this->relationsArray['ca_occurences'])){
        return $this->relationsArray['ca_occurences'];
      }
    }

    public function setTotalNumberOfVotes($nb) {
      $this->totalVotes = $nb;
      return $this;
    }

    public function getTotalNumberOfVotes() {
      return $this->totalVotes;
    }

    public function setAverageRating($avg) {
      $this->averageRating = $avg;
      return $this;
    }

    public function getAverageRating() {
      return $this->averageRating;
    }

    public function addComment($comment) {
      if(!($comment instanceof Comment)) {
        throw new Exception("Not a valid comment.");
      }
      $this->commentsArray[] = $comment;
      return $this;
    }

    public function getComments() {
      return $this->commentsArray;
    }

    public function addTag($tag) {
      if(!($tag instanceof Tag)) {
        throw new Exception("Not a valid tag.");
      }
      $this->tagsArray[] = $tag;
      return $this;
    }

    public function getTags() {
      return $this->tagsArray;
    }

    public function getValueArray() {
      return $this->valuesArray;
    }

    protected function setValuesArray($valuesArray) {
      $this->valuesArray = $valuesArray;
//      if(!isset($valuesArray["attribute_metadata"])) {
//       throw new Exception("Unable to initialize item without metadata");
//      }

      $this->initializeBaseFields($valuesArray);

      $cachedAttributeMetadata = array();

      foreach($valuesArray as $key => $value) {
        if(preg_match('/^'.preg_quote("_ca_attribute_")."/", $key)) {
          $va_tmp = explode('attribute_', $key);
          $elementId = $va_tmp[1];
          $this->addAttributeMetadata($elementId, $valuesArray["attribute_metadata"][$elementId]);
          $this->setAttributeValue($elementId, $value);
        }
      }

      //read attribute extended values
      if(isset($valuesArray["extended_values"]) && is_array($valuesArray["extended_values"])) {
        $attritbutes = $valuesArray["extended_values"];

        foreach($attritbutes as $key => $attributevalues) {
          foreach($attributevalues as $attribute) {
            $this->addAttributeExtendedValue($key, array_pop($attribute['opa_values']));
          }
        }
      }

      if(isset($valuesArray["relationships"]) && is_array($valuesArray["relationships"])) {
        //read relations data and wrap it into Relationship.php array()
        $relations = $valuesArray["relationships"];
        foreach($relations as $key => $value) {
          $relationship = new Relationship(array(
            'relation_id' => $value["relation_id"],
            'related_object_type' => $value["related_object_type"],
            'item_info_service' => $this->itemInfoController
          ));

          if(isset($value["displayname"])) {
            $displayname = $value["displayname"];
          } elseif(isset($value['name_singular'])) {
            $displayname = $value['name_singular'];
          } elseif(isset($value["name"])) {
            $displayname = $value["name"];
          } else {
            $displayname = '';
          }
          $relationship->setDisplayName($displayname);
          $relationship->setRelationshipTypeId($value["relationship_type_id"]);
          $relationship->setRelationshipTypeName($value["relationship_type_name"]);
          $relationship->setRelatedObjectId($value);
          $this->addRelation($relationship);
        }
      }

      if(isset($valuesArray["labels"]) && is_array($valuesArray["labels"])) {
        $labels = $valuesArray["labels"];
        foreach($labels as $lang) {
          foreach($lang as $id => $value) {
            $label_id = $id;
            if(isset($value['label_id'])) {
              $label_id = $value['label_id'];
            }
            if(isset($value['name'])) {
              $name = $value['name'];
            } elseif(isset($value['name_plural'])) {
              $name = $value['name_plural'];
            }
            $label = new Label(array(
              'label_id' => $label_id,
              'locale' => $value['locale_language'],
              'is_preferred' => $value['is_preferred'],
              'value' => $name
            ));
            $this->addLabel($label);
          }
        }
      }

      if(isset($valuesArray["tags"]) && is_array($valuesArray["tags"])) {
        foreach($valuesArray["tags"] as $tag_array) {
          if(!isset($tag_array["moderated_by_user_id"]) || $tag_array["moderated_by_user_id"] == null || $tag_array["moderated_by_user_id"] = ''){
            // comment has not been moderated yet
          } else {
           $newtag = new Tag(array(
             'tag_id' => $tag_array["tag_id"],
             'locale_id' => $tag_array["locale_id"],
             'values' => $tag_array
           ));
           $this->addTag($newtag);
          }
        }
      }

      if(isset($valuesArray["rating"]) && is_array($valuesArray["rating"])) {
        $this->setTotalNumberOfVotes($valuesArray["rating"]["total"]);
        $this->setAverageRating($valuesArray["rating"]["average"]);
      }

      if(isset($valuesArray["comments"]) && is_array($valuesArray["comments"])) {
        foreach($valuesArray["comments"] as $comment_arr) {
          if(!isset($comment_arr["moderated_by_user_id"]) || $comment_arr["moderated_by_user_id"] == null || $comment_arr["moderated_by_user_id"] = ''){
            // comment has not been moderated yet
          } else {
            $newcomment = new Comment(array(
              'comment_id' => $comment_arr["comment_id"],
              'locale_id' => $comment_arr["locale_id"],
              'values' => $comment_arr
            ));
            $this->addComment($newcomment);
          }
        }
      }

    if(isset($valuesArray["hierarchy"]) && is_array($valuesArray["hierarchy"])) {
        $ancestors = array();
        $ancestorArr = $valuesArray['hierarchy']['ancestors'];
        foreach($ancestorArr as $k => $a) {
          $options = array(
            'idno' => $a['idno'],
            'parent_id' => $a['parent_id'],
            'item_info_controller' => $this->itemInfoController,
            'table' => $this->getTable()
          );
          $ancestor = new BasicNode($a['id'], $options);

          $labelArr = $a['label'];
          while(count($labelArr) == 1) {
            $labelArr = array_pop($labelArr);
          }
          $label_id = 0;
          if(isset($labelArr['label_id'])) {
            $label_id = $labelArr['label_id'];
          }
          if(isset($labelArr['name'])) {
            $name = $labelArr['name'];
          } elseif(isset($labelArr['name_plural'])) {
            $name = $labelArr['name_plural'];
          }
          $label = new Label(array(
            'label_id' => $label_id,
            'locale' => $labelArr['locale_language'],
            'is_preferred' => $labelArr['is_preferred'],
            'value' => $name
          ));
          $ancestor->addLabel($label);

          $ancestors[$a['id']] = $ancestor;
        }
        foreach($ancestors as $item) {
          $parentId = $item->getParentId();
          if(isset($parentId) && $parentId != null) {
            $item->setAncestor($ancestors[$parentId]);
          }
        }
        $parentId = $this->getParentId();
        if(isset($parentId) && $parentId != null) {
          $this->setAncestor($ancestors[$parentId]);
        }

        $childArr = $valuesArr['hierarchy']['children'];
        foreach($childArr as $k => $c) {
          $options = array(
            'idno' => $c['idno'],
            'parent_id' => $c['parent_id'],
            'item_info_controller' => $this->itemInfoController,
            'table' => $this->getTable()
          );
          $child = new BasicNode($c['id'], $options);

          $labelArr = $c['label'];
          while(count($labelArr) == 1) {
            $labelArr = array_pop($labelArr);
          }
          $label_id = 0;
          if(isset($labelArr['label_id'])) {
            $label_id = $labelArr['label_id'];
          }
          if(isset($labelArr['name'])) {
            $name = $labelArr['name'];
          } elseif(isset($labelArr['name_plural'])) {
            $name = $labelArr['name_plural'];
          }
          $label = new Label(array(
            'label_id' => $label_id,
            'locale' => $labelArr['locale_language'],
            'is_preferred' => $labelArr['is_preferred'],
            'value' => $name
          ));
          $child->addLabel($label);

          $this->addChild($child);
        }
      }

    }

  }
?>
