<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit;
}

// Inclure la configuration et les fonctions
require_once '../config.php';

// Récupérer les informations de l'utilisateur
$userId = $_SESSION['user_id'];
$userRole = $_SESSION['role'];

// Traitement du formulaire d'ajout de mariage
$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_marriage'])) {
    // Récupérer les données du formulaire
    $person1Id = $_POST['person1_id'] ?? '';
    $person2Id = $_POST['person2_id'] ?? '';
    $marriageDate = $_POST['marriage_date'] ?? '';
    $marriageTime = $_POST['marriage_time'] ?? '';
    $communeId = $_POST['commune_id'] ?? '';
    
    // Validation basique
    if (empty($person1Id) || empty($person2Id) || empty($marriageDate) || empty($marriageTime) || empty($communeId)) {
        $error = "Tous les champs sont obligatoires.";
    } else if ($person1Id == $person2Id) {
        $error = "Les deux personnes ne peuvent pas être identiques.";
    } else {
        $conn = connectDB();
        
        // Vérifier si l'une des personnes est déjà mariée
        $sql = "SELECT COUNT(*) as count FROM marriages 
                WHERE ((person1_id = ? OR person2_id = ?) OR (person1_id = ? OR person2_id = ?)) 
                AND status = 'completed'";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $person1Id, $person1Id, $person2Id, $person2Id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row['count'] > 0) {
            $error = "L'une des personnes sélectionnées est déjà mariée.";
        } else {
            // Insérer le nouveau mariage
            $sql = "INSERT INTO marriages (person1_id, person2_id, marriage_date, marriage_time, commune_id, officer_id, status) 
                    VALUES (?, ?, ?, ?, ?, ?, 'announced')";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iissii", $person1Id, $person2Id, $marriageDate, $marriageTime, $communeId, $userId);
            
            if ($stmt->execute()) {
                // Enregistrer l'activité
                $marriageId = $conn->insert_id;
                $details = "Annonce d'un nouveau mariage ID: $marriageId";
                $ipAddress = $_SERVER['REMOTE_ADDR'];
                
                $logSql = "INSERT INTO activity_logs (user_id, action, details, ip_address) VALUES (?, 'Nouvelle annonce', ?, ?)";
                $logStmt = $conn->prepare($logSql);
                $logStmt->bind_param("iss", $userId, $details, $ipAddress);
                $logStmt->execute();
                $logStmt->close();
                
                $success = true;
            } else {
                $error = "Une erreur est survenue lors de l'enregistrement du mariage: " . $conn->error;
            }
        }
        
        $stmt->close();
        $conn->close();
    }
}

// Récupérer la liste des communes
function getCommunes() {
    $conn = connectDB();
    $sql = "SELECT id, name, province FROM communes ORDER BY province, name";
    $result = $conn->query($sql);
    
    $communes = [];
    while ($row = $result->fetch_assoc()) {
        $communes[] = $row;
    }
    
    $conn->close();
    return $communes;
}

// Chercher des personnes dans la base de données
function findPersons($searchTerm) {
    $conn = connectDB();
    
    $searchTerm = "%$searchTerm%";
    
    $sql = "SELECT id, first_name, last_name, gender, birth_date, id_number 
            FROM persons 
            WHERE (first_name LIKE ? OR last_name LIKE ? OR id_number LIKE ?)
            LIMIT 10";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $persons = [];
    while ($row = $result->fetch_assoc()) {
        $persons[] = $row;
    }
    
    $stmt->close();
    $conn->close();
    
    return $persons;
}

$communes = getCommunes();

