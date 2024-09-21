<?php
class signup_form{

public function sign_up_form(){
        ?>
        <body>
        <div class="row align-items-md-stretch">
            <div class="col-md-6">
                <div class="h-100 p-5 text-bg-dark rounded-3"> 
                    <h2>Sign Up Form</h2>
                    <form action="<?php print basename($_SERVER["PHP_SELF"]); ?>" method="post" enctype="miltipart/form-data"> 

                    <div class="mb-3"> 
                        <label for="fullname">Full Name:</label><br>
                        <input type="text" id="fullname" name="fullname" required><br><br>
                    </div>

                    <div class="mb-3">
                        <label for="username">Username:</label><br>
                        <input type="text" id="username" name="username" required><br><br>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email" required><br><br>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>	

                
                    </form>  
                </div>
            </div>
        </div>
        
        </body>
        <?php
    }
}