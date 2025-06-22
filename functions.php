<?php
session_start();

function authentifierUtilisateur($pdo, $email, $mot_de_passe) {
    $erreurs = [];
    
    if (empty($email)) {
        $erreurs[] = "L'email est requis.";
    }
    if (empty($mot_de_passe)) {
        $erreurs[] = "Le mot de passe est requis.";
    }

    if (empty($erreurs)) {
        try {
            $stmt = $pdo->prepare("
                SELECT id_officier, email, mot_de_passe, nom, prenom, role, id_commune 
                FROM officiers 
                WHERE email = :email
            ");
            $stmt->execute(['email' => $email]);
            $utilisateur = $stmt->fetch();

            if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
                $_SESSION['user_id'] = $utilisateur['id_officier'];
                $_SESSION['email'] = $utilisateur['email'];
                $_SESSION['nom'] = $utilisateur['nom'];
                $_SESSION['prenom'] = $utilisateur['prenom'];
                $_SESSION['role'] = $utilisateur['role'];
                $_SESSION['id_commune'] = $utilisateur['id_commune'];
                return ['success' => true, 'role' => $utilisateur['role']];
            } else {
                $erreurs[] = "Email ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            $erreurs[] = "Erreur de connexion: " . $e->getMessage();
        }
    }
    
    return ['success' => false, 'errors' => $erreurs];
}

function estConnecte() {
    return isset($_SESSION['user_id']);
}

function aRole($role) {
    return estConnecte() && $_SESSION['role'] === $role;
}

function deconnecter() {
    session_unset();
    session_destroy();
    header('Location: /admin/login.php');
    exit;
}

function telechargerPhoto(array $fichier, string $sous_dossier = 'personnes', int $taille_max = 2 * 1024 * 1024): string|false {
    $types_autorises = ['image/jpeg', 'image/png'];
    $dossier_racine = realpath(__DIR__) . DIRECTORY_SEPARATOR;
    $dossier_upload = $dossier_racine . 'uploads' . DIRECTORY_SEPARATOR . $sous_dossier . DIRECTORY_SEPARATOR;

    // Vérifier fichier
    if ($fichier['error'] !== UPLOAD_ERR_OK || !in_array($fichier['type'], $types_autorises) || $fichier['size'] > $taille_max) {
        return false;
    }

    // Créer dossier si besoin
    if (!is_dir($dossier_upload)) {
        mkdir($dossier_upload, 0755, true);
    }

    $nom_fichier = uniqid() . '_' . basename($fichier['name']);
    $destination = $dossier_upload . $nom_fichier;

    if (!move_uploaded_file($fichier['tmp_name'], $destination)) {
        return false;
    }

    // Chemin relatif depuis la racine du projet
    return 'uploads/' . $sous_dossier . '/' . $nom_fichier;
}

function ajouterPersonne($pdo, $donnees_post, $fichiers, $dossier_upload = 'uploads/') {
    $erreurs = [];
    $chemin_photo = null;

    // Extraction & nettoyage de base
    $nom = trim($donnees_post['nom'] ?? '');
    $prenom = trim($donnees_post['prenom'] ?? '');
    $type_personne = trim($donnees_post['type_personne'] ?? '');
    $date_naissance = trim($donnees_post['date_naissance'] ?? '');
    $lieu_naissance = trim($donnees_post['lieu_naissance'] ?? '');
    $nationalite = trim($donnees_post['nationalite'] ?? '');
    $profession = trim($donnees_post['profession'] ?? '');
    $adresse_actuelle = trim($donnees_post['adresse_actuelle'] ?? '');

    // Validation
    if (empty($nom)) {
        $erreurs[] = "Le nom est requis.";
    }

    if (empty($prenom)) {
        $erreurs[] = "Le prénom est requis.";
    }

    if (!in_array($type_personne, ['homme', 'femme'])) {
        $erreurs[] = "Type de personne invalide.";
    }

    if (empty($nationalite)) {
        $erreurs[] = "La nationalité est requise.";
    }

    if (!empty($date_naissance) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_naissance)) {
        $erreurs[] = "Format de date de naissance invalide. (Attendu : AAAA-MM-JJ)";
    }

    // Téléchargement de la photo
    if (isset($fichiers['photoInput']) && $fichiers['photoInput']['error'] !== UPLOAD_ERR_NO_FILE) {
        $chemin_photo = telechargerPhoto($fichiers['photoInput'], 'personnes');

        if ($chemin_photo === false) {
            $erreurs[] = "Erreur lors du téléchargement de la photo (format ou taille invalide, ou problème technique).";
        }
    }

    // Insertion en base si pas d'erreurs
    if (empty($erreurs)) {
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
                'photo' => $chemin_photo ?: null,
            ]);

            return [
                'success' => true,
                'message' => 'Personne ajoutée avec succès.',
                'photo_path' => $chemin_photo
            ];
        } catch (PDOException $e) {
            $erreurs[] = "Erreur lors de l'enregistrement: " . $e->getMessage();
        }
    }

    return ['success' => false, 'errors' => $erreurs];
}

