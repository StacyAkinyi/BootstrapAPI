<?php
require "load.php";
$Objlayout ->heading();
$ObjMenus ->main_menus();
$Objheadings ->main_banner();
$ObjAuth->profile($conn);
$Objlayout ->footer();

?>