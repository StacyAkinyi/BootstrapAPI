<?php
require "load.php";
$Objlayout ->heading();
$ObjMenus ->main_menus();
$Objheadings ->main_banner();
$ObjContents ->main_content();
$ObjContents->side_bar();
$Objlayout ->footer();

?>