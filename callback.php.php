<?php
header("Content-Type: application/json");
$pinCallbackData = file_get_contents('php://input');
$logFile = "PINURLcallback.json";
$log = fopen($logFile, "a");
$log = fwrite($log, $pinCallbackData);
fclose($log);
