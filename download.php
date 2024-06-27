<?php
// Include PhpSpreadsheet classes
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Get HTML content from the table
$html = '<table>' . file_get_contents('php://input') . '</table>';

// Load HTML to DOMDocument
$dom = new DOMDocument();
$dom->loadHTML($html);

// Get all rows from the table
$rows = $dom->getElementsByTagName('tr');
$rowIndex = 1;

foreach ($rows as $row) {
    $colIndex = 1;
    foreach ($row->childNodes as $cell) {
        $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $cell->textContent);
        $colIndex++;
    }
    $rowIndex++;
}

// Create a Writer for XLSX format
$writer = new Xlsx($spreadsheet);

// Set headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="table-export.xlsx"');

// Write to php://output
$writer->save('php://output');
