<?php
session_start();

function authenticateUser($pdo, $email, $password) {
    $errors = [];
    
    if (empty($email)) {
        $errors[] = "L'email est requis.";
    }
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                SELECT id_officier, email, mot_de_passe, nom, prenom, role 
                FROM officiers 
                WHERE email = :email
            ");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['mot_de_passe'])) {
                $_SESSION['user_id'] = $user['id_officier'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['prenom'] = $user['prenom'];
                $_SESSION['role'] = $user['role'];
                return ['success' => true, 'role' => $user['role']];
            } else {
                $errors[] = "Email ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur de connexion: " . $e->getMessage();
        }
    }
    
    return ['success' => false, 'errors' => $errors];
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function hasRole($role) {
    return isLoggedIn() && $_SESSION['role'] === $role;
}

function logout() {
    session_unset();
    session_destroy();
    header('Location: /admin/login.php');
    exit;
}
function uploadPhoto(array $file, string $subfolder = 'personnes', int $max_size = 2 * 1024 * 1024): string|false {
    $allowed_types = ['image/jpeg', 'image/png'];
    $root_dir = realpath(__DIR__) . DIRECTORY_SEPARATOR;
    $upload_dir = $root_dir . 'uploads' . DIRECTORY_SEPARATOR . $subfolder . DIRECTORY_SEPARATOR;

    // Vérifier fichier
    if ($file['error'] !== UPLOAD_ERR_OK || !in_array($file['type'], $allowed_types) || $file['size'] > $max_size) {
        return false;
    }

    // Créer dossier si besoin
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $filename = uniqid() . '_' . basename($file['name']);
    $destination = $upload_dir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return false;
    }

    // Chemin relatif depuis la racine du projet
    return 'uploads/' . $subfolder . '/' . $filename;
}
function addPerson($pdo, $post_data, $files, $upload_dir = 'uploads/') {
    $errors = [];
    $photo_path = null;

    // Extraction & nettoyage de base
    $nom = trim($post_data['nom'] ?? '');
    $prenom = trim($post_data['prenom'] ?? '');
    $type_personne = trim($post_data['type_personne'] ?? '');
    $date_naissance = trim($post_data['date_naissance'] ?? '');
    $lieu_naissance = trim($post_data['lieu_naissance'] ?? '');
    $nationalite = trim($post_data['nationalite'] ?? '');
    $profession = trim($post_data['profession'] ?? '');
    $adresse_actuelle = trim($post_data['adresse_actuelle'] ?? '');

    // Validation
    if (empty($nom)) {
        $errors[] = "Le nom est requis.";
    }

    if (empty($prenom)) {
        $errors[] = "Le prénom est requis.";
    }

    if (!in_array($type_personne, ['homme', 'femme'])) {
        $errors[] = "Type de personne invalide.";
    }

    if (empty($nationalite)) {
        $errors[] = "La nationalité est requise.";
    }

    if (!empty($date_naissance) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_naissance)) {
        $errors[] = "Format de date de naissance invalide. (Attendu : AAAA-MM-JJ)";
    }

    // Téléchargement de la photo
    if (isset($files['photoInput']) && $files['photoInput']['error'] !== UPLOAD_ERR_NO_FILE) {
        $photo_path = uploadPhoto($files['photoInput'], 'personnes');

        if ($photo_path === false) {
            $errors[] = "Erreur lors du téléchargement de la photo (format ou taille invalide, ou problème technique).";
        }
    }

    // Insertion en base si pas d'erreurs
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO personnes (
                    nom, prenom, type_personne, date_naissance, lieu_naissance, 
                    nationalite, profession, adresse_actuelle, photo
                ) VALUES (
                    :nom, :prenom, :type_personne, :date_naissance, :lieu_naissance,
                    :nationalite, :profession, :adresse_actuelle, :photo
                )
            ");

            $stmt->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'type_personne' => $type_personne,
                'date_naissance' => $date_naissance ?: null,
                'lieu_naissance' => $lieu_naissance ?: null,
                'nationalite' => $nationalite,
                'profession' => $profession ?: null,
                'adresse_actuelle' => $adresse_actuelle ?: null,
                'photo' => $photo_path ?: null,
            ]);

            return [
                'success' => true,
                'message' => 'Personne ajoutée avec succès.',
                'photo_path' => $photo_path
            ];
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de l'enregistrement: " . $e->getMessage();
        }
    }

    return ['success' => false, 'errors' => $errors];
}