function modifierPersonne($pdo, $id_personne, $donnees_post, $fichiers) {
    $erreurs = [];
    $chemin_photo = null;

    // Vérifier si la personne existe
    try {
        $stmt = $pdo->prepare("SELECT * FROM personnes WHERE id_personne = :id");
        $stmt->execute(['id' => $id_personne]);
        $personne_existante = $stmt->fetch();

        if (!$personne_existante) {
            return ['success' => false, 'errors' => ['Personne non trouvée.']];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'errors' => ['Erreur lors de la récupération des données: ' . $e->getMessage()]];
    }

    // Nettoyage des inputs
    $nom = trim($donnees_post['nom'] ?? '');
    $prenom = trim($donnees_post['prenom'] ?? '');
    $type_personne = trim($donnees_post['type_personne'] ?? '');
    $date_naissance = trim($donnees_post['date_naissance'] ?? '');
    $lieu_naissance = trim($donnees_post['lieu_naissance'] ?? '');
    $nationalite = trim($donnees_post['nationalite'] ?? '');
    $profession = trim($donnees_post['profession'] ?? '');
    $adresse_actuelle = trim($donnees_post['adresse_actuelle'] ?? '');
    $supprimer_photo = isset($donnees_post['remove_photo']) && $donnees_post['remove_photo'] === '1';

    // Validation
    if (empty($nom)) {
        $erreurs[] = "Le nom est requis.";
    }
    if (empty($prenom)) {
        $erreurs[] = "Le prénom est requis.";
    }
    if (!in_array($type_personne, ['homme', 'femme'])) {
        $erreurs[] = "Type de personne invalide.";
    }
    if (empty($nationalite)) {
        $erreurs[] = "La nationalité est requise.";
    }
    if (!empty($date_naissance) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_naissance)) {
        $erreurs[] = "Format de date de naissance invalide (attendu : AAAA-MM-JJ).";
    }

    // Gestion de la photo
    if ($supprimer_photo) {
        if (!empty($personne_existante['photo']) && file_exists($personne_existante['photo'])) {
            unlink($personne_existante['photo']);
        }
        $chemin_photo = null;
    } elseif (isset($fichiers['photoInput']) && $fichiers['photoInput']['error'] !== UPLOAD_ERR_NO_FILE) {
        $chemin_photo = telechargerPhoto($fichiers['photoInput'], 'personnes');

        if ($chemin_photo === false) {
            $erreurs[] = "Erreur lors du téléchargement de la photo (format ou taille invalide, ou problème technique).";
        } else {
            if (!empty($personne_existante['photo']) && file_exists($personne_existante['photo'])) {
                unlink($personne_existante['photo']);
            }
        }
    } else {
        // Garder l'ancienne photo
        $chemin_photo = $personne_existante['photo'];
    }

    // Mise à jour si pas d'erreurs
    if (empty($erreurs)) {
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
                'photo' => $chemin_photo,
                'id' => $id_personne
            ]);

            return ['success' => true, 'message' => 'Personne modifiée avec succès.', 'photo_path' => $chemin_photo];
        } catch (PDOException $e) {
            $erreurs[] = "Erreur lors de la modification: " . $e->getMessage();
        }
    }

    return ['success' => false, 'errors' => $erreurs];
}

