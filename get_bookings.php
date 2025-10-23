<?php
header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    
    if (empty($user_id)) {
        echo json_encode(['success' => false, 'message' => 'User ID is required']);
        exit();
    }
    
    // Get all bookings for the user
    $query = "SELECT b.*, p.id as payment_id, p.amount as payment_amount, p.status as payment_status, p.payment_date 
              FROM bookings b
              LEFT JOIN payments p ON b.id = p.booking_id
              WHERE b.user_id = '$user_id'
              ORDER BY b.booking_date DESC";
    
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $bookings = [];
        
        while ($row = mysqli_fetch_assoc($result)) {
            $bookings[] = [
                'id' => $row['id'],
                'service' => $row['service'],
                'price' => $row['price'],
                'event_name' => $row['event_name'],
                'event_email' => $row['event_email'],
                'event_phone' => $row['event_phone'],
                'event_date' => $row['event_date'],
                'guests' => $row['guests'],
                'requirements' => $row['requirements'],
                'booking_date' => $row['booking_date'],
                'payment' => [
                    'id' => $row['payment_id'],
                    'amount' => $row['payment_amount'],
                    'status' => $row['payment_status'],
                    'date' => $row['payment_date']
                ]
            ];
        }
        
        echo json_encode([
            'success' => true,
            'bookings' => $bookings
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch bookings: ' . mysqli_error($conn)]);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

mysqli_close($conn);
?>