<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// $env = "LOCAL";
$env = "APCOM";

$baseUrls = [
	"LOCAL" => "//localhost:8888/odi-mayors",
	"APCOM" => "https://www.alexpiacentini.com/test/odi/mayors",
];

$urls = [
  "site"    => $baseUrls[$env],
  "assets"  => $baseUrls[$env] ."/assets",
  "content" => $baseUrls[$env] ."/content",
];

$paths = [
  "site"   	=> getcwd(),
  "assets"  => getcwd() ."/assets",
  "content" => getcwd() ."/content",
];

