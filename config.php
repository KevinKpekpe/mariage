<?php
/**
 * Configuration de la plateforme des mariages civils
 * Ce fichier contient les paramètres de connexion à la base de données
 * et diverses fonctions utilitaires utilisées dans l'application
 */

// Paramètres de connexion à la base de données
define('DB_HOST', 'localhost');     // Hôte de la base de données
define('DB_USER', 'root');      // Nom d'utilisateur de la base de données
define('DB_PASS', 'rootpassword');      // Mot de passe de la base de données
define('DB_NAME', 'mariages_civils'); // Nom de la base de données

// Paramètres de l'application
define('APP_NAME', 'Registre des Mariages Civils');
define('APP_URL', 'https://mariages.example.com'); // URL de base de l'application
define('UPLOAD_DIR', __DIR__ . '/uploads/');      // Répertoire pour les fichiers téléchargés
define('MAX_FILE_SIZE', 5 * 1024 * 1024);        // Taille maximale des fichiers (5 Mo)

// Connexion à la base de données
function connectDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données: " . $conn->connect_error);
    }
    
    // Définir l'encodage des caractères
    $conn->set_charset("utf8");
    return $conn;
}

// Fonction pour nettoyer les entrées utilisateur
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Fonction pour vérifier si un utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Fonction pour vérifier si un utilisateur est administrateur
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Fonction pour vérifier si un utilisateur est officier d'état civil
function isOfficer() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'officer';
}

// Fonction pour rediriger vers une page
function redirect($url) {
    header("Location: $url");
    exit;
}

// Fonction pour générer un token CSRF
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Fonction pour vérifier un token CSRF
function verifyCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}

// Fonction pour formater une date
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

// Fonction pour formater une heure
function formatTime($time) {
    return date('H:i', strtotime($time));
}

// Fonction pour obtenir le nombre d'objections en attente
function getObjectionsCount() {
    $conn = connectDB();
    $sql = "SELECT COUNT(*) as count FROM objections WHERE status = 'pending'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();
    return $row['count'];
}

// Fonction pour enregistrer une activité dans les logs
function logActivity($userId, $action, $details = '') {
    $conn = connectDB();
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    
    $sql = "INSERT INTO activity_logs (user_id, action, details, ip_address) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $userId, $action, $details, $ipAddress);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

// Fonction pour rechercher une personne par nom ou numéro d'identité
function searchPerson($searchTerm) {
    $conn = connectDB();
    
    $searchTerm = "%$searchTerm%";
    
    $sql = "SELECT p.id, p.first_name, p.last_name, p.gender, p.birth_date, p.id_number, p.photo_url
            FROM persons p
            WHERE (p.first_name LIKE ? OR p.last_name LIKE ? OR p.id_number LIKE ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $persons = [];
    while ($row = $result->fetch_assoc()) {
        // Vérifier si la personne est mariée
        $sql2 = "SELECT m.id, m.marriage_date, m.certificate_number, 
                 p2.first_name, p2.last_name
                 FROM marriages m
                 JOIN persons p2 ON (m.person1_id = ? AND m.person2_id = p2.id) OR (m.person2_id = ? AND m.person1_id = p2.id)
                 WHERE m.status = 'completed'";
        
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ii", $row['id'], $row['id']);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        
        if ($result2->num_rows > 0) {
            $spouse = $result2->fetch_assoc();
            $row['marital_status'] = 'married';
            $row['spouse'] = $spouse['first_name'] . ' ' . $spouse['last_name'];
            $row['marriage_date'] = $spouse['marriage_date'];
            $row['certificate_number'] = $spouse['certificate_number'];
        } else {
            $row['marital_status'] = 'single';
        }
        
        $stmt2->close();
        $persons[] = $row;
    }
    
    $stmt->close();
    $conn->close();
    
    return $persons;
}

// Fonction pour obtenir les annonces de mariage à venir
function getUpcomingMarriages($limit = 10) {
    $conn = connectDB();
    
    $sql = "SELECT m.id, m.marriage_date, m.marriage_time, 
            p1.first_name as person1_first_name, p1.last_name as person1_last_name, p1.photo_url as person1_photo, 
            p2.first_name as person2_first_name, p2.last_name as person2_last_name, p2.photo_url as person2_photo,
            c.name as commune_name
            FROM marriages m
            JOIN persons p1 ON m.person1_id = p1.id
            JOIN persons p2 ON m.person2_id = p2.id
            JOIN communes c ON m.commune_id = c.id
            WHERE m.status = 'announced' AND m.marriage_date >= CURDATE()
            ORDER BY m.marriage_date ASC, m.marriage_time ASC
            LIMIT ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $marriages = [];
    while ($row = $result->fetch_assoc()) {
        $marriages[] = $row;
    }
    
    $stmt->close();
    $conn->close();
    
    return $marriages;
}

// Fonction pour télécharger une image
function uploadImage($file, $destinationPath) {
    // Vérifier si le fichier est une image
    $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (!in_array($fileType, $allowedExtensions)) {
        return ['success' => false, 'message' => 'Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.'];
    }
    
    // Vérifier la taille du fichier
    if ($file['size'] > MAX_FILE_SIZE) {
        return ['success' => false, 'message' => 'Le fichier est trop volumineux. Maximum: ' . (MAX_FILE_SIZE / 1024 / 1024) . ' MB.'];
    }
    
    // Générer un nom de fichier unique
    $fileName = uniqid() . '.' . $fileType;
    $targetFile = $destinationPath . $fileName;
    
    // Déplacer le fichier
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        return ['success' => true, 'file_path' => 'uploads/' . $fileName];
    } else {
        return ['success' => false, 'message' => 'Une erreur est survenue lors du téléchargement du fichier.'];
    }
}

// Fonction pour envoyer un email
function sendEmail($to, $subject, $message) {
    // En-têtes de l'email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: ' . APP_NAME . ' <no-reply@example.com>' . "\r\n";
    
    // Envoyer l'email
    return mail($to, $subject, $message, $headers);
}

// Fonction pour générer un mot de passe aléatoire
function generatePassword($length = 10) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $password;
}

// Fonction pour hacher un mot de passe
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Fonction pour vérifier un mot de passe
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}