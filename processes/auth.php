<?php
class auth{

    public function bind_to_template($replacements, $template){
        return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements){
            return $replacements[$matches[1]];
        }, $template);
    }



    public function signup($conn, $ObjGlob, $lang, $ObjSendMail, $conf){
        if (isset($_POST['submit'])) {

            $errors = array();
            $fullname = $_SESSION['fullname'] = $conn->escape_values(ucwords(strtolower($_POST['fullname'])));
            $username = $_SESSION['username']= $conn->escape_values(strtolower($_POST['username']));
            $email = $_SESSION['email'] = $conn->escape_values(strtolower($_POST['email']));
            


// Implement input validation and error handling
// =============================================
// Sanitize all inputs
// verify that the fullname has only letters, space, dash, quotation
if(ctype_alpha(str_replace("","", str_replace("\'", "", $fullname))) === FALSE){
    $errors['nameLetters_err'] = "Invalid name format: Fullname should only contain letters, spaces, dashes and quotes" . $fullname;
}
// verify that the email has got the correct format
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email_format_err'] = "Invalid email format: " . $email;
}
// verify that the email domain is authorized (@strathmore.edu, @gmail.com, @yahoo.com, @mada.co.ke) and not (@yanky.net)
$conf['valid_domains']=["@strathmore.edu", "@gmail.com", "@yahoo.com", "@mada.co.ke", "@mada.co.ke","@outlook.com", "@STRATHMORE.EDU","@GMAIL.COM", "@YAHOO.COM", "@MADA.CO.KE", "@OUTLOOK.COM"];

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
if(!count($errors)){
    $cols = array('fullname', 'username', 'email','ver-code', 'ver_code-time' );
    $vals = array($fullname, $username, $email, $conf['verification_code'],$conf['verification_code_time']);
    $data= array_combine($cols, $vals);
    $insert = $conn->insert('users', $data);

    if ($insert === TRUE){
        $replacements = array('fullname'=> $fullname,'email'=>$email, 'verification_code' => $conf['verification_code'], 'site_full_name' => strtoupper($conf['site_initials']));

        $ObjSendMail->SendMail($mail, [
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

public function verify_code($conn, $ObjGlob, $lang, $ObjSendMail, $conf){
    if (isset($_POST["verify_code"])){
        $errors = array();

        $ver_code= $_SESSION["ver_code"]=$conn->escape_values($_POST["ver_code"]);
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





$verification_code = rand(100000, 999999);
$msg['verify_code_sbj'] = 'Verify Code ICS';
$msg['verify_code_msg'] = "Your verification code is:  .<p><b>" . $verification_code. "</b></p>";

$_SESSION['mailMsg']= ["to_name" => $fullname, "to_email" => $email];
$conf['site_initials'] = 'ICS 2024';
$conf['site_url'] = "http://localhost/BootstrapAPI";

if(isset($_SESSION['mailMsg'])){
    if(is_array($_SESSION['mailMsg'])){
        $mailMsg = $_SESSION['mailMsg'];
        $replacements = array('fullname'=> $_SESSION['mailMsg']['to_name'],'email'=>$_SESSION['mailMsg']['to_email'], 'unlock_token_pass' => $verification_code, 'site_full_name' => strtoupper($conf['site_initials']));

        $ObjSendMail->SendMail($mail, [
            'to_name'=> $mailMsg['to_name'],
            'to_email'=> $mailMsg['to_email'],
            'subject'=> $this->bind_to_template($replacements, $lang['AccountVerification']),
            'message'=> $this->bind_to_template($replacements, $lang['AccRegVer_template'])
        ]);
    }
}






// Verify that the password is identical to the repeat passsword
// verify that the password length is between 4 and 8 characters
if(!count($errors)){
        $cols = array('fullname', 'username', 'email');
        $vals = array($fullname, $username, $email);

        $data= array_combine($cols, $vals);
        $insert = $conn->insert('users', $data);

        if ($insert === TRUE){
            header('Location: signup.php');
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
}