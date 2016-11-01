<?php

function FullDate1($datetime) {
    $format = "d/m/Y H:i";
    $_date = date_create($datetime);
    $formatted = date_format($_date, $format);
    return $formatted;
}

function dateValidation($date, $format = 'Y-m-d') {
    $createDate = DateTime::createFromFormat($format, $date);
    if ($createDate && $createDate->format($format) == $date) {
        return true;
    } else {
        return false;
    }
}

function intValidation($str) {
    if (is_int($str))
        return true;
    else
        return false;
}

function transactionIdValidation($str) {
    if (preg_match("/[0-9\-]+/", $str)) {
        return true;
    } else
        return false;
}

function currencyFormat($number) {
    return number_format($number, 2, '.', ',');
}

?>