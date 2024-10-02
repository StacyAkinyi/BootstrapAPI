<?php
class signup_form{

public function sign_up_form($ObjGlob){
        ?>
        
        <div class="row align-items-md-stretch">
            <div class="col-md-6">
                <div class="h-100 p-5 text-bg-dark rounded-3"> 
                    <h2>Sign Up Form</h2>
                    <?php
                    print $ObjGlob->getMsg('msg');
                    $err = $ObjGlob->getMsg('errors');
                    ?>
                    <form action="<?php print basename($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"> 

                    <div class="mb-3"> 
                        <label for="fullname" class="form-label">Full Name:</label>
                        <input type="text" id="fullname" name="fullname" class="form-control form-control-lg" maxlength="50" placeholder="Enter your name..." <?php print(isset($_SESSION["fullname"]))? 'value"' . $_SESSION["fullname"]. '"' : ''; unset($_SESSION["fullname"]); ?> >

                        <?php print (isset($err['nameLetters_err']))? "<span class='invalid'>" . $err['nameLetters_err'] . "</span>" : ''; ?>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" id="username" name="username" class="form-control form-control-lg" maxlength="50" placeholder="Enter your username..." <?php print(isset($_SESSION["username"]))? 'value"' . $_SESSION["username"]. '"' : ''; unset($_SESSION["username"]); ?> >
                        <?php print (isset($err['usernameExists_err']))? '<span class="invalid">' . $err['usernameExists_err'] . '</span>' : ''; ?>
                        <?php print (isset($err['usernameLetters_err']))? '<span class="invalid">' . $err['usernameLetters_err'] . '</span>' : ''; ?>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label><br>
                        <input type="email" id="email" name="email" class="form-control form-control-lg" maxlength="50" placeholder="Enter your email adrress..." <?php print(isset($_SESSION["email"]))? 'value"' . $_SESSION["email"]. '"' : ''; unset($_SESSION["email"]); ?> >
                        <?php print (isset($err['email_format_err']))? '<span class="invalid">' . $err['email_format_err'] . '</span>' : ''; ?>
                        <?php print (isset($err['mailExists_err']))? '<span class="invalid">' . $err['mailExists_err'] . '</span>' : ''; ?>
                        <?php print (isset($err['mailDomain_err']))? '<span class="invalid">' . $err['mailDomain_err'] . '</span>' : ''; ?>
                    </div>
                    <button type="submit" name="signup" class="btn btn-primary">Submit</button>	

                
                    </form>  
                </div>
            </div>
        
        
        <?php
    }
}