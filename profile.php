<?php
require "load.php";
$ObjGlob->checksignin();
$Objlayout ->heading();
$ObjMenus ->main_menus();
$Objheadings ->main_banner();
$ObjAuth->profile_form($ObjGlob, $conn);
$Objlayout ->footer();

?>