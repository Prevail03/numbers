<?php
// Database credentials
$host = "localhost";  // or 127.0.0.1
$user = "root";
$password = "";
$database = "handball_numbers";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data function
function insertData($conn, $table, $data) {
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), "?"));

    $types = str_repeat("s", count($data)); // assuming all are strings
    $values = array_values($data);

    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Insert prepare failed: " . $conn->error;
        return false;
    }

    $stmt->bind_param($types, ...$values);

    if ($stmt->execute()) {
        echo "New record inserted successfully.<br>";
        return true;
    } else {
        echo "Error inserting record: " . $stmt->error . "<br>";
        return false;
    }
}


// Read data function
function readData($conn, $table, $where = '', $params = []) {
    $sql = "SELECT * FROM $table";
    if (!empty($where)) {
        $sql .= " WHERE $where";
    }

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Read prepare failed: " . $conn->error;
        return false;
    }

    if (!empty($params)) {
        $types = str_repeat("s", count($params)); // all strings
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $data = [];
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    } else {
        return false;
    }
}

function readQuery(mysqli $conn, string $query, array $params = []): array {
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters if any
    if (!empty($params)) {
        $types = str_repeat('s', count($params)); // All string params; adjust if needed
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();
    return $data;
}


// Update data function
function updateData($conn, $table, $data, $where, $whereParams = []) {
    $setParts = [];
    foreach ($data as $key => $value) {
        $setParts[] = "$key = ?";
    }

    $setClause = implode(", ", $setParts);
    $sql = "UPDATE $table SET $setClause WHERE $where";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Update prepare failed: " . $conn->error;
        return false;
    }

    $types = str_repeat("s", count($data) + count($whereParams));
    $values = array_merge(array_values($data), $whereParams);

    $stmt->bind_param($types, ...$values);

    if ($stmt->execute()) {
        echo "Record updated successfully.<br>";
        return true;
    } else {
        echo "Error updating record: " . $stmt->error . "<br>";
        return false;
    }
}


// Delete data function
function deleteData($conn, $table, $where, $params = []) {
    $sql = "DELETE FROM $table WHERE $where";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Delete prepare failed: " . $conn->error;
        return false;
    }

    if (!empty($params)) {
        $types = str_repeat("s", count($params));
        $stmt->bind_param($types, ...$params);
    }

    if ($stmt->execute()) {
        echo "Record deleted successfully.<br>";
        return true;
    } else {
        echo "Error deleting record: " . $stmt->error . "<br>";
        return false;
    }
}

//check for required fields
function checkRequiredFields(array $requiredFields, array $data) {
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            return "The field '$field' is required.";
        }
    }
    return null; // All fields are filled
}


// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php'; // Ensure Composer's autoloader is included

// function sendEmail($to, $subject, $message, $bcc = null) {
//     $mail = new PHPMailer(true);

//     try {
//         // SMTP Configuration
//         $mail->isSMTP();
//         $mail->Host       = 'smtp.example.com';       // Replace with your SMTP server
//         $mail->SMTPAuth   = true;
//         $mail->Username   = 'your@email.com';         // SMTP username
//         $mail->Password   = 'yourpassword';           // SMTP password
//         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//         $mail->Port       = 587;

//         // Email Headers
//         $mail->setFrom('your@email.com', 'Your Name');
//         $mail->addAddress($to);

//         if ($bcc) {
//             $mail->addBCC($bcc);
//         }

//         // Email Content
//         $mail->isHTML(true);
//         $mail->Subject = $subject;
//         $mail->Body    = $message;
//         $mail->AltBody = strip_tags($message);

//         $mail->send();
//         return true;
//     } catch (Exception $e) {
//         error_log("Mailer Error: {$mail->ErrorInfo}");
//         return false;
//     }
// }
