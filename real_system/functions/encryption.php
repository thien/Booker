<?php 
function encrypt($value) {
    $salt = '}B8>){9#3*4L3t98d9QF3)&#9j?tKf';
    $salt = md5($salt);
    $value = md5($value);
    $value = hash('ripemd160', $salt . $value);
    return $value;
}
?>