<?php
require "load.php";
$Objlayout ->heading();
$ObjMenus ->main_menus();
$Objheadings ->main_banner();
$ObjForm ->create_password_form($ObjGlob, $conn);
$ObjContents->side_bar();
$Objlayout ->footer();

?>