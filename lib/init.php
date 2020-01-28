<?php

//Initialitasion du projet

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();


include 'lib/bdd.php';

require 'class/autoloader.php';
autoloader::register();
