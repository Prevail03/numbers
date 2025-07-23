<?php

include_once "includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['formName'])) {
    $form = $_POST['formName'];
  }
  if ($form == 'addLeague') {
    $leagueName = $_POST['leagueName'];

    $leagueDesc = $_POST['leagueDesc'];
    $addedBy = $_POST['addedBy'];
    $status = "Active";
    $leagueYear = $_POST['leagueYear'];
    $data = [
      'leagueName' => $leagueName,
      'leagueDesc' => $leagueDesc,
      'createdBy' => $addedBy,
      'leagueStatus' => $status,
      'leagueYear' => $leagueYear
    ];


}
