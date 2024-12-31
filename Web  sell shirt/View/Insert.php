<?php
// DB connection details
$servername = "127.0.0.1";
$username = "root"; // MySQL username
$password = "jojo1236"; // MySQL password
$dbname = "product"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $id = $data['id'];
    $name = $data['name'];
    $price = $data['price'];
    $img = $data['img'];

    // Insert product into the list table
    $sql = "INSERT INTO list (id, name, price, img) VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("isss", $id, $name, $price, $img); // Adjusted for string img

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to insert product"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Failed to prepare SQL statement"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid data"]);
}

$conn->close();
?>
