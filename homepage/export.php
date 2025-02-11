<?php

include_once "../includes/Database.php";

$database = new Database();
$connection = $database->pdo;

if(!$connection){
    die("Database connection fialed");
}


$query = "SELECT * FROM ranking";
$statement = $connection->prepare($query);
$statement->execute();
$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ranking_export.xls"'); 
header('Cache-Control: max-age=0');

$output = fopen('php://output','w');

if(!empty($rows)){
    fputcsv($output,array_keys($rows[0],"\t"));
}

foreach($rows as $row){
    fputcsv($output, $row, "\t");
}

fclose($output);
exit;


?>