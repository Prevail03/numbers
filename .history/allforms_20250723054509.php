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
    $existingLeague = readData($conn, 'clients', "IDNumber='$IDNumber' OR phoneNumber='$phoneNumber' OR clientAccountNo='$clientAccountNo'");
        if ($existingUser) {
            // echo "Email or phone number already exists. Please use a different one.";
            header("Location: clients.php?error=Clients already exists;;;;!!!!.");
            exit();
        }
    $leagueName = $_POST['leagueName'];
    $leagueDesc = $_POST['leagueDesc'];
    // $addedBy = $_POST['addedBy'];
    $addedBy = 1;
    $status = "Active";
    $leagueYear = $_POST['leagueYear'];
    $leagueGender = $_POST['leagueGender'];
    $data = [
      'leagueName' => $leagueName,
      'leagueDesc' => $leagueDesc,
      'createdBy' => $addedBy,
      'leagueStatus' => $status,
      'leagueYear' => $leagueYear,
      'leagueGender' => $leagueGender
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
  else if ($form == 'deleteLeague') {
    $requiredFields = ['insertID'];
    $error = checkRequiredFields($requiredFields, $_POST);
    if ($error) {
      echo $error;
      exit;
    }
    $insertID = $_POST['insertID'];
    $result = deleteData($conn, 'leagues', 'insertID', $insertID);
    if ($result) {
      header("Location: leagues.php?success=League deleted successfully");
      exit;
    } else {
      header("Location: leagues.php?error=Failed to delete league");
      exit;
    }
  }


}
