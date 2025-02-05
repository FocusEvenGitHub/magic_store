<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
class ImportExcel {
  public static function importFile($filePath) {
    $spreadsheet = IOFactory::load($filePath);
    $worksheet = $spreadsheet->getActiveSheet();
    $db = Database::getConnection();
    foreach ($worksheet->getRowIterator(2) as $row) {
      $cellIterator = $row->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(false);
      $data = [];
      foreach ($cellIterator as $cell) {
        $data[] = $cell->getValue();
      }
      $stmt = $db->prepare('INSERT INTO clients (name, email, magical_id) VALUES (?, ?, ?)');
      $stmt->bind_param('sss', $data[0], $data[1], $data[2]);
      $stmt->execute();
    }
  }
}
?>
