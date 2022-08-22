<?php

declare(strict_types=1);

require("../../vendor/autoload.php");

$openapi = \OpenApi\Generator::scan(["../../src/Controller"]);

header('Content-Type: application/json');
echo $openapi->toJson();
