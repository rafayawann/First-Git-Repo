<?php
// Connection to the database
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "scholdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["FirstName"];
    $lastName = $_POST["LastName"];
    $address = $_POST["Address"];
    $phoneNumber = $_POST["PhoneNumber"];
    $annualSalary = $_POST["AnnualSalary"];
    $backgroundCheck = isset($_POST["BackgroundCheck"]) ? 1 : 0;

    $sql = "INSERT INTO Teachers (FirstName, LastName, Address, PhoneNumber, AnnualSalary, BackgroundCheck) VALUES ('$firstName', '$lastName', '$address', '$phoneNumber', $annualSalary, $backgroundCheck)";

    if ($conn->query($sql) === TRUE) {
        echo "New teacher added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch teachers
$sql = "SELECT * FROM Teachers";
$result = $conn->query($sql);

// Include header
include 'index.html';

// Display teachers
echo "<h1>Teachers</h1>";
echo "<table>";
echo "<tr><th>TeacherID</th><th>FirstName</th><th>LastName</th><th>Address</th><th>PhoneNumber</th><th>AnnualSalary</th><th>BackgroundCheck</th></tr>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["TeacherID"]. "</td><td>" . $row["FirstName"]. "</td><td>" . $row["LastName"]. "</td><td>" . $row["Address"]. "</td><td>" . $row["PhoneNumber"]. "</td><td>" . $row["AnnualSalary"]. "</td><td>" . ($row["BackgroundCheck"] ? 'Yes' : 'No'). "</td></tr>";
    }
} else {
    echo "<tr><td colspan='7'>No teachers found</td></tr>";
}
echo "</table>";

// Form for adding new teachers
?>
<h2>Information of Teacher</h2>
<form action="index.php" method="post">
    <label for="FirstName">First Name:</label>
    <input type="text" id="FirstName" name="FirstName" required>
    
    <label for="LastName">Last Name:</label>
    <input type="text" id="LastName" name="LastName" required>
    
    <label for="Address">Address:</label>
    <input type="text" id="Address" name="Address" required>
    
    <label for="PhoneNumber">Phone Number:</label>
    <input type="text" id="PhoneNumber" name="PhoneNumber" required>
    
    <label for="AnnualSalary">Annual Salary:</label>
    <input type="number" id="AnnualSalary" name="AnnualSalary" required>
    
    <label for="BackgroundCheck">Background Check:</label>
    <input type="checkbox" id="BackgroundCheck" name="BackgroundCheck">
    
    <input type="submit" value="Add Teacher">
</form>

<?php
// Include footer
include 'footer.php';

$conn->close();
?>
