<?php

$errorMSG = "";

// NAME
if (empty($_POST["name"])) {
    $errorMSG = "Name is required ";
} else {
    $name = $_POST["name"];
}

// EMAIL
if (empty($_POST["email"])) {
    $errorMSG .= "Email is required ";
} else {
    $email = $_POST["email"];
}

// MESSAGE
if (empty($_POST["message"])) {
    $errorMSG .= "Message is required ";
} else {
    $message = $_POST["message"];
}

// Injection check
function IsInjected($str) {
    $injections = array('(\n+)',
        '(\r+)',
        '(\t+)',
        '(%0A+)',
        '(%0D+)',
        '(%08+)',
        '(%09+)'
        );
            
    $inject = join('|', $injections);
    $inject = "/$inject/i";
    
    if(preg_match($inject,$str))
    {
        return true;
    }
    else
    {
        return false;
    }
}

if(IsInjected($email)) {
    $errorMSG .= "Bad email value!";
}
if(IsInjected($subject)) {
    $errorMSG .= "Bad subject value!";
}
if(IsInjected($message)) {
    $errorMSG .= "Bad message value!";
}
if(IsInjected($name)) {
    $errorMSG .= "Bad name value!";
}


$EmailTo = "sachinnaidoo@hotmail.com";
$Subject = "Vortechs: New Customer Query"; 
// prepare email body text
$Body = "";
$Body .= "Name: ";
$Body .= $name;
$Body .= "\n";
$Body .= "Email: ";
$Body .= $email;
$Body .= "\n";
$Body .= "Subject: ";
$Body .= $subject;
$Body .= "\n";
$Body .= "Message: ";
$Body .= $message;
$Body .= "\n";

// send email
$success = mail($EmailTo, $subject, $Body, "From:".$email);

// redirect to success page
if ($success && $errorMSG == ""){
   echo "success";
}else{
    if($errorMSG == ""){
        echo "Something went wrong";
    } else {
        echo $errorMSG;
    }
}

?>