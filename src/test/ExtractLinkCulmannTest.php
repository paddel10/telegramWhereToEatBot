<?php
require_once "../ExtractLinkCulmann.php";

$extractLink = new ExtractLinkCulmann();
echo $extractLink->extract() . "\n";