function editPerson($pdo, $id_personne, $post_data, $files) {
    $errors = [];
    $photo_path = null;

    // Vérifier si la personne existe
    try {
        $stmt = $pdo->prepare("SELECT * FROM personnes WHERE id_personne = :id");
        $stmt->execute(['id' => $id_personne]);
        $existing_person = $stmt->fetch();

        if (!$existing_person) {
            return ['success' => false, 'errors' => ['Personne non trouvée.']];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'errors' => ['Erreur lors de la récupération des données: ' . $e->getMessage()]];
    }

    // Nettoyage des inputs
    $nom = trim($post_data['nom'] ?? '');
    $prenom = trim($post_data['prenom'] ?? '');
    $type_personne = trim($post_data['type_personne'] ?? '');
    $date_naissance = trim($post_data['date_naissance'] ?? '');
    $lieu_naissance = trim($post_data['lieu_naissance'] ?? '');
    $nationalite = trim($post_data['nationalite'] ?? '');
    $profession = trim($post_data['profession'] ?? '');
    $adresse_actuelle = trim($post_data['adresse_actuelle'] ?? '');
    $remove_photo = isset($post_data['remove_photo']) && $post_data['remove_photo'] === '1';

    // Validation
    if (empty($nom)) {
        $errors[] = "Le nom est requis.";
    }
    if (empty($prenom)) {
        $errors[] = "Le prénom est requis.";
    }
    if (!in_array($type_personne, ['homme', 'femme'])) {
        $errors[] = "Type de personne invalide.";
    }
    if (empty($nationalite)) {
        $errors[] = "La nationalité est requise.";
    }
    if (!empty($date_naissance) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_naissance)) {
        $errors[] = "Format de date de naissance invalide (attendu : AAAA-MM-JJ).";
    }

    // Gestion de la photo
    if ($remove_photo) {
        if (!empty($existing_person['photo']) && file_exists($existing_person['photo'])) {
            unlink($existing_person['photo']);
        }
        $photo_path = null;
    } elseif (isset($files['photoInput']) && $files['photoInput']['error'] !== UPLOAD_ERR_NO_FILE) {
        $photo_path = uploadPhoto($files['photoInput'], 'personnes');

        if ($photo_path === false) {
            $errors[] = "Erreur lors du téléchargement de la photo (format ou taille invalide, ou problème technique).";
        } else {
            if (!empty($existing_person['photo']) && file_exists($existing_person['photo'])) {
                unlink($existing_person['photo']);
            }
        }
    } else {
        // Garder l’ancienne photo
        $photo_path = $existing_person['photo'];
    }

    // Mise à jour si pas d'erreurs
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                UPDATE personnes SET
                    nom = :nom,
                    prenom = :prenom,
                    type_personne = :type_personne,
                    date_naissance = :date_naissance,
                    lieu_naissance = :lieu_naissance,
                    nationalite = :nationalite,
                    profession = :profession,
                    adresse_actuelle = :adresse_actuelle,
                    photo = :photo,
                    date_mise_a_jour = NOW()
                WHERE id_personne = :id
            ");

            $stmt->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'type_personne' => $type_personne,
                'date_naissance' => $date_naissance ?: null,
                'lieu_naissance' => $lieu_naissance ?: null,
                'nationalite' => $nationalite,
                'profession' => $profession ?: null,
                'adresse_actuelle' => $adresse_actuelle ?: null,
                'photo' => $photo_path,
                'id' => $id_personne
            ]);

            return ['success' => true, 'message' => 'Personne modifiée avec succès.', 'photo_path' => $photo_path];
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de la modification: " . $e->getMessage();
        }
    }

    return ['success' => false, 'errors' => $errors];
}

function getAllPersons($pdo, $search = '', $limit = 50, $offset = 0) {
    try {
        // Construction de la requête avec filtres
        $where_conditions = [];
        $params = [];
        
        // Filtre de recherche (nom, prénom, profession)
        if (!empty($search)) {
            $where_conditions[] = "(nom LIKE :search OR prenom LIKE :search OR profession LIKE :search)";
            $params['search'] = '%' . $search . '%';
        }
        
        $where_clause = '';
        if (!empty($where_conditions)) {
            $where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
        }
        
        // Requête principale pour récupérer les personnes
        $sql = "
            SELECT 
                id_personne,
                nom,
                prenom,
                type_personne,
                date_naissance,
                lieu_naissance,
                nationalite,
                profession,
                adresse_actuelle,
                photo,
                date_creation,
                date_mise_a_jour
            FROM personnes 
            {$where_clause}
            ORDER BY nom ASC, prenom ASC
            LIMIT :limit OFFSET :offset
        ";
        
        $stmt = $pdo->prepare($sql);
        
        // Bind des paramètres
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        $persons = $stmt->fetchAll();
        
        // Requête pour compter le total
        $count_sql = "SELECT COUNT(*) as total FROM personnes {$where_clause}";
        $count_stmt = $pdo->prepare($count_sql);
        
        foreach ($params as $key => $value) {
            $count_stmt->bindValue(':' . $key, $value);
        }
        
        $count_stmt->execute();
        $total_count = $count_stmt->fetch()['total'];
        
        return [
            'success' => true,
            'data' => $persons,
            'total_count' => $total_count,
            'current_count' => count($persons)
        ];
        
    } catch (PDOException $e) {
        return [
            'success' => false,
            'error' => 'Erreur lors de la récupération des personnes: ' . $e->getMessage(),
            'data' => [],
            'total_count' => 0,
            'current_count' => 0
        ];
    }
}

