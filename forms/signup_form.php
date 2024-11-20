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
        </div>
        
        <?php
    } public function verify_code_form($ObjGlob){
        ?>
        <div class="row align-items-md-stretch">
            <div class="col-md-6">
                <div class="h-100 p-5 text-bg-dark rounded-3"> 
                    <h2>Verify Code</h2>
                    <?php
                    print $ObjGlob->getMsg('msg');
                    $err = $ObjGlob->getMsg('errors');
                    ?>
                    <form action="<?php print basename($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"> 

                    <div class="mb-3"> 
                        <label for="verify" class="form-label">Verification Code:</label>
                        <input type="number" id="ver_code" name="ver_code" class="form-control form-control-lg" maxlength="6" min="100000" max="999999" placeholder="Enter your verification code..." <?php print(isset($_SESSION["ver_code"]))? 'value"' . $_SESSION["ver_code"]. '"' : ''; unset($_SESSION["ver_code"]); ?> >
                        <?php print (isset($err['not_numeric']))? "<span class='invalid'>" . $err['not_numeric'] . "</span>" : ''; ?>
                        <?php print (isset($err['length_err']))? "<span class='invalid'>" . $err['length_err'] . "</span>" : ''; ?>
                        <?php print (isset($err['ver_code_not_exist']))? "<span class='invalid'>" . $err['ver_code_not_exist'] . "</span>" : ''; ?>
                        <?php print (isset($err['ver_code_expired']))? "<span class='invalid'>" . $err['ver_code_expired'] . "</span>" : ''; ?>
                    </div>
                    <button type="submit" name="verify_code" class="btn btn-primary">Verify</button>	
                    <form>
                </div>
            </div>
        </div>


    <?php                    
    }public function create_password_form($ObjGlob, $conn){
        ?>
        <div class="row align-items-md-stretch">
            <div class="col-md-6">
                <div class="h-100 p-5 text-bg-dark rounded-3"> 
                    <h2>Set Password</h2>
                    <?php
                    print $ObjGlob->getMsg('msg');
                    $err = $ObjGlob->getMsg('errors');
                    ?>
                    <form action="<?php print basename($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"> 

                    <div class="mb-3"> 
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg" maxlength="50" placeholder="Enter your password..." <?php print(isset($_SESSION["password"]))? 'value"' . $_SESSION["password"]. '"' : ''; unset($_SESSION["password"]); ?> >
                        <?php print (isset($err['passwordLength_err']))? "<span class='invalid'>" . $err['passwordLength_err'] . "</span>" : ''; ?>
                        <?php print (isset($err['passwordMatch_err']))? "<span class='invalid'>" . $err['passwordMatch_err'] . "</span>" : ''; ?>
                    </div>

                    <div class="mb-3"> 
                        <label for="repeat_password" class="form-label">Repeat Password:</label>
                        <input type="password" id="repeat_password" name="repeat_password" class="form-control form-control-lg" maxlength="50" placeholder="Repeat your password..." <?php print(isset($_SESSION["repeat_password"]))? 'value"' . $_SESSION["repeat_password"]. '"' : ''; unset($_SESSION["repeat_password"]); ?> >
                    </div>
                    <button type="submit" name="create_password" class="btn btn-primary">Set Password</button>	
                    <form>
                </div>
            </div>
        </div>
    <?php
    } 
    public function sign_in_form($ObjGlob){
        ?>
              <div class="row align-items-md-stretch">
                <div class="col-md-9">
                  <div class="h-100 p-5 text-bg-dark rounded-3">
                    <h2>Sign In</h2>
                    <?php
                    print $ObjGlob->getMsg('msg');
                    $err = $ObjGlob->getMsg('errors');
                    ?>
                    <form action="<?php print basename($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                        <label for="username" class="form-label">Enter your username:</label>
                            <input type="text" name="username" class="form-control form-control-lg" id="username" maxlength="50" placeholder="Enter your username/email" <?php print (isset($_SESSION["username"])) ? 'value="'.$_SESSION["username"].'"'  : ''; unset($_SESSION["username"]); ?> >
                            <?php print (isset($err['usernamenot_err'])) ? "<span class='invalid'>" . $err['usernamenot_err'] . "</span>" : '' ; ?>
                            <?php print (isset($err['invalid_u_p'])) ? "<span class='invalid'>" . $err['invalid_u_p'] . "</span>" : '' ; ?>
                          </div>
                          <div class="mb-3">
                          <label for="password" class="form-label">Enter your password:</label>
                          <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Enter your password" <?php print (isset($_SESSION["password"])) ? 'value="'.$_SESSION["password"].'"'  : ''; unset($_SESSION["password"]); ?> >
                            <?php print (isset($err['invalid_u_p'])) ? "<span class='invalid'>" . $err['invalid_u_p'] . "</span>" : '' ; ?>
                          </div>
                          <button type="submit" name="signin" class="btn btn-primary">Sign In</button>
                        </form>
                      </div>
                    </div>
                    <?php
            }
            public function complete_reg_form($ObjGlob, $conn){
                ?>
      <div class="row align-items-md-stretch">
        <div class="col-md-9">
          <div class="h-100 p-5 text-bg-dark rounded-3">
            <h2>Complete Registration</h2>
            <?php
                print $ObjGlob->getMsg('msg');
                $err = $ObjGlob->getMsg('errors');
                ?>
                <form action="<?php print basename($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                  <div class="mb-3">
                    <label for="genderId" class="form-label">Gender:</label>
                    <select name="genderId" id="genderId" class="form-control form-control-lg" required>
                      <option value="">--Select Gender--</option>
                      <?php
                        $spot_gender_rows = $conn->select_while("SELECT * FROM gender");
                        foreach($spot_gender_rows AS $spot_gender_values){
                          ?>
                        <option value="<?php print $spot_gender_values["genderId"]; ?>"><?php print $spot_gender_values["gender"]; ?></option>
                        <?php } ?>
                      </select>
                      <?php print (isset($err['invalid_selection'])) ? "<span class='invalid'>" . $err['invalid_selection'] . "</span>" : '' ; ?>
                    </div>
                    <div class="mb-3">
                      <label for="roleId" class="form-label">Role:</label>
                      <select name="roleId" id="roleId" class="form-control form-control-lg"  required>
                        <option value="">--Select Role--</option>
                        <?php
                            $spot_role_rows = $conn->select_while("SELECT * FROM roles");
                            foreach($spot_role_rows AS $spot_role_values){
                              if($spot_role_values["roleId"] == 1) { continue; }
                              ?>
                            <option value="<?php print $spot_role_values["roleId"]; ?>"><?php print $spot_role_values["role"]; ?></option>
                            <?php } ?>
                          </select>
                          <?php print (isset($err['invalid_selection'])) ? "<span class='invalid'>" . $err['invalid_selection'] . "</span>" : '' ; ?>
                        </div>
                        <button type="submit" name="save_details" class="btn btn-primary">Save Details</button>
                      </form>
                    </div>
                  </div>
        <?php
       }          public function profile_form($ObjGlob, $conn){
                ?>
      <div class="row align-items-md-stretch">
        <div class="col-md-9">
          <div class="h-100 p-5 text-bg-dark rounded-3">
            <h2>Update Profile</h2>
            <?php
                print $ObjGlob->getMsg('msg');
                $err = $ObjGlob->getMsg('errors');
    
    $spot_profile = $conn->select(sprintf("SELECT users.userId, users.fullname, users.email, users.username, users.genderId, users.roleId, gender.gender, roles.role FROM users LEFT JOIN gender USING(genderId) LEFT JOIN roles USING(roleId) WHERE users.userId = '%d' LIMIT 1", $_SESSION['consort']['userId']));
    
                ?>
                <form action="<?php print basename($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                        <label for="fullname" class="form-label">Fullname:</label>
                        <input type="text" name="fullname" class="form-control form-control-lg" maxlength="50" id="fullname" placeholder="Enter your name" value="<?php print $spot_profile["fullname"]; ?>">
                        <?php print (isset($err['nameLetters_err'])) ? "<span class='invalid'>" . $err['nameLetters_err'] . "</span>" : '' ; ?>
                    </div>
                    <div class="mb-3">
                        <label for="email_address" class="form-label">Email Address:</label>
                        <input type="email" name="email_address" class="form-control form-control-lg" maxlength="50" id="email_address" placeholder="Enter your email address" value="<?php print $spot_profile["email"]; ?>">
    
                        <?php print (isset($err['email_format_err'])) ? "<span class='invalid'>" . $err['email_format_err'] . "</span>" : '' ; ?>
                        <?php print (isset($err['mailExists_err'])) ? "<span class='invalid'>" . $err['mailExists_err'] . "</span>" : '' ; ?>
                        <?php print (isset($err['mailDomain_err'])) ? "<span class='invalid'>" . $err['mailDomain_err'] . "</span>" : '' ; ?>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" name="username" class="form-control form-control-lg" maxlength="50" id="username" placeholder="Enter your username" value="<?php print $spot_profile["username"]; ?>" >
                        <?php print (isset($err['usernameExists_err'])) ? "<span class='invalid'>" . $err['usernameExists_err'] . "</span>" : '' ; ?>
                        <?php print (isset($err['usernameLetters_err'])) ? "<span class='invalid'>" . $err['usernameLetters_err'] . "</span>" : '' ; ?>
                    </div>
                  <div class="mb-3">
                    <label for="genderId" class="form-label">Gender:</label>
                    <select name="genderId" id="genderId" class="form-control form-control-lg" required>
                      <option value="<?php print $spot_profile["genderId"]; ?>"><?php print $spot_profile["gender"]; ?></option>
                      <?php
                        $spot_gender_rows = $conn->select_while("SELECT * FROM gender");
                        foreach($spot_gender_rows AS $spot_gender_values){
                          if($spot_gender_values["genderId"] == $spot_profile["genderId"]){continue;}
                          ?>
                        <option value="<?php print $spot_gender_values["genderId"]; ?>"><?php print $spot_gender_values["gender"]; ?></option>
                        <?php } ?>
                      </select>
                      <?php print (isset($err['invalid_selection'])) ? "<span class='invalid'>" . $err['invalid_selection'] . "</span>" : '' ; ?>
                    </div>
                    <div class="mb-3">
                      <label for="roleId" class="form-label">Role:</label>
                      <select name="roleId" id="roleId" class="form-control form-control-lg"  required>
                      <option value="<?php print $spot_profile["roleId"]; ?>"><?php print $spot_profile["role"]; ?></option>
                        <?php
                            $spot_role_rows = $conn->select_while("SELECT * FROM roles");
                            foreach($spot_role_rows AS $spot_role_values){
                              if($spot_role_values["roleId"] == 1 || $spot_role_values["roleId"] == $spot_profile["roleId"]) { continue; }
                              ?>
                            <option value="<?php print $spot_role_values["roleId"]; ?>"><?php print $spot_role_values["role"]; ?></option>
                            <?php } ?>
                          </select>
                          <?php print (isset($err['invalid_selection'])) ? "<span class='invalid'>" . $err['invalid_selection'] . "</span>" : '' ; ?>
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                      </form>
                    </div>
                  </div>
        <?php
       }
        
  
}