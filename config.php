<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

define('SETTING_USE', 'default');

Config::Instance('default')->environment       = 'development'; //development | publish | offline

/**
 * URL Configuration
 *
 * configuration for all url (photos, base url, sll, etc)
 */

//Base URL
Config::Instance('default')->baseUrl            = 'http://localhost:8080/framework6/iq6/';

//SSL URL -> https
Config::Instance('default')->sslUrl             = 'http://localhost:8080/framework6/iq6/';

//Photos URL
Config::Instance('default')->photos             = 'http://localhost:8080/framework6/iq6/Photos/';


Config::Instance('default')->baseFile           = '';
Config::Instance('default')->applicationPath    = 'Applications';
Config::Instance('default')->defaultApplication = 'Account';
Config::Instance('default')->defaultController  = 'Login';
Config::Instance('default')->defaultAction      = 'Main';

Config::Instance('default')->appLink            = 'App';
Config::Instance('default')->comLink            = 'Com';
Config::Instance('default')->actLink            = 'Act';

Config::Instance('default')->URLMethod          = 'friendly';
Config::Instance('default')->permittedURIChars  = 'A-Za-z 0-9~%.:_\-';
Config::Instance('default')->encryptionKey      = 'dfu85xULsUYdfsdflj238xx4i75dhfkwhuooprhw48754x6399sdslk1273dsfy3811xxTY3934';


/**
 * Database Configuration
 *
 * database config
 */

//Default Database Configuration
Config::Instance('default')->hostname           = 'localhost';
Config::Instance('default')->username           = 'root';
Config::Instance('default')->password           = '';
Config::Instance('default')->database           = 'school';
Config::Instance('default')->driver             = 'MySQL';
Config::Instance('default')->driverOptions      = array();

//Social Database Configuration
Config::Instance('social')->hostname           = 'localhost';
Config::Instance('social')->username           = 'root';
Config::Instance('social')->password           = '';
Config::Instance('social')->database           = 'socialnetwork';
Config::Instance('social')->driver             = 'MySQL';
Config::Instance('social')->driverOptions      = array();

//Mastertables Database Configuration
Config::Instance('master')->hostname           = 'localhost';
Config::Instance('master')->username           = 'root';
Config::Instance('master')->password           = '';
Config::Instance('master')->database           = 'mastertables';
Config::Instance('master')->driver             = 'MySQL';
Config::Instance('master')->driverOptions      = array();




Config::Instance('default')->autoLoadLibs       = array();
Config::Instance('default')->template           = 'DarkBlue';
Config::Instance('default')->defaultLanguage    = 'ina';
Config::Instance('default')->paramLanguage      = 'setLanguage';
Config::Instance('default')->availableLanguage  = array("English International (EN)"=>"en", "Bahasa Indonesia (INA)"=>"ina");

Config::Instance('default')->tempDirectory      = 'Temp';

Config::Instance('default')->sessionName        = 'session_cookie';

Config::Instance('default')->cookieName        = 'cookie_value';
Config::Instance('default')->cookieTime        = 3600*24*30*12;
Config::Instance('default')->cookiePath        = '/';
Config::Instance('default')->cookieDomain      = '';
?>