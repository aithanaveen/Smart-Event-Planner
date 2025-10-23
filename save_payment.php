<?php
header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $user_id = mysqli_real_escape_string($conn, $data['user_id']);
    $booking_ids = $data['booking_ids']; // Array of booking IDs
    $amount = mysqli_real_escape_string($conn, $data['amount']);
    $payment_method = mysqli_real_escape_string($conn, $data['payment_method']);
    $payment_info = mysqli_real_escape_string($conn, $data['payment_info']);
    
    // Validate input
    if (empty($user_id) || empty($amount) || empty($booking_ids)) {
        echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
        exit();
    }
    
    // Start transaction
    mysqli_begin_transaction($conn);
    
    try {
        $payment_id = null;
        
        // Insert payment for each booking
        foreach ($booking_ids as $booking_id) {
            $booking_id = mysqli_real_escape_string($conn, $booking_id);
            
            $query = "INSERT INTO payments (user_id, booking_id, amount, payment_method, payment_info, status, payment_date) 
                      VALUES ('$user_id', '$booking_id', '$amount', '$payment_method', '$payment_info', 'Completed', NOW())";
            
            if (!mysqli_query($conn, $query)) {
                throw new Exception('Failed to save payment: ' . mysqli_error($conn));
            }
            
            if ($payment_id === null) {
                $payment_id = mysqli_insert_id($conn);
            }
        }
        
        // Commit transaction
        mysqli_commit($conn);
        
        echo json_encode([
            'success' => true,
            'message' => 'Payment processed successfully',
            'payment_id' => $payment_id
        ]);
        
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

mysqli_close($conn);
?>