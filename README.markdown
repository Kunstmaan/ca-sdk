CollectiveAccess SDK for PHP
============================

[CollectiveAccess](http://www.collectiveaccess.org/) supports a broad range of its 
functionality through a number of web services that can be accessed by other software, 
developed in any programming language you like.

This repository contains an open source PHP SDK that allows you to utilize the above 
webservices on your website.

This is a work in progress, we have modified the web services for CA and extended it with
our own services. Our extensions aren't available at the moment but we will add them to
github ASAP. If you have questions you can contact us [Kunstmaan](http://www.kunstmaan.be/).


Requirements
------------

The following dependencies are bundled with the CollectiveAccess SDK for PHP, but are under
terms of a separate license. See the bundled LICENSE files for more information:

 * Nusoap - http://nusoap.sourceforge.net/

Source
------
The source tree for includes the following files and directories:

* `lib` -- Contains any third-party libraries that the SDK depends on.
* `controllers` -- Contains the service-specific classes that communicate with webservices of CA.
  Every service has it's own class: Browse service, Cataloguing service, Item info service, Search service and User content service
* `models` -- Contains a class for every CA object. Some of the services will return a parsed object in stead of an array.
* `CollectiveAccess.php` -- Is the main class that will be used, this class will delegate to the right service class.

Usage
-----
The [examples][examples] are a good place to start, the minimal you'll need to know is:

    <?php

    require './CollectiveAccess.php';

    $ca = new CollectiveAccess(array(
      'username'  => 'YOUR API USERNAME',
      'password' => 'YOUR API PASSWORD',
      'base_url' => 'THE BASE URL OF YOUR SERVICE' // For example: http://www.your-collectiveaccess-instance/
      'cache_provider' => // An object which can be used for caching, this needs to integrate two methods: load(key) and save(value, key). (optional)
    ));

To make [API][API] calls, the names of the function correspond with the ones in CA:

      $me = $ca->getObject('YOUR ID')


[examples]: https://github.com/Kunstmaan/ca-sdk/blob/master/samples/example.php
[API]: http://wiki.collectiveaccess.org/index.php?title=Web_services


TODO
----

* Add the extended and modified web-services to github.
* Documentation.
* Examples.
* Tests.


Additional Information
----------------------

* CollectiveAccess: <http://www.collectiveaccess.org/>
* Kunstmaan: <http://www.kunstmaan.be>
