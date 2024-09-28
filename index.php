<?php
require "load.php";
$Objlayout ->heading();
$ObjMenus ->main_menus();
$Objheadings ->main_banner();
$ObjContent ->main_content();
$ObjContent->side_bar();
$Objlayout ->footer();

?>