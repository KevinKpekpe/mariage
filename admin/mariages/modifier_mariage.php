<?php
require_once __DIR__ . '/../header.php';

// Vérifier si l'ID est présent
$id_mariage = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id_mariage) {
    header('Location: mariages.php');
    exit;
}

// Récupérer les données du mariage
$result_mariage = obtenirMariage($pdo, $id_mariage);
if (!$result_mariage['success']) {
    header('Location: mariages.php?error=notfound');
    exit;
}
$mariage = $result_mariage['data'];

// Récupérer les listes de personnes
$hommes = obtenirPersonnesParType($pdo, 'homme');
$femmes = obtenirPersonnesParType($pdo, 'femme');

// Récupérer la commune de l'officier
$commune_officier = '';
$stmt = $pdo->prepare("SELECT nom_commune FROM communes WHERE id_commune = :id");
$stmt->execute(['id' => $mariage['id_commune_celebration']]);
$result_commune = $stmt->fetch();
if ($result_commune) {
    $commune_officier = $result_commune['nom_commune'];
}

// Traitement du formulaire de modification
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = modifierMariage($pdo, $id_mariage, $_POST, $_SESSION);

    if ($result['success']) {
        header('Location: mariages.php?success=edit');
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
                    <div class="page-title-icon"><i class="fas fa-edit"></i></div>
                    <div>
                        <h1>Modifier un Mariage</h1>
                        <div class="breadcrumb">
                            <a href="/admin/mariages/mariages.php">Mariages</a>
                            <span>→</span>
                            <span>Modification</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-header">
                    <h2>Informations du Mariage</h2>
                    <p>Veuillez modifier les champs requis pour mettre à jour le mariage.</p>
                </div>

                <div class="form-content">
                    <form id="mariageForm" class="form-sections" method="POST">

                        <!-- Informations Générales -->
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-info-circle"></i></span>
                                Informations Générales
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Numéro d'acte <span class="required">*</span></label>
                                    <input type="text" class="form-input" name="numero_acte_mariage" required value="<?php echo htmlspecialchars($mariage['numero_acte_mariage']); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Date de célébration <span class="required">*</span></label>
                                    <input type="date" class="form-input" name="date_celebration" required value="<?php echo htmlspecialchars($mariage['date_celebration']); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Heure de célébration <span class="required">*</span></label>
                                    <input type="time" class="form-input" name="heure_celebration" required value="<?php echo htmlspecialchars($mariage['heure_celebration']); ?>">
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
                                        <?php foreach ($hommes as $homme): ?>
                                            <option value="<?php echo htmlspecialchars($homme['id_personne']); ?>" <?php echo ($homme['id_personne'] == $mariage['id_epoux']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($homme['nom_complet']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Épouse <span class="required">*</span></label>
                                    <select class="form-select" name="id_epouse" required>
                                        <?php foreach ($femmes as $femme): ?>
                                            <option value="<?php echo htmlspecialchars($femme['id_personne']); ?>" <?php echo ($femme['id_personne'] == $mariage['id_epouse']) ? 'selected' : ''; ?>>
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
                                        <option value="communauté réduite aux acquêts" <?php echo ($mariage['regime_matrimonial'] == 'communauté réduite aux acquêts') ? 'selected' : ''; ?>>Communauté réduite aux acquêts</option>
                                        <option value="communauté de biens" <?php echo ($mariage['regime_matrimonial'] == 'communauté de biens') ? 'selected' : ''; ?>>Communauté de biens</option>
                                        <option value="séparation de biens" <?php echo ($mariage['regime_matrimonial'] == 'séparation de biens') ? 'selected' : ''; ?>>Séparation de biens</option>
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
                                    <input type="text" class="form-input" name="nom_complet_temoin_1" required value="<?php echo htmlspecialchars($mariage['nom_complet_temoin_1']); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nom Complet du Témoin 2  <span class="required">*</span></label>
                                    <input type="text" class="form-input" name="nom_complet_temoin_2" required value="<?php echo htmlspecialchars($mariage['nom_complet_temoin_2']); ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <a href="mariages.php" class="btn btn-outline">Annuler</a>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>