<?php
require 'vendor/autoload.php';

use Twilio\Rest\Client;

session_start();

// Twilio credentials
$sid = 'AC4146d30e648561ce9a5a339c0432c4d3';
$token = '95d3703e8e6cdd87e593add9495beb93';
$twilioNumber = '0125567800';
$userNumber = 'USER_PHONE_NUMBER'; // Replace with the user's phone number

// Generate a random OTP
$otp = rand(100000, 999999);

// Create a Twilio client
$twilio = new Client($sid, $token);

// Send the OTP
$message = $twilio->messages
                  ->create($userNumber, [
                      'from' => $twilioNumber,
                      'body' => "Your OTP is: $otp"
                  ]);

if ($message->sid) {
    $_SESSION['otp'] = $otp;
    echo "OTP sent successfully! Please check your phone.";
} else {
    echo "Failed to send OTP.";
}
?>
