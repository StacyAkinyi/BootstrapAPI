<?php
require "load.php";
$ObjGlob->checksignin();
$Objlayout ->heading();
$ObjMenus ->main_menus();
$Objheadings ->main_banner();
$ObjForm ->complete_reg_form($ObjGlob, $conn);
$ObjContents ->side_bar();
$Objlayout ->footer();