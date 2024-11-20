<?php

class auth{


    public function bind_to_template($replacements, $template){
        return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements){
            return $replacements[$matches[1]];
        }, $template);
    }



    public function signup($conn, $ObjGlob, $ObjSendMail, $lang, $conf){
        if (isset($_POST["signup"])) {

            $errors = array();
            $fullname = $_SESSION['fullname'] = $conn->escape_values(ucwords(strtolower($_POST['fullname'])));
            $username = $_SESSION['username']= $conn->escape_values(strtolower($_POST['username']));
            $email = $_SESSION['email'] = $conn->escape_values(strtolower($_POST['email']));
            


// Implement input validation and error handling
// =============================================
// Sanitize all inputs
// verify that the fullname has only letters, space, dash, quotation

//if(ctype_alpha(str_replace("","", str_replace("\'", "", $fullname))) === FALSE){
  //  $errors['nameLetters_err'] = "Invalid name format: Fullname should only contain letters, spaces, dashes and quotes" . $fullname;
//} 

// verify that the email has got the correct format
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email_format_err'] = "Invalid email format: " ;
}
// verify that the email domain is authorized (@strathmore.edu, @gmail.com, @yahoo.com, @mada.co.ke) and not (@yanky.net)
$conf['valid_domains']=["strathmore.edu", "gmail.com", "yahoo.com", "mada.co.ke", "mada.co.ke","outlook.com", "STRATHMORE.EDU","GMAIL.COM", "YAHOO.COM", "MADA.CO.KE", "OUTLOOK.COM"];

$arr_email = explode("@", $email);
$spot_dom = end($arr_email);
$spot_user= reset($arr_email);

if(!in_array($spot_dom, $conf['valid_domains'])){
    $errors['mailDomain_err'] = "Invalid email domain. Use only: " . implode(", ", $conf['valid_domains']);
}
$exist_count = 0;
// verify if the email alredy exists in the database
$spot_email_res= $conn-> count_results(sprintf("SELECT email FROM users WHERE email = '%s' LIMIT 1", $email));
// die($spot_email_res)
if($spot_email_res > $exist_count){
    $errors['mailExists_err'] = "Email already exists: " ;
}
// verify if the username alredy exists in the database
$spot_username_res= $conn-> count_results(sprintf("SELECT username FROM users WHERE username = '%s' LIMIT 1", $username));
if($spot_username_res > $exist_count){
    $errors['usernameExists_err'] = "Username already exists: " ;
}

//Verify that username contains letters only
if(ctype_alpha($username) === FALSE){
    $errors['usernameLetters_err'] = "Invalid username format: Username should only contain letters" . $username;
    $ObjGlob->setMsg('errors', $errors, 'invalid');
}
// Implement 2FA (email => PHP-Mailer)
// ===================================
// Send email verification with an OTP (OTC)


// Verify that the password is identical to the repeat passsword
// verify that the password length is between 4 and 8 characters
if(!count($errors)){
    $cols = array('fullname', 'username', 'email','ver_code', 'ver_code_time' );
    $vals = array($fullname, $username, $email, $conf['verification_code'],$conf['ver_code_time']);
    $data= array_combine($cols, $vals);
    $insert = $conn->insert('users', $data);

    if ($insert === TRUE){
        $replacements = array('fullname'=> $fullname,'email'=>$email, 'verification_code' => $conf['verification_code'], 'site_full_name' => strtoupper($conf['site_initials']));

        $ObjSendMail->sendMail( [
            'to_name'=> $fullname,
            'to_email'=> $email,
            'subject'=> $this->bind_to_template($replacements, $lang['AccountVerification']),
            'message'=> $this->bind_to_template($replacements, $lang['AccRegVer_template'])
        ]);
        header('Location: verify_code.php');
        unset($_SESSION["fullname"], $_SESSION["username"], $_SESSION["email"]);
        exit();
    }else{
        die($insert);
    }

    }else{
        $ObjGlob->setMsg('msg', 'Error(s)', 'invalid');
        $ObjGlob->setMsg('errors', $errors, 'invalid');
    }
}
}

