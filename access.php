<?php
//Handler No Direct Access For All Files
define( 'FILE_ACCESS',     true );


define( 'PATH_BASE',	dirname(__FILE__) );
define( 'DS',           DIRECTORY_SEPARATOR );

$parts  = explode( DS, PATH_BASE );

//Define PATH
define( 'PATH_ROOT',			implode(DS, $parts) );
define( 'PATH_SITE',			PATH_ROOT );
define( 'PATH_CONFIGURATION',	PATH_ROOT );
define( 'PATH_APPLICATIONS',	PATH_ROOT.DS.'Applications' );
define( 'PATH_LIBRARIES',		PATH_ROOT.DS.'Libraries' );
define( 'PATH_TEMPLATES',		PATH_ROOT.DS.'Templates' );
define( 'PATH_TEMP',			PATH_ROOT.DS.'Temp' );

define('INT', 'INT');
define('TEXT', 'TEXT');
define('XSS', 'XSS');

require_once PATH_LIBRARIES.DS.'Core'.DS.'Common.php';
?>