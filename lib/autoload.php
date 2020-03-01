<?php
//ini_set("error_reporting", E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
require_once "root.php";
$_root_folder = $_SERVER['DOCUMENT_ROOT'] . "$_application_folder";

//load Models
require_once $_root_folder . "/Model/City.php";
require_once $_root_folder . "/Model/User.php";
require_once $_root_folder . "/Model/File.php";
require_once $_root_folder . "/Model/Menu.php";
require_once $_root_folder . "/Model/Task.php";
//load Services
require_once $_root_folder . "/Service/CityService.php";
require_once $_root_folder . "/Service/UserService.php";
require_once $_root_folder . "/Service/DownloadService.php";
require_once $_root_folder . "/Service/Container.php";
require_once $_root_folder . "/Service/DatabaseService.php";
require_once $_root_folder . "/Service/ViewService.php";
require_once $_root_folder . "/Service/UploadService.php";
require_once $_root_folder . "/Service/FormHandler.php";
//database functions
require_once $_root_folder . "/lib/passwd.php";
require_once $_root_folder . "/lib/pdo.php";

session_start();
$_SESSION["head_printed"] = false;

$container = new Container($connectionData);
$viewService = $container->getViewService();
$UserService = $container->getUserService();


//redirect naar NO ACCESS pagina als de gebruiker niet ingelogd is en niet naar
//de loginpagina gaat
if ( ! isset($_SESSION['usr_id']) AND ! $form AND ! $no_access)
{
    header("Location: " . $_application_folder . "/no_access.php");
}

