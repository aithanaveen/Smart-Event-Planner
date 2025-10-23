<?php
header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $user_id = mysqli_real_escape_string($conn, $data['user_id']);
    $service = mysqli_real_escape_string($conn, $data['service']);
    $price = mysqli_real_escape_string($conn, $data['price']);
    $event_name = mysqli_real_escape_string($conn, $data['event_name']);
    $event_email = mysqli_real_escape_string($conn, $data['event_email']);
    $event_phone = mysqli_real_escape_string($conn, $data['event_phone']);
    $event_date = mysqli_real_escape_string($conn, $data['event_date']);
    $guests = mysqli_real_escape_string($conn, $data['guests']);
    $requirements = mysqli_real_escape_string($conn, $data['requirements']);
    
    // Validate input
    if (empty($user_id) || empty($service) || empty($price)) {
        echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
        exit();
    }
    
    // Insert booking
    $query = "INSERT INTO bookings (user_id, service, price, event_name, event_email, event_phone, event_date, guests, requirements, booking_date) 
              VALUES ('$user_id', '$service', '$price', '$event_name', '$event_email', '$event_phone', '$event_date', '$guests', '$requirements', NOW())";
    
    if (mysqli_query($conn, $query)) {
        $booking_id = mysqli_insert_id($conn);
        
        echo json_encode([
            'success' => true,
            'message' => 'Booking saved successfully',
            'booking_id' => $booking_id,
            'booking' => [
                'id' => $booking_id,
                'service' => $service,
                'price' => $price,
                'event_name' => $event_name,
                'event_email' => $event_email,
                'event_phone' => $event_phone,
                'event_date' => $event_date,
                'guests' => $guests,
                'requirements' => $requirements
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save booking: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

mysqli_close($conn);
?>