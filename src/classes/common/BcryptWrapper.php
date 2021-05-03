<?php

class BcryptWrapper
{
    public function __construct() {}

    public function __destruct() {}

    public static function hashPassword($password) {
       return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function authenticate($password, $stored_password) {
        return password_verify($password, $stored_password);
    }
} 