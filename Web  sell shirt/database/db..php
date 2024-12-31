<?php
class DB {
    private $servername = "127.0.0.1";
    private $username = "root"; // MySQL username
    private $password = "jojo1236"; // MySQL password
    private $dbname = "product"; // Your database name

    public $conn;

    // Constructor to create the database connection
    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Check the connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Method to fetch all products from the "name list"
    public function fetchProducts() {
        $sql = "SELECT id, name, price, img FROM list";
        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC); // Return products as an associative array
        } else {
            return []; // No products found
        }
    }

    // Method to insert a product into the database "name list"
    public function insertProduct($id, $name, $price, $img) {
        $sql = "INSERT INTO list(id, name, price, img) VALUES (?, ?, ?, ?)";

        // Prepare the SQL statement
        if ($stmt = $this->conn->prepare($sql)) {
            // Bind parameters and execute the query
            $stmt->bind_param("isds", $id, $name, $price, $img); // Adjusted for decimal price
            if ($stmt->execute()) {
                $stmt->close();
                return true; // Success
            } else {
                $stmt->close();
                return false; // Failure
            }
        } else {
            return false; // Failure if statement couldn't be prepared
        }
    }

    // Method to close the connection
    public function close() {
        $this->conn->close();
    }
}
?>
