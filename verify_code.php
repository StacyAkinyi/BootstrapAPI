<?php
require "load.php";
$Objlayout ->heading();
$ObjMenus ->main_menus();
$Objheadings ->main_banner();
$ObjForm -> verify_code_form();
$ObjContents->side_bar();
$Objlayout ->footer();

?>