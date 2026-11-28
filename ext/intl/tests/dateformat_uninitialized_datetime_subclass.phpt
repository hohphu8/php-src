--TEST--
intl_datetime_decompose() rejects uninitialized DateTime subclass overriding getTimestamp()
--EXTENSIONS--
intl
--FILE--
<?php

class UninitDateTime extends DateTime {
    public function __construct() {}
    public function getTimestamp(): int {
        return 0;
    }
}

$dt = new UninitDateTime();

var_dump(IntlDateFormatter::formatObject($dt));
var_dump(intl_get_error_message());

$fmt = new IntlDateFormatter('en_US', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT, 'UTC');
var_dump($fmt->format($dt));
var_dump($fmt->getErrorMessage());

var_dump(MessageFormatter::formatMessage('en_US', '{0,date,short}', [$dt]));
var_dump(intl_get_error_message());
?>
--EXPECTF--
bool(false)
string(%d) "%sthe UninitDateTime object is not properly initialized: U_ILLEGAL_ARGUMENT_ERROR"
bool(false)
string(%d) "%sthe UninitDateTime object is not properly initialized: U_ILLEGAL_ARGUMENT_ERROR"
bool(false)
string(83) "The argument for key '0' cannot be used as a date or time: U_ILLEGAL_ARGUMENT_ERROR"
