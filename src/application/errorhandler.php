<?php

ini_set('display_errors', 1);

function customErrorHandler(int $errNo, string $errMsg, string $file, int $line)
{
    $errMsg = $errNo . "\n" . $file . "\n" . $line . "\n" . $errMsg . "\n\n";
    error_log($errMsg, 3, __DIR__ . "/../public/logs/errors.log");
    $custom_err_stmt = "An unexpected technical error occurred in the application.";
    printCustomError($custom_err_stmt);
}

function shutdownHandler()
{
    $error = error_get_last();
    if ($error !== null && $error['type'] == E_ERROR) {
        $err_msg = $error['file'] . "\n" . $error['message'] . "\n";
        error_log($err_msg, 3, __DIR__ . "/../public/logs/errors.log");
        $custom_err_stmt = "An unexpected critical error occurred in the application.";
        printCustomError($custom_err_stmt);
    }
}

function printCustomError($err_stmt)
{

    //About JSON File Content
    $aboutJSONFile = file_get_contents(__DIR__ . '/../public/content/about.json');
    $aboutJSONEnc = json_decode($aboutJSONFile, true);

    $err_msg = "";
    $err_msg .= "<div style='width: 600px; max-width: 600px; min-width: 240px; background-color: #ffffff; margin: 30px auto; padding: 30px; border: 1px solid #03668d; border-radius: 5px;'>";
    $err_msg .= "<h2 style='color: #03668d; font-family: trebuchet, sans-serif; font-weight: bold; margin: 0px 0px 15px 0px;'>";
    $err_msg .= "<span style='color: #c53637;'>" . $aboutJSONEnc['Facilitator']['title'] . "</h2>";
    $err_msg .= "<div style='background-color: #c53637; padding: 5px 15px; border-radius: 5px;'>";
    $err_msg .= "<p style='color: #ffffff; font-family: trebuchet, sans-serif; padding: 0px; margin: 0px;'>";
    $err_msg .= $err_stmt;
    $err_msg .= "</p>";
    $err_msg .= "</div>";
    $err_msg .= "</div>";
    echo $err_msg;
}

set_error_handler('customErrorHandler');
register_shutdown_function('shutdownHandler');
