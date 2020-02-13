<?php
$_application_folder = "/phpCityOOPRefactor";
$_root_folder = $_SERVER['DOCUMENT_ROOT'] . "$_application_folder";

//load Models
require_once $_root_folder . "/Model/City.php";
require_once $_root_folder . "/Model/User.php";

//load Services
require_once $_root_folder . "/Service/CityLoader.php";
require_once $_root_folder . "/Service/MessageService.php";

session_start();
$_SESSION["head_printed"] = false;

$MS = new MessageService();

require_once $_root_folder . "/lib/passwd.php";
require_once $_root_folder . "/lib/pdo.php";                          //database functies
require_once $_root_folder . "/lib/view_functions.php";      //basic_head, load_template, replacecontent...

//redirect naar NO ACCESS pagina als de gebruiker niet ingelogd is en niet naar
//de loginpagina gaat
if ( ! isset($_SESSION['usr']) AND ! $login_form AND ! $register_form AND ! $no_access)
{
    header("Location: " . $_application_folder . "/no_access.php");
}
