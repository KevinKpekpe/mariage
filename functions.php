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