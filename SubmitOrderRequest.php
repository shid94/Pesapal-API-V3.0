<?php
include 'RegisterIPN.php';
$merchantreference = rand(1, 1000000000000000000);
$phone = "075889083";
$amount = 20.00;
$callbackurl = "https://d317-102-217-57-4.ngrok-free.app/pesapal/response-page.php";
$branch = "Infinity i3c";
$first_name = "Rashid";
$middle_name = "Migadde";
$last_name = "shid";
$email_address = "rmigadde@i3c.co.ug";
if(APP_ENVIROMENT == 'sandbox'){
  $submitOrderUrl = "https://cybqa.pesapal.com/pesapalv3/api/Transactions/SubmitOrderRequest";
}elseif(APP_ENVIROMENT == 'live'){
  $submitOrderUrl = "https://pay.pesapal.com/v3/api/Transactions/SubmitOrderRequest";
}else{
  echo "Invalid APP_ENVIROMENT";
  exit;
}
$headers = array(
    "Accept: application/json",
    "Content-Type: application/json",
    "Authorization: Bearer $token"
);

// Request payload
$data = array(
    "id" => "$merchantreference",
    "currency" => "UGX",
    "amount" => $amount,
    "description" => "Payment description goes here",
    "callback_url" => "$callbackurl",
    "notification_id" => "$ipn_id",
    "branch" => "$branch",
    "billing_address" => array(
        "email_address" => "$email_address",
        "phone_number" => "$phone",
        "country_code" => "UG",
        "first_name" => "$first_name",
        "middle_name" => "$middle_name",
        "last_name" => "$last_name",
        "line_1" => "Pesapal Limited",
        "line_2" => "",
        "city" => "",
        "state" => "",
        "postal_code" => "",
        "zip_code" => ""
    )
);
$ch = curl_init($submitOrderUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
$data = json_decode($response);
$redirect_url = $data->redirect_url;
// echo "<a href='$redirect_url'>Pay</a>";
echo "<script>window.location.href='$redirect_url'</script>";