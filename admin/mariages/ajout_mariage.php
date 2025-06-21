<?php
require_once __DIR__ . '/../header.php';

// Récupérer les listes de personnes (hommes et femmes)
$hommes = getPersonsByType($pdo, 'homme');
$femmes = getPersonsByType($pdo, 'femme');

// Récupérer la commune de l'officier connecté
$commune_officier = '';
if (isset($_SESSION['id_commune'])) {
    $stmt = $pdo->prepare("SELECT nom_commune FROM communes WHERE id_commune = :id");
    $stmt->execute(['id' => $_SESSION['id_commune']]);
    $result = $stmt->fetch();
    if ($result) {
        $commune_officier = $result['nom_commune'];
    }
}

// Traitement du formulaire
$errors = [];
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = addMariage($pdo, $_POST, $_SESSION);

    if ($result['success']) {
        // Redirection pour éviter la resoumission du formulaire
        header('Location: mariages.php?success=add');
        exit;
    } else {
        $errors = $result['errors'];
    }
}
?>
        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <div class="page-title-icon"><i class="fas fa-plus"></i></div>
                    <div>
                        <h1>Ajouter un Nouveau Mariage</h1>
                        <div class="breadcrumb">
                            <a href="#">Mariages</a>
                            <span>→</span>
                            <span>Nouveau mariage</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-header">
                    <h2>Informations du Mariage</h2>
                    <p>Veuillez remplir tous les champs requis pour enregistrer un nouveau mariage dans le système.</p>
                </div>

                <div class="form-content">
                    <form id="mariageForm" class="form-sections">

                        <!-- Informations Générales -->
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-info-circle"></i></span>
                                Informations Générales
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Numéro d'acte <span class="required">*</span></label>
                                    <input type="text" class="form-input" name="numero_acte_mariage" required placeholder="Ex: ACT-2024-001">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Date de célébration <span class="required">*</span></label>
                                    <input type="date" class="form-input" name="date_celebration" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Heure de célébration <span class="required">*</span></label>
                                    <input type="time" class="form-input" name="heure_celebration" required>
                                </div>
                            </div>
                        </div>

                        <!-- Époux et Épouse -->
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-users"></i></span>
                                Époux et Épouse
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Époux <span class="required">*</span></label>
                                    <select class="form-select" name="id_epoux" required>
                                        <option value="">Sélectionner l'époux</option>
                                        <?php foreach ($hommes as $homme): ?>
                                            <option value="<?php echo htmlspecialchars($homme['id_personne']); ?>">
                                                <?php echo htmlspecialchars($homme['nom_complet']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Épouse <span class="required">*</span></label>
                                    <select class="form-select" name="id_epouse" required>
                                        <option value="">Sélectionner l'épouse</option>
                                        <?php foreach ($femmes as $femme): ?>
                                            <option value="<?php echo htmlspecialchars($femme['id_personne']); ?>">
                                                <?php echo htmlspecialchars($femme['nom_complet']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Informations Supplémentaires -->
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-file-alt"></i></span>
                                Informations Supplémentaires
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Officier de célébration</label>
                                    <input type="text" class="form-input" value="<?php echo htmlspecialchars($prenom . ' ' . $nom); ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Commune de célébration</label>
                                    <input type="text" class="form-input" value="<?php echo htmlspecialchars($commune_officier); ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Régime matrimonial</label>
                                    <select class="form-select" name="regime_matrimonial" required>
                                        <option value="">Sélectionner le régime matrimonial</option>
                                        <option value="communauté réduite aux acquêts">Communauté réduite aux acquêts</option>
                                        <option value="communauté de biens">Communauté de biens</option>
                                        <option value="séparation de biens">Séparation de biens</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-file-alt"></i></span>
                                Informations Sur les Témoins
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Nom Complet du Témoin 1  <span class="required">*</span></label>
                                    <input type="text" class="form-input" name="nom_complet_temoin_1" required placeholder="Ex: Nom et Prénom du Témoin 1">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nom Complet du Témoin 2  <span class="required">*</span></label>
                                    <input type="text" class="form-input" name="nom_complet_temoin_2" required placeholder="Ex: Nom et Prénom du Témoin 2">
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="mariages.php" class="btn btn-outline">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Créer le Mariage
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>