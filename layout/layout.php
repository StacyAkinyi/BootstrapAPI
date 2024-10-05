<?php
class layout{
    public function heading(){
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            
            <link rel="stylesheet" href="css/style.css">
        </head>
        <body>
            <?php
    }

  public function footer(){
             ?> 
  <footer class="pt-3 mt-4 text-body-secondary border-top">
         Copyright &copy; ICS
    <?php print date("Y"); ?>
   </footer>


   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   </body>
   </html>

 <?php

 }public function profile($conn){
  if (isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
    //fetch users data
    $user= $conn->select("SELECT fullname, username, email FROM users WHERE userId = '$userId'");

    if($user){
      echo "<h1>Profile</h1>";
      echo "<h2>WELCOME TO YOUR PROFILE," . $user['fullname'] . "</h2>";
      echo "<p><strong>Username: </strong>" . $user['username'] . "</p>";
      echo "<p><strong>Email: </strong>" . $user['email'] . "</p>";
    } else {
      
      echo "<p>Sorry, user not found</p>";
    }
  } else {
    
    echo "<p>Sorry, you are not logged in</p>";
  }

  }
 }

