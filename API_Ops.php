<?php
// api_ops.php

define('API_URL', 'https://whatsapp-number-validator.p.rapidapi.com/validate'); 
define('API_KEY', '80f0f5308emsh8577ecdc8793bdep1d8508jsn0190a7fdf5c'); 

function validateWhatsAppNumber($phoneNumber)
{
    if (empty($phoneNumber) || !preg_match('/^[0-9]{10,15}$/', $phoneNumber)) { 
        return ["status" => false, "message" => "Invalid WhatsApp number format. Make sure it is correct."];
    }

    $response = callWhatsAppAPI($phoneNumber);
    
    if ($response) {
        if ($response['valid']) {
            return ["status" => true, "message" => "Valid WhatsApp number."];
        } else {
            return ["status" => false, "message" => "Invalid WhatsApp number according to the API."];
        }
    } else {
        return ["status" => false, "message" => "API error or invalid response."];
    }
}

function callWhatsAppAPI($phoneNumber)
{
    $countryCode = '+2'; 
    $formattedNumber = $countryCode . $phoneNumber;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, API_URL); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['phone_number' => $formattedNumber]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-RapidAPI-Key: ' . API_KEY, 
        'X-RapidAPI-Host: whatsapp-number-validator.p.rapidapi.com',
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_message = curl_error($ch);
        curl_close($ch);
        return null;  
    }

    curl_close($ch);

    if ($response === false) {
        return null;
    }

    return json_decode($response, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['phone_number'])) {
        $phoneNumber = $_POST['phone_number'];
        $result = validateWhatsAppNumber($phoneNumber);
        echo json_encode($result);
    } else {
        echo json_encode(["status" => false, "message" => "No phone number provided."]);
    }
}
?>
