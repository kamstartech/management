<?php
$id = $_GET['id'];
include ("BarcodeGenerator.php");
include ("BarcodeGeneratorHTML.php");
include ("BarcodeGeneratorPNG.php");

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
echo $generator->getBarcode($id, $generator::TYPE_CODE_128);


?>