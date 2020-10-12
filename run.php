<?php
require_once __DIR__ . '/src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Server\Display\Execute;
$execute  = new Execute();
$runFile  = $argv[1] ?? $_GET['file'] ?? '';
$runFile  = str_replace('..', '', $runFile);
$fullName = str_replace('//', '/', __DIR__ . '/' . $runFile);
$output   = $execute->render($fullName);
include __DIR__ . '/index.php';
