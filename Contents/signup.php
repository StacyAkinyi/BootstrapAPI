<?php
class signup{

public function signup_form(){
        ?>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Signup</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        </head>
        <body>
        <div class="container">
            <form action="sql_signup.php" method="post"> 
                <div class="form-group"> 
                    <h2>Sign-Up Form</h2>

                    <div class="signup"> 
                        <label for="fullname">Full Name:</label><br>
                        <input type="text" id="fullname" name="fullname" required><br><br>
                    </div>

                    <div class="signup">
                        <label for="username">Username:</label><br>
                        <input type="text" id="username" name="username" required><br><br>
                    </div>

                    <div class="signup">
                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email" required><br><br>
                    </div>

                    <div class="signup">
                        <label for="password">Password:</label><br> 
                        <input type="password" id="password" name="password" required><br><br>
                    </div>

                    <div class="signup">
                        <input type="submit" value="Submit">
                    </div>

                </div> 
            </form>  
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        </body>
        <?php
    }
}