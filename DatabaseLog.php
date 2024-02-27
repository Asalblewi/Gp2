
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
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the username and password against the database
    try {
        $stmt = $pdo->prepare("SELECT * FROM `video text pro` WHERE User_name = ?");
        $stmt->execute([$username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password === $user['User_Pass']) {
            // Username and password are valid
            echo "Login successful!";
            header("Location: index.html");
            exit(); // Make sure to exit after redirecting

        } else {
            // Invalid username or password
            echo "Invalid username or password!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>