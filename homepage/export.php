<?php

include_once "../includes/Database.php";

$database = new Database();
$connection = $database->pdo;

if (!$connection) {
    die("Database connection failed");
}

// Fetch ranking data
$query = "SELECT * FROM ranking";
$statement = $connection->prepare($query);
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

// Set headers for Excel export
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="ranking_export.xls"');
header('Cache-Control: max-age=0');

// Open output stream
$output = fopen('php://output', 'w');

// Check if data exists
if (!empty($rows)) {
    // **Fix:** Write column headers properly
    fputcsv($output, array_keys($rows[0]), "\t");  
}

// Write rows to the output file
foreach ($rows as $row) {
    fputcsv($output, $row, "\t");  
}

// Close the file and exit
fclose($output);
exit;

?>
