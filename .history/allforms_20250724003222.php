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
    $existingLeague = readData($conn, 'leagues', "leagueName='$leagueName' ");
    if ($existingLeague) {
        header("Location: leagues.php?error=league already exists;;;;!!!!.");
        exit();
    }

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
     if (deleteData($conn, 'leagues', "insertID='$insertID'")) {
            header("Location: leagues.php?success=League deleted successfully");
            exit;
        } else {
            header("Location: leagues.php?error=Failed to delete client");
            exit;
        }
  }else if ($form == 'editLeague') {
    $requiredFields = ['insertID', 'leagueName', 'leagueDesc', 'leagueYear', 'leagueGender', 'leagueStatus'];
    $error = checkRequiredFields($requiredFields, $_POST);
    if ($error) {
      echo $error;
      exit;
    }
    $insertID = $_POST['insertID'];
    $leagueName = $_POST['leagueName'];
    // $existingLeague = readData($conn, 'leagues', "leagueName='$leagueName' AND insertID != '$insertID'");
    // if ($existingLeague) {
    //     header("Location: leagues.php?error=league already exists;;;;!!!!.");
    //     exit();
    // }
    $leagueDesc = $_POST['leagueDesc'];
    // $addedBy = $_POST['addedBy'];
    $updatedBy = 1;
    $status = $_POST['leagueStatus'];
    $leagueYear = $_POST['leagueYear'];
    $leagueGender = $_POST['leagueGender'];

    $data = [
      'leagueName' => $leagueName,
      'leagueDesc' => $leagueDesc,
      'updatedBy' => $updatedBy,
      'leagueStatus' => $status,
      'leagueYear' => $leagueYear,
      'leagueGender' => $leagueGender
    ];
    //$result = updateData($conn, 'packages', "packageID='$packageID'", $data);
    $result= updateData($conn, 'leagues', $data, "insertID='$insertID'" );
    if ($result) {
        header("Location: leagues.php?success=League updated successfully");
        exit;
    } else {
        header("Location: leagues.php?error=Failed to update league");
        exit;
    }
  }
}