// Si une recherche est effectuée via AJAX
if (isset($_GET['ajax_search']) && isset($_GET['term'])) {
    $searchTerm = $_GET['term'];
    $persons = findPersons($searchTerm);
    
    header('Content-Type: application/json');
    echo json_encode($persons);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Ajouter un Mariage</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-container {
            padding: 40px 0;
        }
        
        .admin-sidebar {
            width: 250px;
            background-color: var(--dark-color);
            color: white;
            padding: 20px;
            border-radius: 10px;
            position: fixed;
            height: calc(100vh - 100px);
            overflow-y: auto;
        }
        
        .admin-sidebar h3 {
            color: var(--accent-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .admin-sidebar ul {
            list-style: none;
        }
        
        .admin-sidebar ul li {
            margin-bottom: 10px;
        }
        
        .admin-sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 8px 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .admin-sidebar ul li a:hover, .admin-sidebar ul li a.active {
            background-color: var(--primary-color);
        }
        
        .admin-content {
            margin-left: 270px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .admin-content h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .admin-form {
            max-width: 800px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .person-search-container {
            position: relative;
        }
        
        .search-results {
            position: absolute;
            width: 100%;
            background-color: white;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
            z-index: 100;
            max-height: 300px;
            overflow-y: auto;
            display: none;
        }
        
        .person-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }
        
        .person-item:hover {
            background-color: #f5f5f5;
        }
        
        .person-selected {
            background-color: #f5f5f5;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
            display: none;
        }
        
        .person-selected h4 {
            margin: 0 0 5px 0;
            color: var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #152b66;
        }
        
        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .error-message {
            background-color: var(--secondary-color);
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .add-person-link {
            display: block;
            margin-top: 10px;
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .add-person-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="/api/placeholder/60/60" alt="Logo Registre des Mariages">
                <h1>Administration - Registre des Mariages Civils</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="../index.php">Site public</a></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <section class="admin-container">
        <div class="container">
            <div class="admin-sidebar">
                <h3>Menu d'administration</h3>
                <ul>
                    <li><a href="dashboard.php">Tableau de bord</a></li>
                    <li><a href="marriages.php">Gestion des mariages</a></li>
                    <li><a href="add_marriage.php" class="active">Ajouter un mariage</a></li>
                    <li><a href="persons.php">Personnes enregistrées</a></li>
                    <li><a href="add_person.php">Ajouter une personne</a></li>
                    <li><a href="objections.php">Objections (<?php echo getObjectionsCount(); ?>)</a></li>
                    <?php if ($userRole === 'admin'): ?>
                    <li><a href="users.php">Utilisateurs</a></li>
                    <li><a href="communes.php">Communes</a></li>
                    <li><a href="settings.php">Paramètres</a></li>
                    <li><a href="logs.php">Journaux d'activité</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <div class="admin-content">
                <h2>Ajouter une Annonce de Mariage</h2>
                
                <?php if ($success): ?>
                <div class="success-message">
                    <p>L'annonce de mariage a été enregistrée avec succès!</p>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($error)): ?>
                <div class="error-message">
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
                <?php endif; ?>
                
                <form class="admin-form" method="POST" action="">
                    <div class="form-group">
                        <label for="person1_search">Rechercher la première personne:</label>
                        <div class="person-search-container">
                            <input type="text" id="person1_search" placeholder="Nom, prénom ou numéro d'identité...">
                            <div id="person1_results" class="search-results"></div>
                        </div>
                        <div id="person1_selected" class="person-selected">
                            <h4 id="person1_name"></h4>
                            <p id="person1_details"></p>
                            <input type="hidden" id="person1_id" name="person1_id">
                        </div>
                        <a href="add_person.php?return=add_marriage" class="add-person-link">+ Ajouter une nouvelle personne</a>
                    </div>
                    
                    <div class="form-group">
                        <label for="person2_search">Rechercher la deuxième personne:</label>
                        <div class="person-search-container">
                            <input type="text" id="person2_search" placeholder="Nom, prénom ou numéro d'identité...">
                            <div id="person2_results" class="search-results"></div>
                        </div>
                        <div id="person2_selected" class="person-selected">
                            <h4 id="person2_name"></h4>
                            <p id="person2_details"></p>
                            <input type="hidden" id="person2_id" name="person2_id">
                        </div>
                        <a href="add_person.php?return=add_marriage" class="add-person-link">+ Ajouter une nouvelle personne</a>
                    </div>
                    
                    <div class="form-group">
                        <label for="marriage_date">Date du mariage:</label>
                        <input type="date" id="marriage_date" name="marriage_date" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="marriage_time">Heure du mariage:</label>
                        <input type="time" id="marriage_time" name="marriage_time" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="commune_id">Commune:</label>
                        <select id="commune_id" name="commune_id" required>
                            <option value="">Sélectionner une commune</option>
                            <?php foreach ($communes as $commune): ?>
                            <option value="<?php echo $commune['id']; ?>">
                                <?php echo htmlspecialchars($commune['name'] . ' (' . $commune['province'] . ')'); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button type="submit" name="submit_marriage" class="btn-primary">Enregistrer l'annonce de mariage</button>
                </form>
            </div>
        </div>
    </section>
    
    <script>
        // Fonction pour rechercher des personnes
        function searchPersons(inputId, resultsId, selectedId, nameId, detailsId, hiddenId) {
            const input = document.getElementById(inputId);
            const results = document.getElementById(resultsId);
            
            input.addEventListener('input', function() {
                const searchTerm = input.value.trim();
                
                if (searchTerm.length < 2) {
                    results.style.display = 'none';
                    return;
                }
                
                // Effectuer la recherche via AJAX
                fetch(`add_marriage.php?ajax_search=1&term=${encodeURIComponent(searchTerm)}`)
                    .then(response => response.json())
                    .then(data => {
                        results.innerHTML = '';
                        
                        if (data.length === 0) {
                            results.innerHTML = '<div class="person-item">Aucun résultat trouvé</div>';
                        } else {
                            data.forEach(person => {
                                const div = document.createElement('div');
                                div.className = 'person-item';
                                div.innerHTML = `<strong>${person.first_name} ${person.last_name}</strong> (${person.gender === 'M' ? 'H' : 'F'}) - ${person.id_number}`;
                                
                                div.addEventListener('click', function() {
                                    document.getElementById(nameId).textContent = `${person.first_name} ${person.last_name}`;
                                    document.getElementById(detailsId).textContent = `Genre: ${person.gender === 'M' ? 'Homme' : 'Femme'} | Né(e) le: ${new Date(person.birth_date).toLocaleDateString()} | N° ID: ${person.id_number}`;
                                    document.getElementById(hiddenId).value = person.id;
                                    document.getElementById(selectedId).style.display = 'block';
                                    results.style.display = 'none';
                                    input.value = '';
                                });
                                
                                results.appendChild(div);
                            });
                        }
                        
                        results.style.display = 'block';
                    })
                    .catch(error => console.error('Erreur:', error));
            });
            
            // Cacher les résultats quand on clique ailleurs
            document.addEventListener('click', function(e) {
                if (e.target !== input && e.target !== results) {
                    results.style.display = 'none';
                }
            });
        }
        
        // Initialiser les recherches
        document.addEventListener('DOMContentLoaded', function() {
            searchPersons('person1_search', 'person1_results', 'person1_selected', 'person1_name', 'person1_details', 'person1_id');
            searchPersons('person2_search', 'person2_results', 'person2_selected', 'person2_name', 'person2_details', 'person2_id');
        });
    </script>
    
    <footer>
        <div class="container">
            <p>© 2025 Registre des Mariages Civils - République Démocratique du Congo</p>
            <p>Système d'administration</p>
        </div>
    </footer>
</body>
</html>