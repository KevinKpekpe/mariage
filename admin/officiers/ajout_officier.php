<?php
require_once __DIR__ . '/../header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = addOfficier($pdo, $_POST);
    if ($result['success']) {
        $success = $result['message'];
    } else {
        $errors = $result['errors'];
    }
}
$communes = getAllCommunes($pdo);
?>
<!-- Page Content -->
<div class="page-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <div class="page-title-icon"><i class="fas fa-plus"></i></div>
            <div>
                <h1>Ajouter un Nouvel Officier</h1>
                <div class="breadcrumb">
                    <a href="#">Officiers</a>
                    <span>→</span>
                    <span>Nouvel officier</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-header">
            <h2>Informations de l'Officier</h2>
            <p>Veuillez remplir tous les champs requis pour enregistrer un nouvel officier dans le système.</p>
        </div>
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message">
                <p><?php echo htmlspecialchars($success); ?></p>
            </div>
        <?php endif; ?>
        <div class="form-content">
            <form id="officierForm" method="post" class="form-sections">
                <!-- Informations Personnelles -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon"><i class="fas fa-user"></i></span>
                        Informations Personnelles
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nom <span class="required">*</span></label>
                            <input type="text" class="form-input" name="nom" required placeholder="Nom de famille">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Prénom <span class="required">*</span></label>
                            <input type="text" class="form-input" name="prenom" required placeholder="Prénom(s)">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Matricule</label>
                            <input type="text" class="form-input" name="matricule" placeholder="Numéro de matricule">
                            <div class="form-help">Si applicable</div>
                        </div>
                    </div>
                </div>

                <!-- Informations de Contact -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon"><i class="fas fa-envelope"></i></span>
                        Informations de Contact
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" class="form-input" name="email" required placeholder="Adresse email">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" class="form-input" name="telephone" placeholder="Numéro de téléphone">
                        </div>
                    </div>
                </div>

                <!-- Informations de Compte -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon"><i class="fas fa-lock"></i></span>
                        Informations de Compte
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Mot de Passe <span class="required">*</span></label>
                            <input type="password" class="form-input" name="mot_de_passe" required placeholder="Mot de passe">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirmer le Mot de Passe <span class="required">*</span></label>
                            <input type="password" class="form-input" name="confirmer_mot_de_passe" required placeholder="Confirmer le mot de passe">
                        </div>
                    </div>
                </div>

                <!-- Affectation -->
                <div class="form-section">
                    <div class="section-title">
                        <span class="section-icon"><i class="fas fa-city"></i></span>
                        Affectation
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Commune <span class="required">*</span></label>
                            <select class="filter-select" name="id_commune" id="communeFilter">
                                <option value="">Toutes</option>
                                <?php

                                $communes = getAllCommunes($pdo);
                                foreach ($communes as $commune) {
                                    $selected = (isset($_GET['commune_id']) && (int)$_GET['commune_id'] === (int)$commune['id_commune']) ? 'selected' : '';
                                    echo "<option value=\"{$commune['id_commune']}\" {$selected}>" . htmlspecialchars($commune['nom_commune']) . "</option>";
                                }

                                ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Rôle <span class="required">*</span></label>
                            <select class="form-select" name="role" required>
                                <option value="">Sélectionner le rôle</option>
                                <option value="officier_communal">Officier Communal</option>
                                <option value="admin">Administrateur</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="#" class="btn btn-outline">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Créer l'Officier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script src="main.js"></script>
</body>

</html>