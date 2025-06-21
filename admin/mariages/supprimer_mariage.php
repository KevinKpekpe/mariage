<?php
require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../functions.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: /admin/login.php');
    exit;
}

// Check for ID
$id_mariage = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id_mariage) {
    header('Location: mariages.php');
    exit;
}

// Call delete function
$result = deleteMariage($pdo, $id_mariage);

if ($result['success']) {
    header('Location: mariages.php?success=delete');
    exit;
} else {
    // Optionally, handle the error (e.g., log it or show a message)
    $error_message = urlencode($result['errors'][0] ?? 'Une erreur est survenue lors de la suppression.');
    header('Location: mariages.php?error=' . $error_message);
    exit;
} 