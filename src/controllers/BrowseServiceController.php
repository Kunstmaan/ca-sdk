<?php
  class BrowseServiceController extends BaseServiceController {

    protected $serviceLocation = "/browse/Browse";

    public function __construct($config=null) {
      parent::__construct($config);
    }

    /**
     * @return boolean indicating if the new browse has been created.
     */
    public function newBrowse($type, $context = '') {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'content' => $context
      );
      $result = $this->call('newBrowse', $params);
      return $result;
    }

    public function loadBrowse($type, $context = '') {
      $modelMapping = parent::$modelMapping;
      if(!isset($modelMapping[$type])){
        throw new Exception('Type not supported: '.$type);
      }
      $params = array(
        'type' => $type,
        'content' => $context
      );
      $result = $this->call('loadBrowse', $params);
      return $result;
    }

    /**
     * @return a list of facets available for the current browse.
     */
    public function getFacetList() {
      $params = array();
      $result = $this->call('getFacetList', $params);
      return $result;
    }

    public function getFacet($facet_name, $checkAccess = false) {
      $params = array(
        'facet_name' => $facet_name,
        'options' => array(
          'checkAccess' => $checkAccess
        )
      );
      $result = $this->call('getFacet', $params);
      return $result;
    }

    public function getFacetContent($facet_name, $checkAccess = false) {
      $params = array(
        'facet_name' => $facet_name,
        'options' => array(
          'checkAccess' => $checkAccess
        )
      );
      $result = $this->call('getFacetContent', $params);
      return $result;
    }

    public function getInfoForFacets() {
      $params = array();
      $result = $this->call('getInfoForFacets', $params);
      return $result;
    }

    public function getInfoForFacet($facet_name) {
      $params = array(
        'facet_name' => $facet_name
      );
      $result = $this->call('getInfoForFacet', $params);
      return $result;
    }

    public function getInfoForAvailableFacets() {
      $params = array();
      $result = $this->call('getInfoForAvailableFacets', $params);
      return $result;
    }

    public function isValidFacetName($facet_name) {
      $params = array(
        'facet_name' => $facet_name
      );
      $result = $this->call('isValidFacetName', $params);
      return $result;
    }

    public function execute($checkAccess = false) {
      $params = array(
        'options' => array(
          'checkAccess' => $checkAccess
        )
      );
      $result = $this->call('execute', $params);
      return $result;
    }

    public function getResults($options = null) {
      $params = array(
		'options' => $options
        );
      $result = $this->call('getResults', $params);
      return $result;
    }

    public function getContext() {
      $result = $this->call('getContext');
      return $result;
    }

    public function addCriteria($facet_name,$row_ids) {
      $params = array(
		'facet_name' => $facet_name,
      	'row_ids' => $row_ids
      );
      $result = $this->call('addCriteria', $params);
      return $result;
    }

    public function removeCriteria($facet_name,$row_ids) {
      $params = array(
		'facet_name' => $facet_name,
      	'row_ids' => $row_ids
      );
      $result = $this->call('removeCriteria', $params);
      return $result;
    }

    public function addResultFilter($field,$operator,$value) {
      $params = array(
		'field' => $field,
      	'operator' => $operator,
      	'value' => $value
      );
      $result = $this->call('addResultFilter', $params);
      return $result;
    }

    public function clearResultFilters() {
      $params = array();
      $result = $this->call('clearResultFilters', $params);
      return $result;
    }

    public function criteriaHaveChanged() {
      $params = array();
      $result = $this->call('criteriaHaveChanged', $params);
      return $result;
    }

    public function getBrowseID() {
      $params = array();
      $result = $this->call('getBrowseID', $params);
      return $result;
    }

    public function getCachedSortSetting() {
      $result = $this->call('getCachedSortSetting');
      return $result;
    }

    public function getCriteria($facet_name = null) {
      $params = array(
		'facet_name' => $facet_name
        );
      $result = $this->call('getCriteria', $params);
      return $result;
    }

    public function getCriteriaWithLabels($facet_name = null) {
      $params = array(
		'facet_name' => $facet_name
        );
      $result = $this->call('getCriteriaWithLabels', $params);
      return $result;
    }

    public function getCriterionLabel($facet_name,$row_id) {
      $params = array(
		'facet_name' => $facet_name,
      	'row_id' => $row_id
      );
      $result = $this->call('getCriterionLabel', $params);
      return $result;
    }

    public function getResultFilters() {
      $result = $this->call('getResultFilters');
      return $result;
    }

    public function numCriteria() {
      $result = $this->call('numCriteria');
      return $result;
    }

    public function removeAllCriteria($facet_name = null) {
      $params = array(
		'facet_name' => $facet_name
        );
      $result = $this->call('removeAllCriteria', $params);
      return $result;
    }

    public function setContext($context) {
      $params = array(
		'context' => $context
        );
      $result = $this->call('setContext', $params);
      return $result;
    }

    public function sortHits($hits, $field, $direction='asc') {
      $params = array(
		'hits' => $hits,
      	'field' => $field,
      	'direction' => $direction
      );
      $result = $this->call('sortHits', $params);
      return $result;
    }

  }
?>