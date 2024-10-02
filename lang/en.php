<?php
$conf['site_url']="http://localhost/BootstrapAPI";
/* Email Messages Templates */
/* Subjects Templates */
$lang["AccountVerification"]="Welcome to{{site_full_name}}! Account Verification";

/* Body Templates */
// Account Registration Verification
$lang["AccRegVer_template"]="
Hello {{fulname}},

You requested an account on {{site_full_name}}.

In order to use this account you need to <a href= '" . $conf['site_url'] . "/ges/verify?tok={{unlock_token_pass}}'>Click Here</a> to complete the registration process.

Or use unique code <p><b> {{unlock_token_pass}} </b></p> to verify your account.

Regards,
Systems Administrator
{{site_full_name}}
";