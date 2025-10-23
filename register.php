<?php
header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get JSON data
    $data = json_decode(file_get_contents('php://input'), true);
    
    $name = mysqli_real_escape_string($conn, $data['name']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $phone = mysqli_real_escape_string($conn, $data['phone']);
    $password = $data['password'];
    
    // Validate input
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit();
    }
    
    // Check if email already exists
    $checkQuery = "SELECT id FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already exists']);
        exit();
    }
    
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user
    $query = "INSERT INTO users (name, email, phone, password, created_at) 
              VALUES ('$name', '$email', '$phone', '$hashedPassword', NOW())";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode([
            'success' => true, 
            'message' => 'Registration successful',
            'user' => [
                'name' => $name,
                'email' => $email,
                'phone' => $phone
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

mysqli_close($conn);
?>