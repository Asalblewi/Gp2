


<?php
// Database configuration
$host = 'localhost';
$dbName = 'video text pro';
$username = 'root';
$password = '';

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the database successfully!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Insert the form data into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO `video text pro` (User_name, Name, User_Email, User_Pass) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $fullname, $email, $password]);
        echo "Registration successful!";
        header("Location: index.html");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>