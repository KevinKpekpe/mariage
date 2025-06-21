<?php
/**
 * Script pour insérer un officier dans la base de données
 * Usage: php insert_officer.php
 */

require_once 'db.php';

try {    
    // Données de l'officier à insérer
    $nom = 'Kabongo';
    $prenom = 'Kabongo';
    $email = 'kabongo@example.com';
    $mot_de_passe_clair = 'kabongo';
    $id_commune = 1;
    $role = 'officier_communal';
    
    // Hachage du mot de passe
    $mot_de_passe_hash = password_hash($mot_de_passe_clair, PASSWORD_DEFAULT);
    
    // Préparation de la requête
    $sql = "INSERT INTO officiers (nom, prenom, email, mot_de_passe, id_commune, role) 
            VALUES (:nom, :prenom, :email, :mot_de_passe, :id_commune, :role)";
    
    $stmt = $pdo->prepare($sql);
    
    // Exécution de la requête avec les paramètres
    $result = $stmt->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':mot_de_passe' => $mot_de_passe_hash,
        ':id_commune' => $id_commune,
        ':role' => $role
    ]);
    
    if ($result) {
        $id_insere = $pdo->lastInsertId();
        echo "Officier inséré avec succès !\n";
        echo "ID de l'officier : $id_insere\n";
        echo "Nom : $nom $prenom\n";
        echo "Email : $email\n";
        echo "Rôle : $role\n";
        echo "ID Commune : $id_commune\n";
    }
    
} catch (PDOException $e) {
    echo "Erreur de base de données : " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
    exit(1);
}

echo "\nScript terminé.\n";
?>