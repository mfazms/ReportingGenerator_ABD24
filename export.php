<?php
// Include PhpSpreadsheet classes
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Function to get HTML content of table by ID
function getHTMLTableByID($id) {
    $html = '';
    if (isset($_POST['html'])) {
        $html = $_POST['html'];
    } else {
        $html = '<table>' . file_get_contents('php://input') . '</table>';
    }
    return $html;
}

// Check if ID is passed in URL
if (isset($_GET['id'])) {
    $tableId = $_GET['id'];

    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Get HTML content from the table with the given ID
    $html = getHTMLTableByID($tableId);

    // Load HTML to DOMDocument
    $dom = new DOMDocument();
    libxml_use_internal_errors(true); // Suppress HTML errors
    $dom->loadHTML($html);
    libxml_clear_errors();

    // Get all rows from the table
    $rows = $dom->getElementById($tableId)->getElementsByTagName('tr');
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
} else {
    echo 'Table ID not provided.';
}
