<?php
require "load.php";
$Objlayout ->heading();
$ObjMenus ->main_menus();
$Objheadings ->main_banner();
$ObjForm ->sign_up_form($ObjGlob);
$ObjContent ->side_bar();
$Objlayout ->footer();