public function verify_code($conn, $ObjGlob, $ObjSendMail, $lang, $conf){
    if (isset($_POST["verify_code"])){
        $errors = array();

        $ver_code= $_SESSION["ver_code"]= $conn->escape_values($_POST["ver_code"]);
        if (!is_numeric($ver_code)){
            $errors['not_numeric'] = "Invalid code format. Verification code must contain numbers only " ;
        }
        if(strlen($ver_code) !== 6){
            $errors['code_length'] = "Invalid code length. Verification code must contain 6 numbers only " ;

        }
        $spot_ver_code_res = $conn->count_results(sprintf("SELECT ver_code FROM users WHERE ver_code = '%d' LIMIT 1", $ver_code));

        if ($spot_ver_code_res === 0){
            $errors['ver_code_not-exist'] = "Invalid code. Verification code not found " ;
        }else{
            $spot_ver_time_res = $conn->count_results(sprintf("SELECT ver_code, ver_code_time FROM users WHERE ver_code = '%d' AND ver_code_time > now() LIMIT 1", $ver_code));
            if ($spot_ver_time_res === 0){
                $errors['ver_code_expired'] = "Invalid code. Verification code has expired " ;
            }
        }
        if (!count($errors)){
            $_SESSION['code_verified'] = $ver_code;
            header('Location: create_password.php');

        }else{
            $ObjGlob->setMsg('msg', 'Error(s)', 'invalid');
            $ObjGlob->setMsg('errors', $errors, 'invalid');
    }
}
}
public function create_password($conn, $ObjGlob, $ObjSendMail, $lang, $conf){
    if (isset($_POST["create_password"])){
        $errors = array();
        $password = $_SESSION['password']= $conn->escape_values($_POST['password']);
        $repeat_password = $_SESSION['repeat_password']= $conn->escape_values($_POST['repeat_password']);
        

        if (strlen($password) <8){
            $errors['password_length'] = "Password length must be at least 8 characters " ;
        }
        if ($password !== $repeat_password){
            $errors['password_match'] = "Passwords do not match " ;
        }
        
        if (!count($errors)){

            $password = password_hash($repeat_password, PASSWORD_DEFAULT);

            $cols = ['password', 'ver_code', 'ver_code_time'];
            $vals = [$password, 0, $conf['ver_code_timeout']];
            $where = ['ver_code' => $_SESSION['code_verified']];

            $data = array_combine($cols, $vals);
            $insert_passphrase = $conn->update('users', $data, $where);
            if($insert_passphrase === TRUE){
                unset($_SESSION['code_verified']);
                header('Location: signin.php');
            }else{
                die($insert_passphrase);
            }
        }else{
            $ObjGlob->setMsg('msg', 'Error(s)', 'invalid');
            $ObjGlob->setMsg('errors', $errors, 'invalid');
        }
    }
}public function signin($conn, $ObjGlob, $ObjSendMail, $lang, $conf){
    if(isset($_POST["signin"])){

        $errors = array();
        $username = $_SESSION["username"] = $conn->escape_values(strtolower($_POST["username"]));
        $entered_password = $_SESSION["password"] = $conn->escape_values($_POST["password"]);
        
        // Verify Username Exists
        $signin_query = (sprintf("SELECT * FROM users WHERE username = '%s' OR email = '%s' LIMIT 1", $username, $username));

        // Counting results
        $spot_username_res = $conn->count_results($signin_query);
        if ($spot_username_res == 0){
            $errors['usernamenot_err'] = "Username does not Exists";
        }else{
            // Executing the select query & Create a session.
            $_SESSION["consort_tmp"] = $conn->select($signin_query);

            // Use the session to fetch the stored password.
            $stored_password = $_SESSION["consort_tmp"]["password"];

            // Verify the password is correct
            if(password_verify($entered_password, $stored_password)){
                // Create the login session
                $_SESSION["consort"] = $_SESSION["consort_tmp"];
            }else{
                unset($_SESSION["consort_tmp"]);
                $errors['invalid_u_p'] = "Invalid username or password"; 
            }
        }

        if(!count($errors)){
            header('Location: dashboard.php');
            exit();
        }else{
            $ObjGlob->setMsg('msg', 'Error(s)', 'invalid');
            $ObjGlob->setMsg('errors', $errors, 'invalid');
        }
    }
}
public function signout($conn, $ObjGlob, $ObjSendMail, $lang, $conf){
    if(isset($_GET["signout"])){
        unset($_SESSION['consort']);
        header('Location: '.  $conf['site_url']);
        exit();
    }
}
public function save_details($conn, $ObjGlob, $ObjSendMail, $lang, $conf){
    if(isset($_POST["save_details"])){
        $errors = array();
        $genderId = $_SESSION["genderId"] = $conn->escape_values($_POST["genderId"]);
        $roleId = $_SESSION["roleId"] = $conn->escape_values($_POST["roleId"]);

        if(empty($genderId) || empty($roleId)){
            $errors['invalid_selection'] = "Invalid selectionSomething missing"; 
        }
        if(!count($errors)){
            $cols = ['genderId', 'roleId'];
            $vals = [$genderId, $roleId];
            $where = ['userId' => $_SESSION['consort']['userId']];

            $data = array_combine($cols, $vals);
            $complete_reg = $conn->update('users', $data, $where);
            if($complete_reg === TRUE){
                $_SESSION["consort"]["genderId"] = $genderId;
                $_SESSION["consort"]["roleId"] = $roleId;
                header('Location: dashboard.php');
                exit();
            }
        }else{
            $ObjGlob->setMsg('msg', 'Error(s)', 'invalid');
            $ObjGlob->setMsg('errors', $errors, 'invalid');
        }

    }
}
public function update_profile($conn, $ObjGlob, $ObjSendMail, $lang, $conf){
    if(isset($_POST["update_profile"])){
        $errors = array();

        $fullname = $_SESSION["fullname"] = $conn->escape_values(ucwords(strtolower($_POST["fullname"])));
        $email_address = $_SESSION["email_address"] = $conn->escape_values(strtolower($_POST["email_address"]));
        $username = $_SESSION["username"] = $conn->escape_values(strtolower($_POST["username"]));




        $genderId = $_SESSION["genderId"] = $conn->escape_values($_POST["genderId"]);
    }
}
}
?>