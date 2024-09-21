<?php
class contents{
    public function about_content(){
        ?>
        <div class="row">
            <div class="content">
                <h1>About Us</h1>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

    </div>
        <?php
    }
    public function side_bar(){
        ?>
        <div class="side_bar">
            <h1>Side Bar</h1>
            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.

The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
    </div>
    </div>

        <?php
    }
 
    public function signup_form(){
        ?>
        <head>
            
            <link rel = "stylesheet" href="css\signup.css"/>
        </head>
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
        <?php
    }
}
?>