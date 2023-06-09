<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

include "../core/autoload.php";
include "../core/app/model/SellData.php";
include "../core/app/model/ProductData.php";
include "../core/app/model/OperationData.php";
include "../core/app/model/DData.php";
include "../core/app/model/PData.php";
include "../core/app/model/ConfigurationData.php";
$symbol = ConfigurationData::getByPreffix("currency")->val;

include "../vendor/autoload.php";
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;

$word = new  PhpOffice\PhpWord\PhpWord();
$sells = SellData::getResToReceive();

$section1 = $word->AddSection();
$section1->addText("COMPRAS POR RECIBIR",array("size"=>22,"bold"=>true,"align"=>"right"));


$styleTable = array('borderSize' => 6, 'borderColor' => '888888', 'cellMargin' => 40);
$styleFirstRow = array('borderBottomColor' => '0000FF', 'bgColor' => 'AAAAAA');

$table1 = $section1->addTable("table1");
$table1->addRow();
$table1->addCell()->addText("Id");
$table1->addCell()->addText("Pago");
$table1->addCell()->addText("Entrega");
$table1->addCell()->addText("Total");
$table1->addCell()->addText("Fecha");

foreach($sells as $sell){
    $table1->addRow();
    $table1->addCell(300)->addText("#".$sell->id);
    $table1->addCell(2000)->addText($sell->getP()->name);
    $table1->addCell(2000)->addText($sell->getD()->name);
    $table1->addCell(11000)->addText($symbol." ".($sell->total-$sell->discount));
    $table1->addCell(11000)->addText($sell->created_at);

}

$word->addTableStyle('table1', $styleTable,$styleFirstRow);

$filename = "byreceive-".time().".docx";
$word->save($filename,"Word2007");
header("Content-Disposition: attachment; filename=$filename");
readfile($filename); // or echo file_get_contents($filename);
unlink($filename);  // remove temp file



?>