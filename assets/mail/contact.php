<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Invalid request.');
}


/* ==============================
   GET FORM DATA
   ============================== */

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$code = trim($_POST['code'] ?? '');
$comments = trim($_POST['comments'] ?? '');

$serviceFor = trim($_POST['service_for'] ?? '');
$frequency = trim($_POST['frequency'] ?? '');

$services = $_POST['services'] ?? [];


/* ==============================
   VALIDATION
   ============================== */

if ($name === '') {
    exit('<div class="alert alert-danger">Please enter your name.</div>');
}

if ($email === '') {
    exit('<div class="alert alert-danger">Please enter your email address.</div>');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('<div class="alert alert-danger">Please enter a valid email address.</div>');
}

if ($phone === '') {
    exit('<div class="alert alert-danger">Please enter your phone number.</div>');
}

if ($code === '') {
    exit('<div class="alert alert-danger">Please enter your postal code.</div>');
}

if ($serviceFor === '') {
    exit('<div class="alert alert-danger">Please select Residential or Commercial.</div>');
}

if ($frequency === '') {
    exit('<div class="alert alert-danger">Please select a cleaning frequency.</div>');
}

if (empty($services)) {
    exit('<div class="alert alert-danger">Please select at least one service.</div>');
}


/* ==============================
   SERVICE TYPE
   ============================== */

if ($serviceFor === '1') {
    $serviceForText = 'Residential';
} elseif ($serviceFor === '2') {
    $serviceForText = 'Commercial';
} else {
    $serviceForText = 'Unknown';
}


/* ==============================
   CLEANING FREQUENCY
   ============================== */

$frequencyNames = [
    '1' => 'One-Time',
    '2' => 'Weekly',
    '3' => 'Bi-Weekly',
    '4' => 'Monthly',
    '5' => 'Quarterly'
];

$frequencyText = $frequencyNames[$frequency] ?? 'Unknown';


/* ==============================
   SERVICES
   ============================== */

$servicesText = implode(', ', $services);


/* ==============================
   EMAIL ADDRESS
   ============================== */

/*
 * CHANGE THIS EMAIL ADDRESS
 * to the email where you want
 * to receive quote requests.
 */

$address = "Info@yourdomain.com";


/* ==============================
   EMAIL SUBJECT
   ============================== */

$subject = "New Free Quote Request";


/* ==============================
   EMAIL MESSAGE
   ============================== */

$message  = "NEW FREE QUOTE REQUEST";
$message .= PHP_EOL . PHP_EOL;

$message .= "Name: " . $name . PHP_EOL;
$message .= "Email: " . $email . PHP_EOL;
$message .= "Phone: " . $phone . PHP_EOL;
$message .= "Postal Code: " . $code . PHP_EOL;

$message .= PHP_EOL;

$message .= "Service For: " . $serviceForText . PHP_EOL;
$message .= "Cleaning Frequency: " . $frequencyText . PHP_EOL;
$message .= "Services Requested: " . $servicesText . PHP_EOL;

$message .= PHP_EOL;

$message .= "Additional Details:" . PHP_EOL;

if ($comments !== '') {
    $message .= $comments . PHP_EOL;
} else {
    $message .= "No additional details provided." . PHP_EOL;
}

$message .= PHP_EOL;
$message .= "----------------------------------------" . PHP_EOL;
$message .= "Submitted from website quote form." . PHP_EOL;


/* ==============================
   EMAIL HEADERS
   ============================== */

$headers  = "From: Website Quote Form <" . $address . ">" . PHP_EOL;
$headers .= "Reply-To: " . $email . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-Type: text/plain; charset=UTF-8" . PHP_EOL;


/* ==============================
   SEND EMAIL
   ============================== */

if (mail($address, $subject, $message, $headers)) {

    echo '<div class="alert alert-success">';
    echo '<h3>Request Sent Successfully!</h3>';
    echo '<p>Thank you <strong>' . htmlspecialchars($name) . '</strong>, your quote request has been submitted.</p>';
    echo '</div>';

} else {

    echo '<div class="alert alert-danger">';
    echo '<h3>Unable to Send Request</h3>';
    echo '<p>Sorry, something went wrong while sending your request. Please try again.</p>';
    echo '</div>';
}

?>
