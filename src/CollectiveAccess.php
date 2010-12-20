<?php
  spl_autoload_register(array('AutoloadClass', 'autoload'));

  class CollectiveAccess {

    private $controllerConfig;

    private $controllers = array();

    /**
     * Initialize a Collective Access.
     *
     * The configuration:
     * username: the username for the Collective Access application.
     * password: the password for the Collective Access application.
     * base_url: the base url of the Collective Access application.
     * cache_provider:  (optional) an object which will handle all the caching.
     *           This can be a Zend Cache or a cache with following methods defined:
     *             + load($key)
     *            + save($key, $data)
     * @param Array $config the Collective Access configuration.
     */
    public function __construct($config) {
      // maybe in the future also none controller settings.
      $this->controllerConfig['username'] = $config['username'];
      $this->controllerConfig['password'] = $config['password'];
      $this->controllerConfig['base_url'] = $config['base_url'];
      if(isset($config['cache_provider']) && $config['cache_provider'] != null) {
        $this->controllerConfig['cache_provider'] = $config['cache_provider'];
      }
    }

  // getter/setter functions

    /**
     * Set the Collective Access application username.
     *
     * @param String $username of the Collective Access application.
     */
    public function setUsername($username) {
      $this->controller_config['username'] = $username;
      $this->invalidateControllers();
      return $this;
    }

    public function getControllerConfig() {
      return $this->controllerConfig;
    }

    /**
     * Set the Collective Access application password.
     *
     * @param String $password of the Collective Access application.
     */
    public function setPassword($password) {
      $this->controller_config['password']= $password;
      $this->invalidateControllers();
      return $this;
    }

    /**
     * Set the Collective Access application base url.
     *
     * @param String $base_url of the Collective Access application.
     */
    public function setBaseUrl($baseUrl) {
      $this->controller_config['base_url'] = $baseUrl;
      $this->invalidateControllers();
      return $this;
    }

  // service call functions
    public function doTest() {
      $controller = $this->getController('item_info');
      return $controller->doTest();
    }

    public function auth() {
      $controller = $this->getController('item_info');
      return $controller->auth();
    }

    public function getObject($itemId) {
      $controller = $this->getController('item_info');
      return $controller->getItem('ca_objects', $itemId);
    }

    public function getObjects($itemIds) {
      $controller = $this->getController('item_info');
      return $controller->getItems('ca_objects', $itemIds);
    }

    public function getCollection($itemId) {
      $controller = $this->getController('item_info');
      return $controller->getItem('ca_collections', $itemId);
    }

    public function getCollections($itemIds) {
      $controller = $this->getController('item_info');
      return $controller->getItems('ca_collections', $itemIds);
    }

    public function getEntity($itemId) {
      $controller = $this->getController('item_info');
      return $controller->getItem('ca_entities', $itemId);
    }

    public function getEntities($itemIds) {
      $controller = $this->getController('item_info');
      return $controller->getItems('ca_entities', $itemIds);
    }

    public function getPlace($itemId) {
      $controller = $this->getController('item_info');
      return $controller->getItem('ca_places', $itemId);
    }

    public function getPlaces($itemIds) {
      $controller = $this->getController('item_info');
      return $controller->getItems('ca_places', $itemIds);
    }

    public function getOccurrence($itemId) {
      $controller = $this->getController('item_info');
      return $controller->getItem('ca_occurrences', $itemId);
    }

    public function getOccurrences($itemIds) {
      $controller = $this->getController('item_info');
      return $controller->getItems('ca_occurrences', $itemIds);
    }

    public function getStorageLocation($itemId) {
      $controller = $this->getController('item_info');
      return $controller->getItem('ca_storage_locations', $itemId);
    }

    public function getStorageLocations($itemIds) {
      $controller = $this->getController('item_info');
      return $controller->getItems('ca_storage_locations', $itemIds);
    }

    public function getListItem($itemId) {
      $controller = $this->getController('item_info');
      return $controller->getItem('ca_list_items', $itemId);
    }

    public function getListItems($itemIds) {
      $controller = $this->getController('item_info');
      return $controller->getItems('ca_list_items', $itemIds);
    }

    public function getLabelForDisplay($type, $itemId) {
      $controller = $this->getController('item_info');
      return $controller->getLabelForDisplay($type, $itemId);
    }

    public function getLabels($type, $itemId, $mode='all') {
      $controller = $this->getController('item_info');
      return $controller->getLabels($type, $itemId, $mode);
    }

    public function getAttributes($type,$itemId) {
      $controller = $this->getController('item_info');
      return $controller->getAttributes($type, $itemId);
    }

  	public function getAttributesByElement($type,$itemId,$attributeCodeOrId) {
      $controller = $this->getController('item_info');
      return $controller->getAttributesByElement($type, $itemId,$attributeCodeOrId);
    }

  	public function getRelationships($type,$itemId,$relatedType) {
      $controller = $this->getController('item_info');
      return $controller->getRelationships($type, $itemId,$relatedType);
    }

  	public function getRelationshipTypes($type,$subTypeId,$relatedType,$relatedSubTypeId) {
      $controller = $this->getController('item_info');
      return $controller->getRelationshipTypes($type, $subTypeId,$relatedType,$relatedSubTypeId);
    }

    public function getSets($user_id=null, $access=null, $status=null) {
      $controller = $this->getController('item_info');
      return $controller->getSets($user_id, $access, $status);
    }

  	public function getSet($setId, $checkAccess=array()) {
      $controller = $this->getController('item_info');
      return $controller->getSet($setId, $checkAccess);
    }

  	public function getSetItems($setId, $full_item_description, $ids_only, $sort=null, $checkAccess=array()) {
      $controller = $this->getController('item_info');
      return $controller->getSetItems($setId, $full_item_description, $ids_only, $sort, $checkAccess);
    }

  	public function getSetsForItem($type,$itemId) {
      $controller = $this->getController('item_info');
      return $controller->getSetsForItem($type,$itemId);
    }

    public function getRecentlyAddedItems($itemLimit, $checkAccess, $hasRepresentations) {
      $controller = $this->getController('search');
      return $controller->getRecentlyAddedItems($itemLimit, $checkAccess, $hasRepresentations);
    }

    public function getRandomItems($itemLimit, $checkAccess, $hasRepresentations) {
      $controller = $this->getController('search');
      return $controller->getRandomItems($itemLimit, $checkAccess, $hasRepresentations);
    }

    public function getMostViewedItems($itemLimit, $checkAccess, $hasRepresentations) {
      $controller = $this->getController('search');
      return $controller->getMostViewedItems($itemLimit, $checkAccess, $hasRepresentations);
    }

    public function getHighestRated($itemLimit, $moderatedStatus, $checkAccess, $hasRepresentations) {
      $controller = $this->getController('search');
      return $controller->getHighestRated($itemLimit, $moderatedStatus, $checkAccess, $hasRepresentations);
    }

    public function search($type, $query, $sort, $appendToSearch, $sort_direction) {
      //var_dump($query);
      //die(var_dump($appendToSearch));
      $controller = $this->getController('search');
      return $controller->search($type, $query, $sort, $appendToSearch, $sort_direction);
    }

    public function createUser($username,$email,$fname,$lname,$password) {
      $controller = $this->getController('user_content');
      return $controller->createUser($username,$email,$fname,$lname,$password);
    }

    public function getUser($username_or_id) {
      $controller = $this->getController('user_content');
      return $controller->getUser($username_or_id);
    }

    public function addComment($type, $itemId, $comment, $email, $name, $localeId, $access, $rating,$user_id) {
      $controller = $this->getController('user_content');
      return $controller->addComment($type,$itemId,$comment,$email,$name,$localeId,$access,$rating,$user_id);
    }

    public function rateObject($type, $itemId, $rating,$user_id, $moderation_status) {
      $controller = $this->getController('user_content');
      return $controller->rateObject($type, $itemId, $rating, $moderation_status,$user_id);
    }

    public function getComments($base_model) {
      $controller = $this->getController('user_content');
      return $controller->getComments($base_model->table,$base_model->primaryKey);
    }

    public function getTags($base_model) {
      $controller = $this->getController('user_content');
      return $controller->getTags($base_model->table,$base_model->primaryKey);
    }

    public function getAverageRating($base_model, $moderation_status) {
      $controller = $this->getController('user_content');
      return $controller->getAverageRating($base_model->table, $base_model->primaryKey, $moderation_status);
    }

  	public function getTotalRatings($base_model, $moderation_status) {
      $controller = $this->getController('user_content');
      return $controller->getTotalRatings($base_model->table, $base_model->primaryKey, $moderation_status);
    }

    public function addItemToSet($set_id,$type,$item_id,$type_id,$set_item_info_array) {
      $controller = $this->getController('user_content');
      return $controller->addItemToSet($set_id,$type,$item_id,$type_id,$set_item_info_array);
    }

  	public function addSet($type, $type_id, $user_id, $set_code, $label, $localeId, $access, $status) {
      $controller = $this->getController('user_content');
      return $controller->addSet($type, $type_id, $user_id, $set_code, $label, $localeId, $access, $status);
    }

   	public function addTag($type, $item_id, $tag, $user_id, $locale=null, $access=null, $moderator=null) {
      $controller = $this->getController('user_content');
      return $controller->addTag($type, $item_id, $tag, $locale, $access, $moderator,$user_id);
    }

   	public function removeItemFromSet($set_id,$set_item_id) {
      $controller = $this->getController('user_content');
      return $controller->removeItemFromSet($set_id,$set_item_id);
   	}

  	public function removeSet($set_id) {
      $controller = $this->getController('user_content');
      return $controller->removeSet($set_id);
   	}

  	public function updateSet($set_id, $set_code, $label, $localeId, $access, $status) {
      $controller = $this->getController('user_content');
      return $controller->updateSet($set_id, $set_code, $label, $localeId, $access, $status);
   	}

  	public function updateSetItem($set_item_id,$set_item_info_array) {
      $controller = $this->getController('user_content');
      return $controller->updateSetItem($set_item_id,$set_item_info_array);
   	}

  	public function resetPassword($userid,$password) {
      $controller = $this->getController('user_content');
      return $controller->resetPassword($userid,$password);
   	}

    public function newBrowse($type, $context = '') {
      $controller = $this->getController('browse');
      return $controller->newBrowse($type, $context);
    }

    public function loadBrowse($type, $context = '') {
      $controller = $this->getController('browse');
      return $controller->loadBrowse($type);
    }

    public function getContext() {
      $controller = $this->getController('browse');
      return $controller->getContext();
    }

    public function getFacetList() {
      $controller = $this->getController('browse');
      return $controller->getFacetList();
    }

    public function getFacet($facet_name, $checkAccess = false) {
      $controller = $this->getController('browse');
      return $controller->getFacet($facet_name, $checkAccess);
    }

    public function getFacetContent($facet_name, $checkAccess = false) {
      $controller = $this->getController('browse');
      return $controller->getFacetContent($facet_name, $checkAccess);
    }

    public function getInfoForFacets() {
      $controller = $this->getController('browse');
      return $controller->getInfoForFacets();
    }

    public function getInfoForFacet($facet_name) {
      $controller = $this->getController('browse');
      return $controller->getInfoForFacet($facet_name);
    }

    public function getInfoForAvailableFacets() {
      $controller = $this->getController('browse');
      return $controller->getInfoForAvailableFacets();
    }

    public function isValidFacetName($facet_name) {
      $controller = $this->getController('browse');
      return $controller->isValidFacetName($facet_name);
    }

    public function execute($checkAccess = false) {
      $controller = $this->getController('browse');
      return $controller->execute($checkAccess);
    }

    public function getResults($options=null) {
      $controller = $this->getController('browse');
      return $controller->getResults($options);
    }

    public function addCriteria($facet_name,$row_ids) {
      $controller = $this->getController('browse');
      return $controller->addCriteria($facet_name,$row_ids);
    }

  	public function removeCriteria($facet_name,$row_ids) {
      $controller = $this->getController('browse');
      return $controller->removeCriteria($facet_name,$row_ids);
    }

  	public function addResultFilter($field,$operator,$value) {
      $controller = $this->getController('browse');
      return $controller->addResultFilter($field,$operator,$value);
    }

  	public function clearResultFilters() {
      $controller = $this->getController('browse');
      return $controller->clearResultFilters();
    }

  	public function criteriaHaveChanged() {
      $controller = $this->getController('browse');
      return $controller->criteriaHaveChanged();
    }

    public function getBrowseID() {
      $controller = $this->getController('browse');
      return $controller->getBrowseID();
    }

 	public function getCachedSortSetting() {
      $controller = $this->getController('browse');
      return $controller->getCachedSortSetting();
    }

    public function getCriteria($facet_name=null) {
      $controller = $this->getController('browse');
      return $controller->getCriteria($facet_name);
    }

    public function getCriteriaWithLabels($facet_name=null) {
      $controller = $this->getController('browse');
      return $controller->getCriteriaWithLabels($facet_name);
    }

   	public function getCriterionLabel($facet_name,$row_id) {
      $controller = $this->getController('browse');
      return $controller->getCriterionLabel($facet_name,$row_id);
    }

    public function getResultFilters() {
      $controller = $this->getController('browse');
      return $controller->getResultFilters();
    }

    public function numCriteria() {
      $controller = $this->getController('browse');
      return $controller->numCriteria();
    }

    public function removeAllCriteria($facet_name=null) {
      $controller = $this->getController('browse');
      return $controller->removeAllCriteria($facet_name);
    }

    public function setContext($context) {
      $controller = $this->getController('browse');
      return $controller->setContext($context);
    }

    public function sortHits($hits,$field, $direction = 'asc') {
      $controller = $this->getController('browse');
      return $controller->sortHits($hits, $field,$direction);
    }

    public function add($type, $fieldInfo) {
    	$controller = $this->getController('cataloguing');
    	return $controller->add($type,$fieldInfo);
    }

    public function addAttribute($type,$itemId,$attributeCodeOrId,$attributeDataArray) {
    	$controller = $this->getController('cataloguing');
    	return $controller->addAttribute($type,$itemId,$attributeCodeOrId,$attributeDataArray);
    }

    public function addAttributes($type,$itemId,$attributeListArray) {
    	$controller = $this->getController('cataloguing');
    	return $controller->addAttributes($type,$itemId,$attributeListArray);
    }

    public function addLabel($type,$itemId,$labelDataArray,$localeId,$isPreferred) {
    	$controller = $this->getController('cataloguing');
    	return $controller->addLabel($type,$itemId,$labelDataArray,$localeId,$isPreferred);
    }

    public function addRelationship($type, $itemId,$relatedType,$relatedItemId,$relationshipTypeId,$sourceInfo) {
    	$controller = $this->getController('cataloguing');
    	return $controller->addRelationship($type,$itemId,$relatedType,$relatedItemId,$relationshipTypeId,$sourceInfo);
    }

    public function addObjectRepresentation($objectId,$mediaURL,$typeId,$localeId,$status,$access,$isPrimary) {
    	$controller = $this->getController('cataloguing');
    	return $controller->addObjectRepresentation($objectId,$mediaURL,$typeId,$localeId,$status,$access,$isPrimary);
    }

    public function editLabel($type, $itemId,$labelId,$labelDataArray,$localeId,$isPreferred) {
    	$controller = $this->getController('cataloguing');
    	return $controller->editLabel($type,$itemId,$labelId,$labelDataArray,$localeId,$isPreferred);
    }

    public function editAttribute($type, $itemId,$attributeId,$attributeCodeOrId,$attributeDataArray) {
    	$controller = $this->getController('cataloguing');
    	return $controller->editAttribute($type,$itemId,$attributeId,$attributeCodeOrId,$attributeDataArray);
    }

    public function remove($type,$itemId) {
      $controller = $this->getController('cataloguing');
      return $controller->remove($type,$itemId);
    }

    public function removeAllAttributes($type,$itemId) {
      $controller = $this->getController('cataloguing');
      return $controller->removeAllAttributes($type,$itemId);
    }

  	public function removeAllLabels($type,$itemId) {
      $controller = $this->getController('cataloguing');
      return $controller->removeAllLabels($type,$itemId);
    }

    public function removeAttribute($type,$itemId,$attributeId) {
      $controller = $this->getController('cataloguing');
      return $controller->removeAttribute($type,$itemId,$attributeId);
    }

  	public function removeLabel($type,$itemId,$labelId) {
      $controller = $this->getController('cataloguing');
      return $controller->removeLabel($type,$itemId,$labelId);
    }

  	public function removeObjectRepresentation($representationId) {
      $controller = $this->getController('cataloguing');
      return $controller->removeObjectRepresentation($representationId);
    }

    public function removeRelationship($type,$relatedType,$relationId) {
      $controller = $this->getController('cataloguing');
      return $controller->removeRelationship($type,$relatedType,relationId);
    }

  	public function replaceAttribute($type,$itemId,$attributeCodeOrId,$attributeDataArray) {
      $controller = $this->getController('cataloguing');
      return $controller->replaceAttribute($type,$itemId,$attributeCodeOrId,$attributeDataArray);
    }

    public function update($type,$itemId,$fieldInfo) {
      $controller = $this->getController('cataloguing');
      return $controller->update($type,$itemId,$fieldInfo);
    }

    public function updateAttributes($type,$itemId,$attributeListArray) {
      $controller = $this->getController('cataloguing');
      return $controller->updateAttributes($type,$itemId,$attributeListArray);
    }

  	public function updateRelationship($type,$relatedType,$relationId,$relationshipTypeId,$sourceInfo) {
      $controller = $this->getController('cataloguing');
      return $controller->updateRelationship($type,$relatedType,$relationId,$relationshipTypeId,$sourceInfo);
    }

    public function getPlacesWithRelationsToObjects($placeType, $checkAccess=array()) {
      $controller = $this->getController('utils');
      return $controller->getPlacesWithRelationsToObjects($placeType, $checkAccess);
    }

    public function getCollectionsWithRelationsToObjects($checkAccess=array()) {
      $controller = $this->getController('utils');
      return $controller->getCollectionsWithRelationsToObjects($checkAccess);
    }

    public function getObjectRepresentationsForObjects($objectIds, $primaryOnly, $versions) {
      $controller = $this->getController('utils');
      return $controller->getObjectRepresentationsForObjects($objectIds, $primaryOnly, $versions);
    }

    public function getAllObjects($regenerate = true) {
      $controller = $this->getController('utils');
      return $controller->getAllObjects($regenerate);
    }

    public function getQueryBasedOverview($key, $regenerate = true) {
      $controller = $this->getController('utils');
      return $controller->getQueryBasedOverview($key, $regenerate);
    }

    public function sortByRating($type, $itemIds, $ascending) {
      $controller = $this->getController('utils');
      return $controller->sortByRating($type, $itemIds, $ascending);
    }

    private function invalidateControllers() {
      $controllers = array();
    }

    private function getController($name) {
      $name[0] = strtoupper($name[0]);
      $func = create_function('$c', 'return strtoupper($c[1]);');
      $convertedName = preg_replace_callback('/_([a-z])/', $func, $name);
      if(!isset($this->controllers[$convertedName])) {
        $controllerName = $convertedName.'ServiceController';
        $this->controllers[$convertedName] = new $controllerName($this->controllerConfig);
      }
      return $this->controllers[$convertedName];
    }

  }

  class AutoloadClass {

    public static function autoload($class) {
		$basepath = dirname(__FILE__);
      if ('nusoap_base' == $class || 'nusoap_client' == $class) {
        require_once $basepath . '/lib/nusoap/nusoap.php';
		require_once($basepath . '/lib/nusoap/class.wsdlcache.php');
      } else {
        $file = $class . '.php';
        if (file_exists($basepath . '/controllers/' . $file)){
			require_once $basepath . '/controllers/' . $file;
		} else if (file_exists($basepath . '/models/' . $file)){
			require_once $basepath . '/models/' . $file;
		} else if (file_exists($basepath . '/lib/' . $file)){
			require_once $basepath . '/lib/' . $file;
		} else if (file_exists($basepath . '/lib/nusoap/' . $file)){
			require_once $basepath . '/lib/nusoap/' . $file;
		} else if (file_exists($basepath . '/utils/' . $file)){
			require_once $basepath . '/utils/' . $file;
		} else if (file_exists($basepath . '/utils/caching/' . $file)){
			require_once $basepath . '/utils/caching/' . $file;
		}
      }
    }
  }
?>
