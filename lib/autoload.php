<?php
/*
    ====root folder instructions ====
 ->create root.php in the lib map AND do not include it in the repository!
 ->copy the contend of example_root.php in root.php
 ->change the path in root.php to your path starting from the thdocs folder
 example = (/php/projects/phpCityOOPRefactor)
*/
//ini_set("error_reporting", E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
require_once "root.php";
//$_application_folder = "/testremote_new";
$_root_folder = $_SERVER['DOCUMENT_ROOT'] . "$_application_folder";

//load Models
require_once $_root_folder . "/Model/City.php";
require_once $_root_folder . "/Model/User.php";

//load Services
require_once $_root_folder . "/Service/CityLoader.php";
require_once $_root_folder . "/Service/MessageService.php";
require_once $_root_folder . "/Service/UserService.php";

require_once $_root_folder . "/Service/DownloadService.php";

require_once $_root_folder . "/Service/Container.php";


session_start();
$_SESSION["head_printed"] = false;
/**
 *
 */
$MS = new MessageService();
$UserService = new UserService();

require_once $_root_folder . "/lib/passwd.php";
require_once $_root_folder . "/lib/pdo.php";                          //database functies
require_once $_root_folder . "/lib/view_functions.php";      //basic_head, load_template, replacecontent...

//redirect naar NO ACCESS pagina als de gebruiker niet ingelogd is en niet naar
//de loginpagina gaat
if ( ! isset($_SESSION['usr']) AND ! $login_form AND ! $register_form AND ! $no_access)
{
    header("Location: " . $_application_folder . "/no_access.php");
}

