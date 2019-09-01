<?php
/**
 * Simple login
 */

include "include/OSAJWT.php";

$token = OSAJWT::encodeToken('1');
setcookie('token', $token, time()+(60 * 60 * 500));
header('Location: /');