function obtenirToutesPersonnes($pdo, $recherche = '', $limite = 50, $decalage = 0) {
    try {
        // Construction de la requête avec filtres
        $conditions_where = [];
        $parametres = [];
        
        // Filtre de recherche (nom, prénom, profession)
        if (!empty($recherche)) {
            $conditions_where[] = "(nom LIKE :recherche OR prenom LIKE :recherche OR profession LIKE :recherche)";
            $parametres['recherche'] = '%' . $recherche . '%';
        }
        
        $clause_where = '';
        if (!empty($conditions_where)) {
            $clause_where = 'WHERE ' . implode(' AND ', $conditions_where);
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
            {$clause_where}
            ORDER BY nom ASC, prenom ASC
            LIMIT :limite OFFSET :decalage
        ";
        
        $stmt = $pdo->prepare($sql);
        
        // Bind des paramètres
        foreach ($parametres as $cle => $valeur) {
            $stmt->bindValue(':' . $cle, $valeur);
        }
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':decalage', $decalage, PDO::PARAM_INT);
        
        $stmt->execute();
        $personnes = $stmt->fetchAll();
        
        // Requête pour compter le total
        $sql_comptage = "SELECT COUNT(*) as total FROM personnes {$clause_where}";
        $stmt_comptage = $pdo->prepare($sql_comptage);
        
        foreach ($parametres as $cle => $valeur) {
            $stmt_comptage->bindValue(':' . $cle, $valeur);
        }
        
        $stmt_comptage->execute();
        $nombre_total = $stmt_comptage->fetch()['total'];
        
        return [
            'success' => true,
            'data' => $personnes,
            'total_count' => $nombre_total,
            'current_count' => count($personnes)
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

function obtenirPhotoPersonne($chemin_photo) {
    if (!empty($chemin_photo)) {
        return $chemin_photo;
    }
    return null;
}

function obtenirInitialesPersonne($nom, $prenom) {
    $initial_nom = !empty($nom) ? strtoupper(substr($nom, 0, 1)) : '';
    $initial_prenom = !empty($prenom) ? strtoupper(substr($prenom, 0, 1)) : '';
    return $initial_nom . $initial_prenom;
}

function formaterDate($chaine_date) {
    if (empty($chaine_date)) {
        return '-';
    }
    
    try {
        $date = new DateTime($chaine_date);
        return $date->format('d/m/Y');
    } catch (Exception $e) {
        return '-';
    }
}

function obtenirPersonne($pdo, $id_personne) {
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
        $personne = $stmt->fetch();
        
        if ($personne) {
            return ['success' => true, 'data' => $personne];
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

function supprimerPersonne($pdo, $id_personne) {
    $erreurs = [];
    
    // Vérifier si la personne existe
    try {
        $stmt = $pdo->prepare("SELECT * FROM personnes WHERE id_personne = :id");
        $stmt->execute(['id' => $id_personne]);
        $personne = $stmt->fetch();
        
        if (!$personne) {
            return ['success' => false, 'errors' => ['Personne non trouvée.']];
        }
        
        if (!empty($personne['photo']) && file_exists($personne['photo'])) {
            if (!unlink($personne['photo'])) {
                $erreurs[] = "Impossible de supprimer le fichier photo, mais la personne sera supprimée.";
            }
        }
        
        // Supprimer la personne de la base de données
        $stmt = $pdo->prepare("DELETE FROM personnes WHERE id_personne = :id");
        $stmt->execute(['id' => $id_personne]);
        
        return [
            'success' => true,
            'message' => 'Personne supprimée avec succès.',
            'warnings' => $erreurs 
        ];
        
    } catch (PDOException $e) {
        return [
            'success' => false,
            'errors' => ['Erreur lors de la suppression: ' . $e->getMessage()]
        ];
    }
}

function obtenirToutesCommunes($pdo) {
    try {
        $stmt = $pdo->query("SELECT id_commune, nom_commune FROM communes ORDER BY nom_commune ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// officiers 
function ajouterOfficier(PDO $pdo, array $donnees_post): array {
    $erreurs = [];

    // Extraction et nettoyage des données
    $nom = trim($donnees_post['nom'] ?? ''); 
    $prenom = trim($donnees_post['prenom'] ?? '');
    $matricule = trim($donnees_post['matricule'] ?? '');
    $email = trim($donnees_post['email'] ?? '');
    $mot_de_passe = $donnees_post['mot_de_passe'] ?? '';
    $id_commune = filter_var($donnees_post['id_commune'] ?? '', FILTER_VALIDATE_INT);
    $role = trim($donnees_post['role'] ?? '');

    // Validation des champs requis
    if (empty($nom)) {
        $erreurs[] = "Le nom est requis.";
    }
    if (empty($prenom)) {
        $erreurs[] = "Le prénom est requis.";
    }
    if (empty($email)) {
        $erreurs[] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email est invalide.";
    }
    if (empty($mot_de_passe)) {
        $erreurs[] = "Le mot de passe est requis.";
    } elseif (strlen($mot_de_passe) < 6) { // Exemple de validation de longueur minimale
        $erreurs[] = "Le mot de passe doit contenir au moins 6 caractères.";
    }
    if ($id_commune === false || $id_commune <= 0) {
        $erreurs[] = "L'ID de la commune est invalide.";
    }
    if (!in_array($role, ['admin', 'officier_communal'])) {
        $erreurs[] = "Le rôle sélectionné est invalide.";
    }

    // Vérifier l'unicité de l'email
    if (empty($erreurs)) {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM officiers WHERE email = :email");
            $stmt->execute(['email' => $email]);
            if ($stmt->fetchColumn() > 0) {
                $erreurs[] = "Cet email est déjà utilisé.";
            }
        } catch (PDOException $e) {
            $erreurs[] = "Erreur de base de données lors de la vérification de l'email: " . $e->getMessage();
        }
    }

    // Insertion en base si aucune erreur
    if (empty($erreurs)) {
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
            $erreurs[] = "Erreur lors de l'enregistrement de l'officier: " . $e->getMessage();
        }
    }

    return ['success' => false, 'errors' => $erreurs];
}

function modifierOfficier(PDO $pdo, int $id_officier, array $donnees_post): array {
    $erreurs = [];

    // Vérifier si l'officier existe
    try {
        $stmt = $pdo->prepare("SELECT id_officier, email FROM officiers WHERE id_officier = :id");
        $stmt->execute(['id' => $id_officier]);
        $officier_existant = $stmt->fetch();

        if (!$officier_existant) {
            return ['success' => false, 'errors' => ['Officier non trouvé.']];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'errors' => ['Erreur de base de données lors de la récupération de l\'officier: ' . $e->getMessage()]];
    }
    $nom = trim($donnees_post['nom'] ?? '');
    $prenom = trim($donnees_post['prenom'] ?? '');
    $matricule = trim($donnees_post['matricule'] ?? '');
    $email = trim($donnees_post['email'] ?? '');
    $mot_de_passe = $donnees_post['mot_de_passe'] ?? ''; // Peut être vide si non modifié
    $id_commune = filter_var($donnees_post['id_commune'] ?? '', FILTER_VALIDATE_INT);
    $role = trim($donnees_post['role'] ?? '');

    // Validation des champs requis
    if (empty($nom)) {
        $erreurs[] = "Le nom est requis.";
    }
    if (empty($prenom)) {
        $erreurs[] = "Le prénom est requis.";
    }
    if (empty($email)) {
        $erreurs[] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email est invalide.";
    }
    if ($id_commune === false || $id_commune <= 0) {
        $erreurs[] = "L'ID de la commune est invalide.";
    }
    if (!in_array($role, ['admin', 'officier_communal'])) {
        $erreurs[] = "Le rôle sélectionné est invalide.";
    }

    // Vérifier l'unicité de l'email (si l'email a changé)
    if (empty($erreurs) && $email !== $officier_existant['email']) {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM officiers WHERE email = :email AND id_officier != :id");
            $stmt->execute(['email' => $email, 'id' => $id_officier]);
            if ($stmt->fetchColumn() > 0) {
                $erreurs[] = "Cet email est déjà utilisé par un autre officier.";
            }
        } catch (PDOException $e) {
            $erreurs[] = "Erreur de base de données lors de la vérification de l'email: " . $e->getMessage();
        }
    }
    if (empty($erreurs)) {
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
            $parametres = [
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
                    $erreurs[] = "Le nouveau mot de passe doit contenir au moins 6 caractères.";
                } else {
                    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);
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
                    $parametres['mot_de_passe'] = $mot_de_passe_hache;
                }
            }
            
            // Si des erreurs ont été ajoutées pour le mot de passe, retourner
            if (!empty($erreurs)) {
                return ['success' => false, 'errors' => $erreurs];
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute($parametres);

            return ['success' => true, 'message' => 'Officier modifié avec succès.'];

        } catch (PDOException $e) {
            $erreurs[] = "Erreur lors de la modification de l'officier: " . $e->getMessage();
        }
    }

    return ['success' => false, 'errors' => $erreurs];
}

function obtenirOfficier(PDO $pdo, int $id_officier): array {
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

function obtenirTousOfficiers(PDO $pdo, string $recherche = '', int $limite = 50, int $decalage = 0): array {
    try {
        $conditions_where = [];
        $parametres = [];

        // Filtre de recherche
        if (!empty($recherche)) {
            $conditions_where[] = "(o.nom LIKE :recherche OR o.prenom LIKE :recherche OR o.email LIKE :recherche OR o.matricule LIKE :recherche OR c.nom_commune LIKE :recherche)";
            $parametres['recherche'] = '%' . $recherche . '%';
        }

        $clause_where = '';
        if (!empty($conditions_where)) {
            $clause_where = 'WHERE ' . implode(' AND ', $conditions_where);
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
            {$clause_where}
            ORDER BY o.nom ASC, o.prenom ASC
            LIMIT :limite OFFSET :decalage
        ";

        $stmt = $pdo->prepare($sql);

        foreach ($parametres as $cle => $valeur) {
            $stmt->bindValue(':' . $cle, $valeur);
        }
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':decalage', $decalage, PDO::PARAM_INT);

        $stmt->execute();
        $officiers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Requête pour le compte total (pour la pagination)
        $count_sql = "
            SELECT COUNT(o.id_officier) as total
            FROM officiers o
            JOIN communes c ON o.id_commune = c.id_commune
            {$clause_where}
        ";
        $count_stmt = $pdo->prepare($count_sql);

        foreach ($parametres as $cle => $valeur) {
            $count_stmt->bindValue(':' . $cle, $valeur);
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

function supprimerOfficier(PDO $pdo, int $id_officier): array {
    try {
        // Vérifier si l'officier existe
        $stmt = $pdo->prepare("SELECT id_officier FROM officiers WHERE id_officier = :id");
        $stmt->execute(['id' => $id_officier]);
        
        if (!$stmt->fetch()) {
            return ['success' => false, 'errors' => ['Officier non trouvé.']];
        }

        // Supprimer l'officier
        $stmt = $pdo->prepare("DELETE FROM officiers WHERE id_officier = :id");
        $stmt->execute(['id' => $id_officier]);

        return ['success' => true, 'message' => 'Officier supprimé avec succès.'];

    } catch (PDOException $e) {
        return [
            'success' => false,
            'errors' => ['Erreur lors de la suppression de l\'officier: ' . $e->getMessage()]
        ];
    }
}

function ajouterMariage(PDO $pdo, array $donnees_post, array $donnees_session): array {
    $erreurs = [];

    // Extraction et validation des données du formulaire
    $numero_acte_mariage = trim($donnees_post['numero_acte_mariage'] ?? '');
    $date_celebration = trim($donnees_post['date_celebration'] ?? '');
    $heure_celebration = trim($donnees_post['heure_celebration'] ?? '');
    $id_epoux = filter_var($donnees_post['id_epoux'] ?? '', FILTER_VALIDATE_INT);
    $id_epouse = filter_var($donnees_post['id_epouse'] ?? '', FILTER_VALIDATE_INT);
    $regime_matrimonial = trim($donnees_post['regime_matrimonial'] ?? '');
    $nom_complet_temoin_1 = trim($donnees_post['nom_complet_temoin_1'] ?? '');
    $nom_complet_temoin_2 = trim($donnees_post['nom_complet_temoin_2'] ?? '');

    // L'officier et la commune sont déterminés par l'utilisateur connecté
    $id_officier_celebration = $donnees_session['user_id'] ?? null;
    $id_commune_celebration = $donnees_session['id_commune'] ?? null;
    
    // Validation
    if (empty($numero_acte_mariage)) $erreurs[] = "Le numéro d'acte est requis.";
    if (empty($date_celebration)) $erreurs[] = "La date de célébration est requise.";
    if (empty($heure_celebration)) $erreurs[] = "L'heure de célébration est requise.";
    if (!$id_epoux) $erreurs[] = "L'époux est invalide.";
    if (!$id_epouse) $erreurs[] = "L'épouse est invalide.";
    if ($id_epoux === $id_epouse) $erreurs[] = "L'époux et l'épouse ne peuvent pas être la même personne.";
    if (empty($regime_matrimonial)) $erreurs[] = "Le régime matrimonial est requis.";
    if (!$id_officier_celebration) $erreurs[] = "Impossible de récupérer l'officier de célébration (session invalide).";
    if (!$id_commune_celebration) $erreurs[] = "Impossible de récupérer la commune de célébration (session invalide).";
    if (empty($nom_complet_temoin_1)) $erreurs[] = "Le nom du témoin 1 est requis.";
    if (empty($nom_complet_temoin_2)) $erreurs[] = "Le nom du témoin 2 est requis.";

    // Vérifier l'unicité du numéro d'acte
    if (empty($erreurs)) {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM mariages WHERE numero_acte_mariage = :num");
            $stmt->execute(['num' => $numero_acte_mariage]);
            if ($stmt->fetchColumn() > 0) {
                $erreurs[] = "Ce numéro d'acte de mariage existe déjà.";
            }
        } catch (PDOException $e) {
            $erreurs[] = "Erreur de base de données : " . $e->getMessage();
        }
    }
    
    if (empty($erreurs)) {
        $pdo->beginTransaction();
        try {
            // Insérer dans la table `mariages`
            $stmt = $pdo->prepare("
                INSERT INTO mariages (
                    numero_acte_mariage, date_celebration, heure_celebration,
                    id_officier_celebration, id_commune_celebration,
                    nom_complet_temoin_1, nom_complet_temoin_2, regime_matrimonial
                ) VALUES (
                    :numero_acte_mariage, :date_celebration, :heure_celebration,
                    :id_officier_celebration, :id_commune_celebration,
                    :nom_complet_temoin_1, :nom_complet_temoin_2, :regime_matrimonial
                )
            ");
            $stmt->execute([
                'numero_acte_mariage' => $numero_acte_mariage,
                'date_celebration' => $date_celebration,
                'heure_celebration' => $heure_celebration,
                'id_officier_celebration' => $id_officier_celebration,
                'id_commune_celebration' => $id_commune_celebration,
                'nom_complet_temoin_1' => $nom_complet_temoin_1,
                'nom_complet_temoin_2' => $nom_complet_temoin_2,
                'regime_matrimonial' => $regime_matrimonial,
            ]);
            $id_mariage = $pdo->lastInsertId();

            // Insérer l'époux dans `epoux_mariage`
            $stmt = $pdo->prepare("
                INSERT INTO epoux_mariage (id_mariage, id_personne, type_role)
                VALUES (:id_mariage, :id_personne, 'époux')
            ");
            $stmt->execute(['id_mariage' => $id_mariage, 'id_personne' => $id_epoux]);

            // Insérer l'épouse dans `epoux_mariage`
            $stmt = $pdo->prepare("
                INSERT INTO epoux_mariage (id_mariage, id_personne, type_role)
                VALUES (:id_mariage, :id_personne, 'épouse')
            ");
            $stmt->execute(['id_mariage' => $id_mariage, 'id_personne' => $id_epouse]);

            $pdo->commit();
            return ['success' => true, 'message' => 'Mariage ajouté avec succès.'];

        } catch (PDOException $e) {
            $pdo->rollBack();
            $erreurs[] = "Erreur lors de l'enregistrement du mariage: " . $e->getMessage();
        }
    }

    return ['success' => false, 'errors' => $erreurs];
}

function modifierMariage(PDO $pdo, int $id_mariage, array $donnees_post, array $session_data): array {
    $erreurs = [];

    // Extraction et validation
    $numero_acte_mariage = trim($donnees_post['numero_acte_mariage'] ?? '');
    $date_celebration = trim($donnees_post['date_celebration'] ?? '');
    $heure_celebration = trim($donnees_post['heure_celebration'] ?? '');
    $id_epoux = filter_var($donnees_post['id_epoux'] ?? '', FILTER_VALIDATE_INT);
    $id_epouse = filter_var($donnees_post['id_epouse'] ?? '', FILTER_VALIDATE_INT);
    $regime_matrimonial = trim($donnees_post['regime_matrimonial'] ?? '');
    $nom_complet_temoin_1 = trim($donnees_post['nom_complet_temoin_1'] ?? '');
    $nom_complet_temoin_2 = trim($donnees_post['nom_complet_temoin_2'] ?? '');

    $id_officier_celebration = $session_data['user_id'] ?? null;
    $id_commune_celebration = $session_data['id_commune'] ?? null;

    if (empty($numero_acte_mariage)) $erreurs[] = "Le numéro d'acte est requis.";
    if (empty($date_celebration)) $erreurs[] = "La date de célébration est requise.";
    if (empty($heure_celebration)) $erreurs[] = "L'heure de célébration est requise.";
    if (!$id_epoux) $erreurs[] = "L'époux est invalide.";
    if (!$id_epouse) $erreurs[] = "L'épouse est invalide.";
    if (empty($regime_matrimonial)) $erreurs[] = "Le régime matrimonial est requis.";
    if (!$id_officier_celebration) $erreurs[] = "L'officier de célébration est invalide.";
    if (!$id_commune_celebration) $erreurs[] = "La commune de célébration est invalide.";

    // Vérifier l'unicité du numéro d'acte (sauf pour le mariage actuel)
    if (empty($erreurs)) {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM mariages WHERE numero_acte_mariage = :num AND id_mariage != :id");
            $stmt->execute(['num' => $numero_acte_mariage, 'id' => $id_mariage]);
            if ($stmt->fetchColumn() > 0) {
                $erreurs[] = "Ce numéro d'acte de mariage est déjà utilisé par un autre mariage.";
            }
        } catch (PDOException $e) {
            $erreurs[] = "Erreur de base de données : " . $e->getMessage();
        }
    }

    if (empty($erreurs)) {
        $pdo->beginTransaction();
        try {
            // Mettre à jour la table `mariages`
            $stmt = $pdo->prepare("
                UPDATE mariages SET
                    numero_acte_mariage = :numero_acte_mariage,
                    date_celebration = :date_celebration,
                    heure_celebration = :heure_celebration,
                    id_officier_celebration = :id_officier_celebration,
                    id_commune_celebration = :id_commune_celebration,
                    nom_complet_temoin_1 = :nom_complet_temoin_1,
                    nom_complet_temoin_2 = :nom_complet_temoin_2,
                    regime_matrimonial = :regime_matrimonial,
                    date_mise_a_jour = NOW()
                WHERE id_mariage = :id_mariage
            ");
            $stmt->execute([
                'numero_acte_mariage' => $numero_acte_mariage,
                'date_celebration' => $date_celebration,
                'heure_celebration' => $heure_celebration,
                'id_officier_celebration' => $id_officier_celebration,
                'id_commune_celebration' => $id_commune_celebration,
                'nom_complet_temoin_1' => $nom_complet_temoin_1,
                'nom_complet_temoin_2' => $nom_complet_temoin_2,
                'regime_matrimonial' => $regime_matrimonial,
                'id_mariage' => $id_mariage
            ]);

            // Mettre à jour les époux (supprimer les anciens et insérer les nouveaux)
            $stmt = $pdo->prepare("DELETE FROM epoux_mariage WHERE id_mariage = :id_mariage");
            $stmt->execute(['id_mariage' => $id_mariage]);

            $stmt_epoux = $pdo->prepare("INSERT INTO epoux_mariage (id_mariage, id_personne, type_role) VALUES (:id_mariage, :id_personne, 'époux')");
            $stmt_epoux->execute(['id_mariage' => $id_mariage, 'id_personne' => $id_epoux]);

            $stmt_epouse = $pdo->prepare("INSERT INTO epoux_mariage (id_mariage, id_personne, type_role) VALUES (:id_mariage, :id_personne, 'épouse')");
            $stmt_epouse->execute(['id_mariage' => $id_mariage, 'id_personne' => $id_epouse]);

            $pdo->commit();
            return ['success' => true, 'message' => 'Mariage modifié avec succès.'];

        } catch (PDOException $e) {
            $pdo->rollBack();
            $erreurs[] = "Erreur lors de la modification du mariage: " . $e->getMessage();
        }
    }

    return ['success' => false, 'errors' => $erreurs];
}

function obtenirTousMariages(PDO $pdo, string $recherche = '', int $limite = 50, int $decalage = 0): array {
    try {
        $parametres = [];
        $clause_where = '';

        if (!empty($recherche)) {
            $clause_where = "WHERE m.numero_acte_mariage LIKE :recherche 
                            OR p_epoux.nom LIKE :recherche OR p_epoux.prenom LIKE :recherche
                            OR p_epouse.nom LIKE :recherche OR p_epouse.prenom LIKE :recherche
                            OR c.nom_commune LIKE :recherche";
            $parametres['recherche'] = '%' . $recherche . '%';
        }

        $sql = "
            SELECT 
                m.id_mariage,
                m.numero_acte_mariage,
                m.date_celebration,
                m.heure_celebration,
                m.regime_matrimonial,
                m.etat_acte,
                m.date_creation,
                m.date_mise_a_jour,
                p_epoux.nom as nom_epoux,
                p_epoux.prenom as prenom_epoux,
                p_epoux.photo as photo_epoux,
                p_epouse.nom as nom_epouse,
                p_epouse.prenom as prenom_epouse,
                p_epouse.photo as photo_epouse,
                c.nom_commune,
                o.nom as nom_officier,
                o.prenom as prenom_officier
            FROM mariages m
            LEFT JOIN epoux_mariage em_epoux ON m.id_mariage = em_epoux.id_mariage AND em_epoux.type_role = 'époux'
            LEFT JOIN personnes p_epoux ON em_epoux.id_personne = p_epoux.id_personne
            LEFT JOIN epoux_mariage em_epouse ON m.id_mariage = em_epouse.id_mariage AND em_epouse.type_role = 'épouse'
            LEFT JOIN personnes p_epouse ON em_epouse.id_personne = p_epouse.id_personne
            LEFT JOIN communes c ON m.id_commune_celebration = c.id_commune
            LEFT JOIN officiers o ON m.id_officier_celebration = o.id_officier
            {$clause_where}
            ORDER BY m.date_celebration DESC, m.date_creation DESC
            LIMIT :limite OFFSET :decalage
        ";

        $stmt = $pdo->prepare($sql);
        
        foreach ($parametres as $cle => $valeur) {
            $stmt->bindValue(':' . $cle, $valeur);
        }
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':decalage', $decalage, PDO::PARAM_INT);
        
        $stmt->execute();
        $mariages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Compter le total
        $sql_comptage = "
            SELECT COUNT(*) as total
            FROM mariages m
            LEFT JOIN epoux_mariage em_epoux ON m.id_mariage = em_epoux.id_mariage AND em_epoux.type_role = 'époux'
            LEFT JOIN personnes p_epoux ON em_epoux.id_personne = p_epoux.id_personne
            LEFT JOIN epoux_mariage em_epouse ON m.id_mariage = em_epouse.id_mariage AND em_epouse.type_role = 'épouse'
            LEFT JOIN personnes p_epouse ON em_epouse.id_personne = p_epouse.id_personne
            LEFT JOIN communes c ON m.id_commune_celebration = c.id_commune
            {$clause_where}
        ";
        
        $stmt_comptage = $pdo->prepare($sql_comptage);
        foreach ($parametres as $cle => $valeur) {
            $stmt_comptage->bindValue(':' . $cle, $valeur);
        }
        $stmt_comptage->execute();
        $nombre_total = $stmt_comptage->fetch()['total'];

        return [
            'success' => true,
            'data' => $mariages,
            'total_count' => $nombre_total,
            'current_count' => count($mariages)
        ];

    } catch (PDOException $e) {
        return [
            'success' => false,
            'error' => 'Erreur lors de la récupération des mariages: ' . $e->getMessage(),
            'data' => [],
            'total_count' => 0,
            'current_count' => 0
        ];
    }
}

function obtenirMariage(PDO $pdo, int $id_mariage): array {
    try {
        $stmt = $pdo->prepare("
            SELECT 
                m.*,
                c.nom_commune,
                o.nom as nom_officier,
                o.prenom as prenom_officier
            FROM mariages m
            LEFT JOIN communes c ON m.id_commune_celebration = c.id_commune
            LEFT JOIN officiers o ON m.id_officier_celebration = o.id_officier
            WHERE m.id_mariage = :id
        ");
        $stmt->execute(['id' => $id_mariage]);
        $mariage = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($mariage) {
            return ['success' => true, 'data' => $mariage];
        } else {
            return ['success' => false, 'error' => 'Mariage non trouvé.'];
        }

    } catch (PDOException $e) {
        return [
            'success' => false,
            'error' => 'Erreur lors de la récupération du mariage: ' . $e->getMessage()
        ];
    }
}

function supprimerMariage(PDO $pdo, int $id_mariage): array {
    try {
        $pdo->beginTransaction();

        // Supprimer les époux du mariage
        $stmt = $pdo->prepare("DELETE FROM epoux_mariage WHERE id_mariage = :id");
        $stmt->execute(['id' => $id_mariage]);

        // Supprimer le mariage
        $stmt = $pdo->prepare("DELETE FROM mariages WHERE id_mariage = :id");
        $stmt->execute(['id' => $id_mariage]);

        $pdo->commit();
        return ['success' => true, 'message' => 'Mariage supprimé avec succès.'];

    } catch (PDOException $e) {
        $pdo->rollBack();
        return [
            'success' => false,
            'errors' => ['Erreur lors de la suppression du mariage: ' . $e->getMessage()]
        ];
    }
}

function obtenirPersonnesParType(PDO $pdo, string $type): array {
    try {
        $stmt = $pdo->prepare("
            SELECT id_personne, nom, prenom, photo 
            FROM personnes 
            WHERE type_personne = :type 
            ORDER BY nom ASC, prenom ASC
        ");
        $stmt->execute(['type' => $type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function obtenirDetailsMariage(PDO $pdo, int $id_mariage): array {
    try {
        // Récupérer les informations du mariage
        $stmt = $pdo->prepare("
            SELECT 
                m.*,
                c.nom_commune,
                c.district,
                c.province,
                o.nom as nom_officier,
                o.prenom as prenom_officier,
                o.matricule as matricule_officier
            FROM mariages m
            LEFT JOIN communes c ON m.id_commune_celebration = c.id_commune
            LEFT JOIN officiers o ON m.id_officier_celebration = o.id_officier
            WHERE m.id_mariage = :id
        ");
        $stmt->execute(['id' => $id_mariage]);
        $mariage = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$mariage) {
            return ['success' => false, 'error' => 'Mariage non trouvé.'];
        }

        // Récupérer les époux
        $stmt = $pdo->prepare("
            SELECT 
                p.*,
                em.type_role
            FROM epoux_mariage em
            JOIN personnes p ON em.id_personne = p.id_personne
            WHERE em.id_mariage = :id
            ORDER BY em.type_role
        ");
        $stmt->execute(['id' => $id_mariage]);
        $epoux = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'success' => true,
            'data' => [
                'mariage' => $mariage,
                'epoux' => $epoux
            ]
        ];

    } catch (PDOException $e) {
        return [
            'success' => false,
            'error' => 'Erreur lors de la récupération des détails: ' . $e->getMessage()
        ];
    }
}

function obtenirMariagesRecents(PDO $pdo, int $limite = 3): array {
    try {
        $stmt = $pdo->prepare("
            SELECT 
                m.id_mariage,
                m.numero_acte_mariage,
                m.date_celebration,
                m.heure_celebration,
                m.etat_acte,
                p_epoux.nom as nom_epoux,
                p_epoux.prenom as prenom_epoux,
                p_epoux.photo as photo_epoux,
                p_epouse.nom as nom_epouse,
                p_epouse.prenom as prenom_epouse,
                p_epouse.photo as photo_epouse,
                c.nom_commune
            FROM mariages m
            LEFT JOIN epoux_mariage em_epoux ON m.id_mariage = em_epoux.id_mariage AND em_epoux.type_role = 'époux'
            LEFT JOIN personnes p_epoux ON em_epoux.id_personne = p_epoux.id_personne
            LEFT JOIN epoux_mariage em_epouse ON m.id_mariage = em_epouse.id_mariage AND em_epouse.type_role = 'épouse'
            LEFT JOIN personnes p_epouse ON em_epouse.id_personne = p_epouse.id_personne
            LEFT JOIN communes c ON m.id_commune_celebration = c.id_commune
            WHERE m.date_celebration >= CURDATE()
            ORDER BY m.date_celebration ASC
            LIMIT :limite
        ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        $mariages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return ['success' => true, 'data' => $mariages];

    } catch (PDOException $e) {
        return [
            'success' => false,
            'error' => 'Erreur lors de la récupération des mariages récents: ' . $e->getMessage(),
            'data' => []
        ];
    }
}

function obtenirMariagesPourAnnonces(PDO $pdo, int $limite = 20, int $decalage = 0): array {
    try {
        $stmt = $pdo->prepare("
            SELECT 
                m.id_mariage,
                m.numero_acte_mariage,
                m.date_celebration,
                m.heure_celebration,
                m.etat_acte,
                p_epoux.nom as nom_epoux,
                p_epoux.prenom as prenom_epoux,
                p_epoux.photo as photo_epoux,
                p_epouse.nom as nom_epouse,
                p_epouse.prenom as prenom_epouse,
                p_epouse.photo as photo_epouse,
                c.nom_commune
            FROM mariages m
            LEFT JOIN epoux_mariage em_epoux ON m.id_mariage = em_epoux.id_mariage AND em_epoux.type_role = 'époux'
            LEFT JOIN personnes p_epoux ON em_epoux.id_personne = p_epoux.id_personne
            LEFT JOIN epoux_mariage em_epouse ON m.id_mariage = em_epouse.id_mariage AND em_epouse.type_role = 'épouse'
            LEFT JOIN personnes p_epouse ON em_epouse.id_personne = p_epouse.id_personne
            LEFT JOIN communes c ON m.id_commune_celebration = c.id_commune
            WHERE m.date_celebration >= CURDATE()
            ORDER BY m.date_celebration ASC
            LIMIT :limite OFFSET :decalage
        ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':decalage', $decalage, PDO::PARAM_INT);
        $stmt->execute();
        $mariages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Compter le total
        $stmt_comptage = $pdo->prepare("
            SELECT COUNT(*) as total
            FROM mariages m
            WHERE m.date_celebration >= CURDATE()
        ");
        $stmt_comptage->execute();
        $nombre_total = $stmt_comptage->fetch()['total'];

        return [
            'success' => true,
            'data' => $mariages,
            'total_count' => $nombre_total
        ];

    } catch (PDOException $e) {
        return [
            'success' => false,
            'error' => 'Erreur lors de la récupération des mariages: ' . $e->getMessage(),
            'data' => [],
            'total_count' => 0
        ];
    }
}

function rechercherPersonneDansMariages(PDO $pdo, string $recherche): array {
    try {
        $stmt = $pdo->prepare("
            SELECT DISTINCT
                m.id_mariage,
                m.numero_acte_mariage,
                m.date_celebration,
                m.heure_celebration,
                m.etat_acte,
                p_epoux.nom as nom_epoux,
                p_epoux.prenom as prenom_epoux,
                p_epoux.photo as photo_epoux,
                p_epouse.nom as nom_epouse,
                p_epouse.prenom as prenom_epouse,
                p_epouse.photo as photo_epouse,
                c.nom_commune
            FROM mariages m
            LEFT JOIN epoux_mariage em_epoux ON m.id_mariage = em_epoux.id_mariage AND em_epoux.type_role = 'époux'
            LEFT JOIN personnes p_epoux ON em_epoux.id_personne = p_epoux.id_personne
            LEFT JOIN epoux_mariage em_epouse ON m.id_mariage = em_epouse.id_mariage AND em_epouse.type_role = 'épouse'
            LEFT JOIN personnes p_epouse ON em_epouse.id_personne = p_epouse.id_personne
            LEFT JOIN communes c ON m.id_commune_celebration = c.id_commune
            WHERE p_epoux.nom LIKE :recherche 
               OR p_epoux.prenom LIKE :recherche
               OR p_epouse.nom LIKE :recherche
               OR p_epouse.prenom LIKE :recherche
               OR m.numero_acte_mariage LIKE :recherche
            ORDER BY m.date_celebration DESC
        ");
        $stmt->execute(['recherche' => '%' . $recherche . '%']);
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return ['success' => true, 'data' => $resultats];

    } catch (PDOException $e) {
        return [
            'success' => false,
            'error' => 'Erreur lors de la recherche: ' . $e->getMessage(),
            'data' => []
        ];
    }
}
