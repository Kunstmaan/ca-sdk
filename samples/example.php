<?php

  $base_url = 'YOUR BASE URL HERE';
  $username = 'YOUR USERNAME HERE';
  $password = 'YOUR PASSWORD HERE';

  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  require_once('../src/CollectiveAccess.php');
  spl_autoload_register(array('AutoloadClass', 'autoload'));


  $config = array(
    "username" => $username,
    "password" => $username,
    "base_url" => $base_url
  );

  $ca = new CollectiveAccess($config);

  $output = "<pre>";

  // get the 10 most recently added items and print their label.
  foreach($ca->getRecentlyAddedItems(10, false, true) as $object) {
    $output .= print_r($object->getLabelForDisplay(), true);
  }

  // get the object with id 1.
  $output .= print_r($ca->getObject(1), true);

  // get the collection with id 1.
  $output .= print_r($ca->getCollection(1), true);

  $output .= "</pre>";

  print $output;
?>