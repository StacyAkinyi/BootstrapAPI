<?php
require "load.php";
$Objlayout ->heading();
$ObjMenus ->main_menus();
$Objheadings ->main_banner();
$ObjForm ->sign_in_form($ObjGlob);
$ObjContents ->side_bar();
$Objlayout ->footer();