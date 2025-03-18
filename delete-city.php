<?php
include("conection.php");

header('Content-Type: application/json');
$response = ['success' => false, 'error' => ''];

try {
    // Sanitize and validate the input
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    if (!$id) {
        throw new Exception("Invalid ID");
    }

    // Prepare the delete query
    $stmt = $con->prepare("DELETE FROM citys WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        throw new Exception("Failed to delete record: " . $stmt->error);
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

// Return JSON response
echo json_encode($response);
?>
