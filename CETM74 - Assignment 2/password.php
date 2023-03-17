<?php
$davidpass = "heretohelp!456";
$katypass = "letmein!123";
$encrypt_davidpass = password_hash($davidpass , PASSWORD_DEFAULT);
$encrypt_katypass = password_hash($katypass, PASSWORD_DEFAULT);
echo "David's encrypted password is: ".$encrypt_davidpass."<br/>";
echo "Katy's encrypted password is: $encrypt_katypass";
?>