<?php
class auth{
    public function signup($conn){
        if (isset($_POST['submit'])) {

            $errors = array();
            $fullname = $_POST['fullname'] = $conn->escape_values(ucwords(strtolower($_POST['fullname'])));
            $username = $_POST['username']= $conn->escape_values(strtolower($_POST['username']));
            $email = $_POST['email'] = $conn->escape_values(strtolower($_POST['email']));
            


// Implement input validation and error handling
// =============================================
// Sanitize all inputs
// verify that the fullname has only letters, space, dash, quotation
if(ctype_alpha(str_replace("","", strt_replace("\'", "", $fullname))) === FALSE){
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
        $cols = array('fullname', 'username', 'email');
        $vals = array($fullname, $username, $email);

        $data= array_combine($cols, $vals);
        $insert = $conn->insert('users', $data);

        if ($insert === TRUE){
            header('Location: signup.php');
            unset($_SESSION["fullname"], $_SESSION["email"], $_SESSION["username"]);
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