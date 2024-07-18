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
    $email = $_POST["Email"];
    $phoneNumber = $_POST["PhoneNumber"];

    $sql = "INSERT INTO Parents (FirstName, LastName, Address, Email, PhoneNumber) VALUES ('$firstName', '$lastName', '$address', '$email', '$phoneNumber')";

    if ($conn->query($sql) === TRUE) {
        echo "New parent added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch parents
$sql = "SELECT * FROM Parents";
$result = $conn->query($sql);

// Include header
include 'header.php';

// Display parents
echo "<h1>Parents</h1>";
echo "<table>";
echo "<tr><th>ParentID</th><th>FirstName</th><th>LastName</th><th>Address</th><th>Email</th><th>PhoneNumber</th></tr>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["ParentID"]. "</td><td>" . $row["FirstName"]. "</td><td>" . $row["LastName"]. "</td><td>" . $row["Address"]. "</td><td>" . $row["Email"]. "</td><td>" . $row["PhoneNumber"]. "</td></tr>";
    }
} else {
    echo "<tr><td colspan='6'>No parents found</td></tr>";
}
echo "</table>";

// Form for adding new parents
?>
<h2>Add New Parent</h2>
<form action="parents.php" method="post">
    <label for="FirstName">First Name:</label>
    <input type="text" id="FirstName" name="FirstName" required>
    
    <label for="LastName">Last Name:</label>
    <input type="text" id="LastName" name="LastName" required>
    
    <label for="Address">Address:</label>
    <input type="text" id="Address" name="Address" required>
    
    <label for="Email">Email:</label>
    <input type="email" id="Email" name="Email" required>
    
    <label for="PhoneNumber">Phone Number:</label>
    <input type="text" id="PhoneNumber" name="PhoneNumber" required>
    
    <input type="submit" value="Add Parent">
</form>

<?php
// Include footer
include 'footer.php';

$conn->close();
?>
