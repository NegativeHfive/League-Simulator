<?php
include_once "../Classes/Team.php";

$team = new Team();

if (isset($_GET['ID'])) {
    $ID = $_GET['ID'];
    $team->deleteTeam($ID);
}

header("Location: ../homepage/edit.php"); // Redirect back to the list
exit();
?>