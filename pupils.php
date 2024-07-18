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
    $medicalInfo = $_POST["MedicalInformation"];
    $classID = $_POST["ClassID"];

    $sql = "INSERT INTO Pupils (FirstName, LastName, Address, MedicalInformation, ClassID) VALUES ('$firstName', '$lastName', '$address', '$medicalInfo', $classID)";

    if ($conn->query($sql) === TRUE) {
        echo "New pupil added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch pupils
$sql = "SELECT * FROM Pupils";
$result = $conn->query($sql);

// Include header
include 'header.php';

// Display pupils
echo "<h1>Pupils</h1>";
echo "<table>";
echo "<tr><th>PupilID</th><th>FirstName</th><th>LastName</th><th>Address</th><th>MedicalInformation</th><th>ClassID</th></tr>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["PupilID"]. "</td><td>" . $row["FirstName"]. "</td><td>" . $row["LastName"]. "</td><td>" . $row["Address"]. "</td><td>" . $row["MedicalInformation"]. "</td><td>" . $row["ClassID"]. "</td></tr>";
    }
} else {
    echo "<tr><td colspan='6'>No pupils found</td></tr>";
}
echo "</table>";

// Form for adding new pupils
?>
<h2>Add New Pupil</h2>
<form action="pupils.php" method="post">
    <label for="FirstName">First Name:</label>
    <input type="text" id="FirstName" name="FirstName" required>
    
    <label for="LastName">Last Name:</label>
    <input type="text" id="LastName" name="LastName" required>
    
    <label for="Address">Address:</label>
    <input type="text" id="Address" name="Address" required>
    
    <label for="MedicalInformation">Medical Information:</label>
    <textarea id="MedicalInformation" name="MedicalInformation" required></textarea>
    
    <label for="ClassID">Class ID:</label>
    <input type="number" id="ClassID" name="ClassID" required>
    
    <input type="submit" value="Add Pupil">
</form>

<?php
// Include footer
include 'footer.php';

$conn->close();
?>
