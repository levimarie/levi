<?php
function add_notification($conn, $user_id, $message, $type = null, $reference_id = null) {
    $sql = "INSERT INTO notifications (user_id, message, notification_type, reference_id) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $user_id, $message, $type, $reference_id);
    return $stmt->execute();
}
?>