<?php
class menus{
    public function main_menus(){
        ?>
        <head>
            
            <link rel = "stylesheet" href="css\style.css"/>
        </head>
        <div class ="topnav">
            <a href="./">Home</a>
            <a href="about.php">About us</a>
            <a href="./">Services</a>
            <a href="./">Contact us</a>
            <a href="./">FAQ</a>
            <?php $this->main_right_menus();?>
    </div>
        <?php
    }
    public function main_right_menus(){
        ?>
        <div class ="topnav-right">
            <a href="./">Sign in</a>
            <a href="signup.php">Sign up</a>
        </div>
        <?php
    }
}