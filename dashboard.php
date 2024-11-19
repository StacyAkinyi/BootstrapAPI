<?php
require "load.php";
$ObjGlob->checksignin();
$ObjGlob->verify_profile();
$Objlayout ->heading();
$ObjMenus ->main_menus();
$Objheadings ->main_banner();
$ObjForm ->sign_up_form($ObjGlob);
$ObjContents ->side_bar();
$Objlayout ->footer();