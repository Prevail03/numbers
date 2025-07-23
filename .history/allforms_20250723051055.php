<?php

include_once "includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['formName'])) {
    $form = $_POST['formName'];
  }
  if ($form == 'addLeague') {
    $requiredFields = ["leagueName", "leagueDesc", "leagueYear"];
        $error = checkRequiredFields($requiredFields, $_POST);
        if ($error) {
            echo $error;
            exit;
        }
    $leagueName = $_POST['leagueName'];

    $leagueDesc = $_POST['leagueDesc'];
    // $addedBy = $_POST['addedBy'];
    $addedBy = 1;
    $status = "Active";
    $leagueYear = $_POST['leagueYear'];
    $data = [
      'leagueName' => $leagueName,
      'leagueDesc' => $leagueDesc,
      'createdBy' => $addedBy,
      'leagueStatus' => $status,
      'leagueYear' => $leagueYear
    ];
    $result = insertData($conn, 'leagues', $data);
    if ($result) {
      header("Location: leagues.php?success=League created successfully");
      exit;
    } else {
      header("Location: leagues.php?error=Failed to create league");
      exit;
    }
  }


}
