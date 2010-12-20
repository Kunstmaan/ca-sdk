<?php

  interface Node {
    
    public function getPrimaryKey();
    public function getTable();
    
    public function getAncestor();
    public function getChildren();
    
    public function setAncestor($ancestor, $addChild = true);
    public function addChild($child, $addAncestor = true);
    
    public function getParentId();
    
  }
?>