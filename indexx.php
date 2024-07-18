<?php
$servername = "localhost";
$username = "root";
$password = "password"; 
$dbname = "rishton";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST['formType'];
    
    $first_name = $_POST['FirstName'];
    $last_name = $_POST['LastName'];
    $address = $_POST['Address'];
    $email = $_POST['Email'];
    $phone_number = $_POST['PhoneNumber'];

    if ($type == "Guardian") {
        $sql = "INSERT INTO Guardians (first_name, last_name, address, email, phone_number) VALUES (?, ?, ?, ?, ?)";
    } elseif ($type == "Pupil") {
        $medical_information = $_POST['MedicalInformation'];
        $sql = "INSERT INTO Pupils (first_name, last_name, address, email, phone_number, medical_information) VALUES (?, ?, ?, ?, ?, ?)";
    } elseif ($type == "Teacher") {
        $annual_salary = $_POST['AnnualSalary'];
        $background_check = isset($_POST['BackgroundCheck']) ? 1 : 0;
        $sql = "INSERT INTO Teachers (first_name, last_name, address, email, phone_number, annual_salary, background_check) VALUES (?, ?, ?, ?, ?, ?, ?)";
    }

    $stmt = $conn->prepare($sql);

    if ($type == "Guardian") {
        $stmt->bind_param("sssss", $first_name, $last_name, $address, $email, $phone_number);
    } elseif ($type == "Pupil") {
        $stmt->bind_param("ssssss", $first_name, $last_name, $address, $email, $phone_number, $medical_information);
    } elseif ($type == "Teacher") {
        $stmt->bind_param("ssssssd", $first_name, $last_name, $address, $email, $phone_number, $annual_salary, $background_check);
    }

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