function getPersonPhoto($photo_path) {
    if (!empty($photo_path)) {
        return $photo_path;
    }
    return null;
}

function getPersonInitials($nom, $prenom) {
    $nom_initial = !empty($nom) ? strtoupper(substr($nom, 0, 1)) : '';
    $prenom_initial = !empty($prenom) ? strtoupper(substr($prenom, 0, 1)) : '';
    return $nom_initial . $prenom_initial;
}

function formatDate($date_string) {
    if (empty($date_string)) {
        return '-';
    }
    
    try {
        $date = new DateTime($date_string);
        return $date->format('d/m/Y');
    } catch (Exception $e) {
        return '-';
    }
}


function getPersonne($pdo, $id_personne) {
    try {
        $stmt = $pdo->prepare("
            SELECT 
                id_personne,
                nom,
                prenom,
                type_personne,
                date_naissance,
                lieu_naissance,
                nationalite,
                profession,
                adresse_actuelle,
                photo,
                date_creation,
                date_mise_a_jour
            FROM personnes 
            WHERE id_personne = :id
        ");
        $stmt->execute(['id' => $id_personne]);
        $person = $stmt->fetch();
        
        if ($person) {
            return ['success' => true, 'data' => $person];
        } else {
            return ['success' => false, 'error' => 'Personne non trouvée.'];
        }
        
    } catch (PDOException $e) {
        return [
            'success' => false,
            'error' => 'Erreur lors de la récupération: ' . $e->getMessage()
        ];
    }
}
function deletePerson($pdo, $id_personne) {
    $errors = [];
    
    // Vérifier si la personne existe
    try {
        $stmt = $pdo->prepare("SELECT * FROM personnes WHERE id_personne = :id");
        $stmt->execute(['id' => $id_personne]);
        $person = $stmt->fetch();
        
        if (!$person) {
            return ['success' => false, 'errors' => ['Personne non trouvée.']];
        }
        
        if (!empty($person['photo']) && file_exists($person['photo'])) {
            if (!unlink($person['photo'])) {
                $errors[] = "Impossible de supprimer le fichier photo, mais la personne sera supprimée.";
            }
        }
        
        // Supprimer la personne de la base de données
        $stmt = $pdo->prepare("DELETE FROM personnes WHERE id_personne = :id");
        $stmt->execute(['id' => $id_personne]);
        
        return [
            'success' => true,
            'message' => 'Personne supprimée avec succès.',
            'warnings' => $errors 
        ];
        
    } catch (PDOException $e) {
        return [
            'success' => false,
            'errors' => ['Erreur lors de la suppression: ' . $e->getMessage()]
        ];
    }
}

function getAllCommunes($pdo) {
    try {
        $stmt = $pdo->query("SELECT id_commune, nom_commune FROM communes ORDER BY nom_commune ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}
// officiers 
function addOfficier(PDO $pdo, array $post_data): array {
    $errors = [];

    // Extraction et nettoyage des données
    $nom = trim($post_data['nom'] ?? ''); 
    $prenom = trim($post_data['prenom'] ?? '');
    $matricule = trim($post_data['matricule'] ?? '');
    $email = trim($post_data['email'] ?? '');
    $mot_de_passe = $post_data['mot_de_passe'] ?? '';
    $id_commune = filter_var($post_data['id_commune'] ?? '', FILTER_VALIDATE_INT);
    $role = trim($post_data['role'] ?? '');

    // Validation des champs requis
    if (empty($nom)) {
        $errors[] = "Le nom est requis.";
    }
    if (empty($prenom)) {
        $errors[] = "Le prénom est requis.";
    }
    if (empty($email)) {
        $errors[] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email est invalide.";
    }
    if (empty($mot_de_passe)) {
        $errors[] = "Le mot de passe est requis.";
    } elseif (strlen($mot_de_passe) < 6) { // Exemple de validation de longueur minimale
        $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
    }
    if ($id_commune === false || $id_commune <= 0) {
        $errors[] = "L'ID de la commune est invalide.";
    }
    if (!in_array($role, ['admin', 'officier_communal'])) {
        $errors[] = "Le rôle sélectionné est invalide.";
    }

    // Vérifier l'unicité de l'email
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM officiers WHERE email = :email");
            $stmt->execute(['email' => $email]);
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Cet email est déjà utilisé.";
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur de base de données lors de la vérification de l'email: " . $e->getMessage();
        }
    }

    // Insertion en base si aucune erreur
    if (empty($errors)) {
        try {
            $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("
                INSERT INTO officiers (
                    nom, prenom, matricule, email, mot_de_passe, id_commune, role
                ) VALUES (
                    :nom, :prenom, :matricule, :email, :mot_de_passe, :id_commune, :role
                )
            ");

            $stmt->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'matricule' => $matricule ?: null, // Peut être NULL
                'email' => $email,
                'mot_de_passe' => $hashed_password,
                'id_commune' => $id_commune,
                'role' => $role,
            ]);

            return ['success' => true, 'message' => 'Officier ajouté avec succès.'];

        } catch (PDOException $e) {
            $errors[] = "Erreur lors de l'enregistrement de l'officier: " . $e->getMessage();
        }
    }

    return ['success' => false, 'errors' => $errors];
}
function editOfficier(PDO $pdo, int $id_officier, array $post_data): array {
    $errors = [];

    // Vérifier si l'officier existe
    try {
        $stmt = $pdo->prepare("SELECT id_officier, email FROM officiers WHERE id_officier = :id");
        $stmt->execute(['id' => $id_officier]);
        $existing_officer = $stmt->fetch();

        if (!$existing_officer) {
            return ['success' => false, 'errors' => ['Officier non trouvé.']];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'errors' => ['Erreur de base de données lors de la récupération de l\'officier: ' . $e->getMessage()]];
    }
    $nom = trim($post_data['nom'] ?? '');
    $prenom = trim($post_data['prenom'] ?? '');
    $matricule = trim($post_data['matricule'] ?? '');
    $email = trim($post_data['email'] ?? '');
    $mot_de_passe = $post_data['mot_de_passe'] ?? ''; // Peut être vide si non modifié
    $id_commune = filter_var($post_data['id_commune'] ?? '', FILTER_VALIDATE_INT);
    $role = trim($post_data['role'] ?? '');

    // Validation des champs requis
    if (empty($nom)) {
        $errors[] = "Le nom est requis.";
    }
    if (empty($prenom)) {
        $errors[] = "Le prénom est requis.";
    }
    if (empty($email)) {
        $errors[] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email est invalide.";
    }
    if ($id_commune === false || $id_commune <= 0) {
        $errors[] = "L'ID de la commune est invalide.";
    }
    if (!in_array($role, ['admin', 'officier_communal'])) {
        $errors[] = "Le rôle sélectionné est invalide.";
    }

    // Vérifier l'unicité de l'email (si l'email a changé)
    if (empty($errors) && $email !== $existing_officer['email']) {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM officiers WHERE email = :email AND id_officier != :id");
            $stmt->execute(['email' => $email, 'id' => $id_officier]);
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Cet email est déjà utilisé par un autre officier.";
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur de base de données lors de la vérification de l'email: " . $e->getMessage();
        }
    }
    if (empty($errors)) {
        try {
            $sql = "
                UPDATE officiers SET
                    nom = :nom,
                    prenom = :prenom,
                    matricule = :matricule,
                    email = :email,
                    id_commune = :id_commune,
                    role = :role,
                    date_mise_a_jour = NOW()
                WHERE id_officier = :id
            ";
            $params = [
                'nom' => $nom,
                'prenom' => $prenom,
                'matricule' => $matricule ?: null,
                'email' => $email,
                'id_commune' => $id_commune,
                'role' => $role,
                'id' => $id_officier
            ];

            // Si un nouveau mot de passe est fourni, le hacher et l'inclure dans la mise à jour
            if (!empty($mot_de_passe)) {
                if (strlen($mot_de_passe) < 6) {
                    $errors[] = "Le nouveau mot de passe doit contenir au moins 6 caractères.";
                } else {
                    $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
                    $sql = "
                        UPDATE officiers SET
                            nom = :nom,
                            prenom = :prenom,
                            matricule = :matricule,
                            email = :email,
                            mot_de_passe = :mot_de_passe,
                            id_commune = :id_commune,
                            role = :role,
                            date_mise_a_jour = NOW()
                        WHERE id_officier = :id
                    ";
                    $params['mot_de_passe'] = $hashed_password;
                }
            }
            
            // Si des erreurs ont été ajoutées pour le mot de passe, retourner
            if (!empty($errors)) {
                return ['success' => false, 'errors' => $errors];
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            return ['success' => true, 'message' => 'Officier modifié avec succès.'];

        } catch (PDOException $e) {
            $errors[] = "Erreur lors de la modification de l'officier: " . $e->getMessage();
        }
    }

    return ['success' => false, 'errors' => $errors];
}
function getOfficier(PDO $pdo, int $id_officier): array {
    try {
        $stmt = $pdo->prepare("
            SELECT 
                o.id_officier,
                o.nom,
                o.prenom,
                o.matricule,
                o.email,
                o.id_commune,
                c.nom_commune,
                c.district,
                c.province,
                o.role,
                o.date_creation,
                o.date_mise_a_jour
            FROM officiers o
            JOIN communes c ON o.id_commune = c.id_commune
            WHERE o.id_officier = :id
        ");
        $stmt->execute(['id' => $id_officier]);
        $officier = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($officier) {
            return ['success' => true, 'data' => $officier];
        } else {
            return ['success' => false, 'error' => 'Officier non trouvé.'];
        }

    } catch (PDOException $e) {
        return [
            'success' => false,
            'error' => 'Erreur lors de la récupération de l\'officier: ' . $e->getMessage()
        ];
    }
}
function getAllOfficiers(PDO $pdo, string $search = '', int $limit = 50, int $offset = 0): array {
    try {
        $where_conditions = [];
        $params = [];

        // Filtre de recherche
        if (!empty($search)) {
            $where_conditions[] = "(o.nom LIKE :search OR o.prenom LIKE :search OR o.email LIKE :search OR o.matricule LIKE :search OR c.nom_commune LIKE :search)";
            $params['search'] = '%' . $search . '%';
        }

        $where_clause = '';
        if (!empty($where_conditions)) {
            $where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
        }
        $sql = "
            SELECT
                o.id_officier,
                o.nom,
                o.prenom,
                o.matricule,
                o.email,
                o.role,
                c.nom_commune,
                c.district,
                c.province,
                o.date_creation,
                o.date_mise_a_jour
            FROM officiers o
            JOIN communes c ON o.id_commune = c.id_commune
            {$where_clause}
            ORDER BY o.nom ASC, o.prenom ASC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        $officiers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Requête pour le compte total (pour la pagination)
        $count_sql = "
            SELECT COUNT(o.id_officier) as total
            FROM officiers o
            JOIN communes c ON o.id_commune = c.id_commune
            {$where_clause}
        ";
        $count_stmt = $pdo->prepare($count_sql);

        foreach ($params as $key => $value) {
            $count_stmt->bindValue(':' . $key, $value);
        }
        $count_stmt->execute();
        $total_count = $count_stmt->fetch()['total'];

        return [
            'success' => true,
            'data' => $officiers,
            'total_count' => $total_count,
            'current_count' => count($officiers)
        ];

    } catch (PDOException $e) {
        return [
            'success' => false,
            'error' => 'Erreur lors de la récupération des officiers: ' . $e->getMessage(),
            'data' => [],
            'total_count' => 0,
            'current_count' => 0
        ];
    }
}
function deleteOfficier(PDO $pdo, int $id_officier): array {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM officiers WHERE id_officier = :id");
        $stmt->execute(['id' => $id_officier]);
        if ($stmt->fetchColumn() === 0) {
            return ['success' => false, 'errors' => ['Officier non trouvé.']];
        }
        $stmt = $pdo->prepare("DELETE FROM officiers WHERE id_officier = :id");
        $stmt->execute(['id' => $id_officier]);

        if ($stmt->rowCount() > 0) {
            return ['success' => true, 'message' => 'Officier supprimé avec succès.'];
        } else {
            return ['success' => false, 'errors' => ['Aucun officier supprimé (peut-être déjà inexistant).']];
        }

    } catch (PDOException $e) {
        
        if ($e->getCode() === '23000') { 
            return [
                'success' => false,
                'errors' => ['Impossible de supprimer cet officier car il est lié à d\'autres enregistrements (ex: mariages). Supprimez d\'abord les enregistrements liés.'],
                'debug_message' => $e->getMessage()
            ];
        }
        return [
            'success' => false,
            'errors' => ['Erreur lors de la suppression de l\'officier: ' . $e->getMessage()]
        ];
    }
}