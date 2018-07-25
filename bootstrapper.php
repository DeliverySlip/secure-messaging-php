<?php
/**
 * Created by PhpStorm.
 * User: Ben Soer
 * Date: 7/25/2018
 * Time: 11:04 AM
 */

Phar::mapPhar();

$basePath = 'phar://' . __FILE__ . '/';
require $basePath . 'vendor/autoload.php';

__HALT_COMPILER();