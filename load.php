<?php

session_start();
require "includes/constants.php";
require "includes/dbConnection.php";
require "lang/en.php";
require 'processes/auth.php';
require 'global/sendMail.php';


//Class AutoLoad
function classAutoLoad($classname){
    $directories = ["Contents", "layout", "menus", "forms", "processes", "global"];

    foreach($directories AS $dir){
        $filename =  dirname(__FILE__). DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $classname . ".php";
        if(file_exists($filename) AND is_readable($filename)){
            require_once $filename;
        }
    } 
}  

spl_autoload_register('classAutoLoad');

$ObjGlob = new fncs();
$ObjSendMail = new sendMail();

//Create instance of all classes

$Objlayout = new layout();
$ObjMenus = new menus();
$Objheadings = new headings();
$ObjContents= new contents();
$ObjForm = new signup_form();
$conn = new dbConnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);

//Create process instances
$ObjAuth = new auth();
$ObjAuth->signup($conn, $ObjGlob, $ObjSendMail, $lang, $conf);
