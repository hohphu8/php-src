--TEST--
shm_get_var() unwraps top-level reference from unserialized self-referential object
--EXTENSIONS--
sysvshm
--SKIPIF--
<?php
if (!function_exists('ftok')) die('skip needs ftok');
?>
--FILE--
<?php

$key = ftok(__FILE__, 'r');
$shm = shm_attach($key, 4096);

$obj = new stdClass();
$obj->self = &$obj;
shm_put_var($shm, 1, $obj);

$out = shm_get_var($shm, 1);
var_dump($out instanceof stdClass);
var_dump($out->self === $out);

shm_remove($shm);
echo "Done\n";
?>
--EXPECT--
bool(true)
bool(true)
Done
