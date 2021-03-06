<?php

define('MODE',(isset($_SERVER['MODE']))?$_SERVER['MODE']:'prod');

  /**
   * Init
   *
   * @package Membership Manager Pro
   * @author wojoscripts.com
   * @copyright 2010
   * @version $Id: init.php, v2.00 2011-07-10 10:12:05 gewa Exp $
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php
//error_reporting(E_ALL);
  

  $BASEPATH = str_replace("init.php", "", realpath(__FILE__));
  define("BASEPATH", $BASEPATH);
  
  $configFile = BASEPATH . "lib/config.ini.php";
  if (file_exists($configFile)) {
      require_once($configFile);
  } else {
      header("Location: setup/");
  }

  require_once(BASEPATH . "lib/class_db.php");
  
  require_once(BASEPATH . "lib/class_registry.php");
  Registry::set('Database',new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE));
  $db = Registry::get("Database");
  $db->connect();

  //Include Functions
  require_once(BASEPATH . "lib/functions.php");
  
  if (!defined("_PIPN")) {
	require_once(BASEPATH . "lib/class_filter.php");
	$request = new Filter();
  }

  //Start Core Class 
  require_once(BASEPATH . "lib/class_core.php");
  Registry::set('Core',new Core());
  $core = Registry::get("Core");

  //Start Paginator Class 
  require_once(BASEPATH . "lib/class_paginate.php");
  $pager = Paginator::instance();
  
  //Start User Class 
  require_once(BASEPATH . "lib/class_user.php");
  Registry::set('Users',new Users());
  $user = Registry::get("Users");

  //Start Membership Class 
  require_once(BASEPATH . "lib/class_membership.php");
  Registry::set('Membership',new Membership());
  $member = Registry::get("Membership");
  
  define("SITEURL", $core->site_url);
  define("ADMINURL", $core->site_url."/admin");
  define("UPLOADS", BASEPATH."uploads/");
  define("UPLOADURL", SITEURL."/uploads/");

switch(MODE)
{
    case 'local':
        define('WWW_HOST','fxparse');
        define('API_HOST','api.fxparse');
        define('DASHBOARD_HOST','dashboard.fxparse');

        break;
    default:
    case 'prod':
        define('WWW_HOST','www.topforexsignal.com');
        define('API_HOST','api.topforexsignal.com');
        define('DASHBOARD_HOST','dashboard.topforexsignal.com');

        break;
}
?>