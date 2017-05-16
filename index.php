<?php

require('lib/scraping.php');

$scraping = new Scraping();
$result = $scraping->show("https://acidopal.com");

header('Content-Type: application/json');
echo json_encode($result);