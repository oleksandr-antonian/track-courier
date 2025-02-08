<?php

$i = 0;
$i++;

$cfg['Servers'][$i]['host'] = 'mysql';

if($_ENV['environment'] == "development" || $_ENV['environment'] == "local")
{
    $cfg['Servers'][$i]['auth_type'] = 'config';
    $cfg['Servers'][$i]['username'] = $_ENV['username'];
    $cfg['Servers'][$i]['password'] = $_ENV['password'];
}