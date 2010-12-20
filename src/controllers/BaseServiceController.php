<?php
  class BaseServiceController {

   protected $debug = false;
   protected $loglevel = 1;
   protected $log = null;

    /**
     * The Collective Access application username.
     */
    protected $username;

    /**
     * The Collective Access application password.
     */
    protected $password;

    /**
     * The base url of the Collective Access application.
     */
    protected $baseUrl;

    /**
     * A caching provider which will handle all the caching.
     */
    protected $cacheProvider;

    /**
     * The soap client of the used for the Collective Access requests.
     */
    protected $client;

    /**
     * The soap Wsdl location.
     */
    private $wsdlLocation = "soapWSDL";

    protected static $modelMapping = array(
      "ca_objects" => "Object",
      "ca_entities" => "Entity",
      "ca_places" => "Place",
      "ca_occurrences" => "Occurrence",
      "ca_collections" => "Collection",
      "ca_list_items" => "ListItem",
      "ca_storage_locations" => "StorageLocation"
    );

    protected static $modelNumMapping = array(
      "57" => "Object",
      "20" => "Entity",
      "72" => "Place",
      "67" => "Occurrence",
      "13" => "Collection",
      "33" => "Place",
      "89" => "StorageLocation"
    );

    /**
     * Initialize a BaseServiceController.
     *
     * The configuration:
     * username: the username for the Collective Access application.
     * password: the password for the Collective Access application.
     * base_url: the base url of the Collective Access application.
     * cache_provider: (optional) an object which will handle all the caching.
     *
     * @param Array $config the Collective Access configuration.
     */
    public function __construct($config) {
      $this->setUsername($config['username']);
      $this->setPassword($config['password']);
      $this->setBaseUrl($config['base_url']);
      if(isset($config['cache_provider']) && $config['cache_provider'] != null) {
        $this->cacheProvider = $config['cache_provider'];
      }
      $this->log = new Logging();
    }

    /**
     * Set the Collective Access application username.
     *
     * @param String $username of the Collective Access application.
     */
    public function setUsername($username) {
      $this->username = $username;
      return $this;
    }

    /**
     * Get the Collective Access application username.
     *
     * @return String the Collective Access application username.
     */
    public function getUsername() {
      return $this->username;
    }

    /**
     * Set the Collective Access application password.
     *
     * @param String $password of the Collective Access application.
     */
    public function setPassword($password) {
      $this->password = $password;
      return $this;
    }

    /**
     * Get the Collective Access application password.
     *
     * @return String the Collective Access application password.
     */
    public function getPassword() {
      return $this->password;
    }

    /**
     * Set the Collective Access application base url.
     *
     * @param String $baseUrl of the Collective Access application.
     */
    public function setBaseUrl($baseUrl) {
      $this->baseUrl = $baseUrl;
      return $this;
    }

    /**
     * Get the Collective Access application base url.
     *
     * @return String the Collective Access application base url.
     */
    public function getBaseUrl() {
      return $this->baseUrl;
    }

    public function getCacheProvider() {
      return $this->cacheProvider;
    }

    public function setCacheProvider($cacheProvider) {
      $this->cacheProvider = $cacheProvider;
      return $this;
    }

    public function getServiceConfiguration() {
      $config = array (
        'username' => $this->getUsername(),
        'password' => $this->getPassword(),
        'base_url' => $this->getBaseUrl(),
        'cache_provider' => $this->getCacheProvider()
      );
      return $config;
    }

    public function getInstanceByTableNum($num, $itemId, $itemInfoService = null, $result_arr) {
      return $this->getInstance(self::$modelNumMapping[(int) $num], $itemId, $itemInfoService = null, $result_arr);
    }

    public function getInstanceByTable($table, $itemId, $itemInfoService = null, $result_arr) {
      return $this->getInstance(self::$modelMapping[$table], $itemId, $itemInfoService, $result_arr);
    }

    public function getInstance($model, $itemId, $itemInfoService = null, $result_arr) {
      return new $model($itemId, $itemInfoService, $result_arr);
    }

    /**
     * Get the Collective Access services wsdl location.
     *
     * @return String the Collective Access services wsdl location.
     */
    protected function getWSDLLocation() {
      $url = $this->getBaseUrl();
      $url .= 'service.php';
      $url .= $this->serviceLocation;
      $url .= '/'.$this->wsdlLocation;
      return $url;
    }

    protected function getClient() {
      if(!isset($this->client) || !$this->client) {
        nusoap_base::setGlobalDebugLevel(0);
        $wsdl_path = $this->getWSDLLocation();
        $cache = new nusoap_wsdlcache('/tmp', 86400);
        $wsdl = $cache->get($url);
        if(is_null($wsdl)){
          $wsdl = new wsdl($wsdl_path, '', '', '', '', 5);
          $cache->put($wsdl);
        }
        $client = new nusoap_client($wsdl,'wsdl');
        //$client = new nusoap_client($wsdl_path, true);
        $client->decode_utf8 = false;
        //$client->setDebugLevel(9);
        //$client->clearDebug();
        if ($client->getError()) {
          throw new Exception("Initialising soap client failed, invalid wsdl?");
        }
        $this->client = $client;
      }
      return $this->client;
    }

    protected function serializeParams($params = array()) {
      $result = '';
      foreach($params as $param) {
        if(!empty($result)) {
          $result .= '_';
        }
        if(is_array($param)) {
          $result .= '['.$this->serializeParams($param).']';
        } else {
          $result .= strtolower(str_replace(' ', '_', $param));
        }
      }
      return $result;
    }

    protected function call($function, $params=array(), $trylogin=true, $do_cache=false) {
      $vo_cache_key = 'cached_call_' . $function ."_". $this->serializeParams($params) . "_" . $trylogin;
      $cacheProvider = $this->getCacheProvider();
      if($do_cache && isset($cacheProvider) && ($cache = $this->loadFromCache($vo_cache_key)) && !empty($cache)) {
        if($this->debug) {
          if(!$this->log) {
            $this->log = new Logging();
          }
          $this->log->lwrite('Cache hit: '.$vo_cache_key);
        }
        return $cache;
      } else {
        if($this->debug) {
          if(!$this->log) {
            $this->log = new Logging();
          }
          $this->log->lwrite('Calling function: '.$function.' with params '.print_r($params, true));
          $starttime = time();
        }

        $client = $this->getClient();
        // $client->setDebugLevel(9);
        // $client->clearDebug();

        // try without authentication
        $result = $client->call($function, $params);
        //

        if($this->debug) {
          $totaltime = time() - $starttime;
          $this->log->lwrite('Duration of call: '.$totaltime.'sec.');
          if($this->loglevel > 1) {
            $this->log->lwrite('Return function: '.$function.' with result '.print_r($result, true));
          }
        }

        if(is_array($result)) {
          if(isset($result['faultcode'])) {
            $this->log->lwrite('Error: '.$result['faultstring']);
            // array try authenticating first
            if($trylogin) {
              if($this->doAuth()) {
                $result = $this->call($function, $params, false);
              }
            } else {
              if(!$this->log) {
                $this->log = new Logging();
              }
              $this->log->lwrite('Error: '.$result['faultstring']);
            }
          }
        }
        if($do_cache && isset($cacheProvider)) {
          $this->saveToCache($vo_cache_key, $result);
        }
        return $result;
      }
    }

    protected function saveToCache($key, $value) {
      if($this->getCacheProvider() != null && method_exists($this->getCacheProvider(), 'save')) {
        $this->getCacheProvider()->save($value, $key);
      }
      return $this;
    }

    protected function loadFromCache($key) {
      if($this->getCacheProvider() != null && method_exists($this->getCacheProvider(), 'load')) {
        return $this->getCacheProvider()->load($key);
      }
      return null;
    }

    public function doTest() {
      $params = array();
      $result_arr = $this->call('test', $params);
      return $result_arr;
    }

    public function auth() {
      $client = $this->getClient();
      $params = array(
        'username' => $this->getUsername(),
        'password' => $this->getPassword()
      );

      $result = $client->call('auth', $params);
      return $result;
    }

    public function doAuth() {
      $result = $this->auth();
      if($result <= 0) {
        throw new Exception('Authentication failed for username = '.$this->getUsername().' and password = '.$this->getPassword().' ('.$this->getBaseUrl().')');
      }
      return $result;
    }

    public function getUserId() {
      $client = $this->getClient();
      $result = $client->call('getUserID', array());
      return $result;
    }

  }

 /**
  * Logging class:
  * - contains lopen and lwrite methods
  * - lwrite will write message to the log file
  * - first call of the lwrite will open log file implicitly
  * - message is written with the following format: hh:mm:ss (script name) message
  */
  class Logging{
    // define log file
    private $log_file = '/tmp/ca_services.log';
    // define file pointer
    private $fp = null;
    // write message to the log file
    public function lwrite($message){
      // if file pointer doesn't exist, then open log file
      if (!$this->fp) $this->lopen();
      // define script name
      //$script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
      $pageurl = $this->curPageURL();
      // define current time
      $time = date('H:i:s');
      // write current time, script name and message to the log file
      fwrite($this->fp, "$time ($pageurl) $message\n");
    }
    // open log file
    private function lopen(){
      // define log file path and name
      $lfile = $this->log_file;
      // define the current date (it will be appended to the log file name)
      $today = date('Y-m-d');
      // open log file for writing only; place the file pointer at the end of the file
      // if the file does not exist, attempt to create it
      $this->fp = fopen($lfile . '_' . $today, 'a') or exit("Can't open $lfile!");
    }
    private function curPageURL() {
      $pageURL = 'http';
      if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
      if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
      } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
      }
      return $pageURL;
    }
  }
?>
