<?php
require_once __DIR__ . '/../header.php';

// Récupérer l'ID de la personne à modifier
$id_personne = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id_personne) {
    header('Location: personnes.php');
    exit;
}

// Récupérer les données de la personne
try {
    $stmt = $pdo->prepare("SELECT * FROM personnes WHERE id_personne = :id");
    $stmt->execute(['id' => $id_personne]);
    $personne = $stmt->fetch();
    
    if (!$personne) {
        header('Location: personnes.php');
        exit;
    }
} catch (PDOException $e) {
    $errors[] = "Erreur lors de la récupération des données: " . $e->getMessage();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = editPerson($pdo, $id_personne, $_POST, $_FILES);
    if ($result['success']) {
        $success = $result['message'];
        // Recharger les données de la personne après modification
        $stmt = $pdo->prepare("SELECT * FROM personnes WHERE id_personne = :id");
        $stmt->execute(['id' => $id_personne]);
        $personne = $stmt->fetch();
    } else {
        $errors = $result['errors'];
    }
}

// Utiliser les données POST si disponibles, sinon les données de la base
$form_data = [
    'nom' => $_POST['nom'] ?? $personne['nom'],
    'prenom' => $_POST['prenom'] ?? $personne['prenom'],
    'type_personne' => $_POST['type_personne'] ?? $personne['type_personne'],
    'date_naissance' => $_POST['date_naissance'] ?? $personne['date_naissance'],
    'lieu_naissance' => $_POST['lieu_naissance'] ?? $personne['lieu_naissance'],
    'nationalite' => $_POST['nationalite'] ?? $personne['nationalite'],
    'profession' => $_POST['profession'] ?? $personne['profession'],
    'adresse_actuelle' => $_POST['adresse_actuelle'] ?? $personne['adresse_actuelle']
];
?>
<!-- Page Content -->
<div class="page-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <div class="page-title-icon"><i class="fas fa-edit"></i></div>
            <div>
                <h1>Modifier une Personne</h1>
                <div class="breadcrumb">
                    <a href="personnes.php">Personnes</a>
                    <span>→</span>
                    <span>Modifier <?php echo htmlspecialchars($personne['prenom'] . ' ' . $personne['nom']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-header">
            <h2>Modifier les Informations de la Personne</h2>
            <p>Modifiez les champs que vous souhaitez mettre à jour.</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="success-message">
                <p><?php echo htmlspecialchars($success); ?></p>
            </div>
        <?php endif; ?>

        <div class="form-content">
            <form id="personForm" class="form-sections" method="POST" enctype="multipart/form-data">
                <!-- Photo Section -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon"><i class="fas fa-camera"></i></span>
                        Photo d'Identité
                    </div>
                    <div class="photo-upload-section">
                        <div class="photo-preview">
                            <div class="photo-placeholder" id="photoPlaceholder" onclick="document.getElementById('photoInput').click()">
                                <img src="../../<?php echo htmlspecialchars($personne['photo']); ?>" alt="Photo actuelle" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <input type="file" id="photoInput" name="photoInput" class="photo-upload-input" accept="image/*">
                            <input type="hidden" id="removePhoto" name="remove_photo" value="0">
                            <div class="photo-actions" id="photoActions" style="display: <?php echo !empty($personne['photo']) ? 'flex' : 'none'; ?>;">
                                <button type="button" class="photo-upload-btn" onclick="document.getElementById('photoInput').click()">
                                    Changer
                                </button>
                                <button type="button" class="photo-upload-btn remove" onclick="removePhoto()">
                                    Supprimer
                                </button>
                            </div>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <p class="form-help">
                                • Format accepté : JPG, PNG (max 2MB)<br>
                                • Dimensions recommandées : 300x300px<br>
                                • Photo récente en couleur sur fond clair<br>
                                • Laissez vide pour conserver la photo actuelle
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Informations Personnelles -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon"><i class="fas fa-user"></i></span>
                        Informations Personnelles
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nom <span class="required">*</span></label>
                            <input type="text" class="form-input" name="nom" required placeholder="Nom de famille" value="<?php echo htmlspecialchars($form_data['nom']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Prénom <span class="required">*</span></label>
                            <input type="text" class="form-input" name="prenom" required placeholder="Prénom(s)" value="<?php echo htmlspecialchars($form_data['prenom']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Type de Personne <span class="required">*</span></label>
                            <div class="type-selection">
                                <div class="type-option">
                                    <input type="radio" id="homme" name="type_personne" value="homme" class="type-radio" required <?php echo $form_data['type_personne'] === 'homme' ? 'checked' : ''; ?>>
                                    <label for="homme" class="type-label">
                                        <span class="type-icon"><i class="fas fa-male"></i></span>
                                        Homme
                                    </label>
                                </div>
                                <div class="type-option">
                                    <input type="radio" id="femme" name="type_personne" value="femme" class="type-radio" required <?php echo $form_data['type_personne'] === 'femme' ? 'checked' : ''; ?>>
                                    <label for="femme" class="type-label">
                                        <span class="type-icon"><i class="fas fa-female"></i></span>
                                        Femme
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Naissance et Origine -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon"><i class="fas fa-birthday-cake"></i></span>
                        Naissance et Origine
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Date de Naissance</label>
                            <input type="date" class="form-input" name="date_naissance" value="<?php echo htmlspecialchars($form_data['date_naissance']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Lieu de Naissance</label>
                            <input type="text" class="form-input" name="lieu_naissance" placeholder="Ville, Province/État, Pays" value="<?php echo htmlspecialchars($form_data['lieu_naissance']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nationalité <span class="required">*</span></label>
                            <select class="form-select" name="nationalite" required>
                                <option value="">Sélectionner la nationalité</option>
                                <option value="Congolaise" <?php echo $form_data['nationalite'] === 'Congolaise' ? 'selected' : ''; ?>>Congolaise</option>
                                <!-- Add more nationalities as needed -->
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Informations Professionnelles -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon"><i class="fas fa-briefcase"></i></span>
                        Informations Professionnelles
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Profession</label>
                            <input type="text" class="form-input" name="profession" placeholder="Ex: Enseignant, Médecin, Ingénieur..." value="<?php echo htmlspecialchars($form_data['profession']); ?>">
                            <div class="form-help">Profession actuelle ou principale activité</div>
                        </div>
                    </div>
                </div>

                <!-- Adresse -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon"><i class="fas fa-map-marker-alt"></i></span>
                        Adresse Actuelle
                    </div>
                    <div class="form-grid full-width">
                        <div class="form-group">
                            <label class="form-label">Adresse Complète</label>
                            <textarea class="form-textarea" name="adresse_actuelle" placeholder="Numéro, rue, quartier, commune, ville..."><?php echo htmlspecialchars($form_data['adresse_actuelle']); ?></textarea>
                            <div class="form-help">Adresse de résidence actuelle complète</div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="personnes.php" class="btn btn-outline">
                        Retour à la liste
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Modifier la Personne
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Photo upload preview
    const photoInput = document.getElementById('photoInput');
    const photoPlaceholder = document.getElementById('photoPlaceholder');
    const photoActions = document.getElementById('photoActions');
    const removePhotoInput = document.getElementById('removePhoto');

    photoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPlaceholder.innerHTML = `<img src="${e.target.result}" alt="Photo preview" style="width: 100%; height: 100%; object-fit: cover;">`;
                photoActions.style.display = 'flex';
                removePhotoInput.value = '0'; // Reset remove flag
            };
            reader.readAsDataURL(file);
        }
    });

    function removePhoto() {
        photoInput.value = '';
        photoPlaceholder.innerHTML = `
            <div>
                <i class="fas fa-camera"></i><br>
                Cliquez pour ajouter<br>
                une photo
            </div>
        `;
        photoActions.style.display = 'none';
        removePhotoInput.value = '1'; // Set remove flag
    }
</script>
</body>
</html>