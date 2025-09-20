<?php $pagetitle = "Verify your email"; ?>
<?php require_once('../loaders/header.php'); ?>
<?php require_once('../php_classes/account_class.php'); ?>
<body onload='pageObj = new CurrentPage([], "../php_requests/verify_email.php"); updateCssSize();'>
<?php
    $params = array();
    if(isset($_SESSION['temp_id'])){
        $params['account_id'] = $_SESSION['temp_id'];
    }
    $account1 = new Account($params);
    $result = $account1->loadAccount();
    if($result){
        if($account1->account_type == 2){
            header('../blogdaily/search.php');
        }
        $email = $account1->email;
        $code = $account1->email_code;

        $result = "Results: ";
        $subject = "Verification code";
        $body = "Your verification code is: " . $code;
        $header = false;

        if($email && $subject && $body){
            $header = "From: " . $email;
            
            if (mail($email, $subject, $body, $header)) {
                $result = "Email was successfully sent.";
            }
        }
        $result .= ( ($email) ? " The Email used was " . $email : " No Email on record. " );

    }
    else{
        header('../blogdaily/login.php');
    }
?>
<?php require_once('../loaders/nav_left.php'); ?>
<?php require_once('../loaders/main_top.php'); ?>

<form>
    <div class="inputrow">
        <label><?php echo $result; ?></label>
    </div>
    <div class="linebreak"></div>
    <div class="linebreak"></div>
    <div class="inputrow">
        <label class="labelinput textright">Verification code</label>
        <input name="email_code" type="text" class="createbloginput form_input" required></input>
        <label id="error_email_code" class="labelerror"></label>
    </div>
</form>
<div><button  class="gen_button floatright" onclick="sendForm()">Sign up</button></div>

<?php require_once('../loaders/main_bottom.php'); ?>
</body>
</html>