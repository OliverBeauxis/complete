<?php

if (isset($_GET['length']) && isset($_GET['complexity'])) {
    $length = $_GET['length'];
    $complexity = $_GET['complexity'];
    if (is_numeric($length) && ($complexity == 'low' || $complexity == 'medium' || $complexity == 'high')) {
        $password = generatePassword($length, $complexity);
        if (isset($_GET['format'])) {
            switch($_GET['format']) {
                case 'json':
                    header('Content-Type: application/json');
                    echo json_encode(array('generatedPassword' => $password));
                    break;
                case 'xml':
                    header('Content-Type: text/xml');
                    echo '<?xml version="1.0" encoding="UTF-8"?>';
                    echo '<generatedPassword>' . $password . '</generatedPassword>';
                    break;
                case 'csv':
                    header('Content-Type: text/csv');
                    echo "generatedPassword\n";
                    echo $password;
                    break;
                default:
                    echo 'Invalid parameters';
            }
        } else {
            echo 'Invalid parameters';
        }
    } else {
        echo 'Invalid parameters';
    }
} else {
    echo 'Invalid parameters';
}

function generatePassword($length, $complexity)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $chars_low = 'abcdefghijklmnopqrstuvwxyz';
    $chars_medium = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $chars_high = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    $chars_length = strlen($chars);
    $chars_low_length = strlen($chars_low);
    $chars_medium_length = strlen($chars_medium);
    $chars_high_length = strlen($chars_high);
    $random_string = '';
    $random_string_low = '';
    $random_string_medium = '';
    $random_string_high = '';

    for ($i = 0; $i < $length; $i++) {
        $random_string .= $chars[rand(0, $chars_length - 1)];
        $random_string_low .= $chars_low[rand(0, $chars_low_length - 1)];
        $random_string_medium .= $chars_medium[rand(0, $chars_medium_length - 1)];
        $random_string_high .= $chars_high[rand(0, $chars_high_length - 1)];
    }

    switch ($complexity) {
        case 'low':
            return $random_string_low;
        case 'medium':
            return $random_string_medium;
        case 'high':
            return $random_string_high;
        default:
            return $random_string;
    }
}
