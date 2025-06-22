<?php
require_once __DIR__ . '/../header.php';

$errors = [];
$success = '';

if (isset($_SESSION['error'])) {
    if (is_array($_SESSION['error'])) {
        $errors = $_SESSION['error'];
    } else {
        $errors[] = $_SESSION['error'];
    }
    unset($_SESSION['error']); 
}

if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

$id_officier = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_officier <= 0) {
    header('Location: officiers.php');
    exit;
}

$officier_result = obtenirOfficier($pdo, $id_officier);

if (!$officier_result['success']) {
    $_SESSION['error'] = $officier_result['error']; 
    header('Location: officiers.php');
    exit;
}

$officier = $officier_result['data'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $confirmer_mot_de_passe = $_POST['confirmer_mot_de_passe'] ?? '';
    
    if (!empty($mot_de_passe) && $mot_de_passe !== $confirmer_mot_de_passe) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
        $errors[] = "Les mots de passe ne correspondent pas."; 
    } else {
        $post_data = $_POST;
        $post_data['id_commune'] = $_POST['commune']; 
        
        $result = modifierOfficier($pdo, $id_officier, $post_data);
        
        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
            header('Location: sofficiers.php');
            exit;
        } else {
            if (isset($result['errors'])) {
                foreach ($result['errors'] as $err) {
                    $errors[] = $err;
                }
            } else if (isset($result['error'])) { 
                $errors[] = $result['error'];
            }
            $_SESSION['error'] = implode(', ', $errors); }
    }
}

$communes = obtenirToutesCommunes($pdo);
?>
        <div class="page-content">
            <div class="page-header">
                <div class="page-title">
                    <div class="page-title-icon"><i class="fas fa-edit"></i></div>
                    <div>
                        <h1>Modifier un Officier</h1>
                        <div class="breadcrumb">
                            <a href="liste_officiers.php">Officiers</a>
                            <span>→</span>
                            <span>Modifier officier</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-container">
                <div class="form-header">
                    <h2>Informations de l'Officier</h2>
                    <p>Modifiez les informations de l'officier <?php echo htmlspecialchars($officier['nom'] . ' ' . $officier['prenom']); ?>.</p>
                </div>

        <?php if (!empty($errors)): // Now $errors will contain messages from the current request or previous redirects ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="success-message">
                <p><?php echo htmlspecialchars($success); ?></p>
            </div>
        <?php endif; ?>

                <div class="form-content">
                    <form id="officierForm" class="form-sections" method="POST">
                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-user"></i></span>
                                Informations Personnelles
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Nom <span class="required">*</span></label>
                                    <input type="text" class="form-input" name="nom" required placeholder="Nom de famille" value="<?php echo htmlspecialchars($officier['nom']); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Prénom <span class="required">*</span></label>
                                    <input type="text" class="form-input" name="prenom" required placeholder="Prénom(s)" value="<?php echo htmlspecialchars($officier['prenom']); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Matricule</label>
                                    <input type="text" class="form-input" name="matricule" placeholder="Numéro de matricule" value="<?php echo htmlspecialchars($officier['matricule'] ?? ''); ?>">
                                    <div class="form-help">Si applicable</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-envelope"></i></span>
                                Informations de Contact
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Email <span class="required">*</span></label>
                                    <input type="email" class="form-input" name="email" required placeholder="Adresse email" value="<?php echo htmlspecialchars($officier['email']); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-lock"></i></span>
                                Informations de Compte
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Nouveau Mot de Passe</label>
                                    <input type="password" class="form-input" name="mot_de_passe" placeholder="Laissez vide pour ne pas changer">
                                    <div class="form-help">Laissez vide pour conserver le mot de passe actuel</div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Confirmer le Mot de Passe</label>
                                    <input type="password" class="form-input" name="confirmer_mot_de_passe" placeholder="Confirmer le nouveau mot de passe">
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="section-title">
                                <span class="section-icon"><i class="fas fa-city"></i></span>
                                Affectation
                            </div>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Commune <span class="required">*</span></label>
                                    <select class="form-select" name="commune" required>
                                        <option value="">Sélectionner la commune</option>
                                        <?php foreach ($communes as $commune): ?>
                                            <option value="<?php echo $commune['id_commune']; ?>" <?php echo ($commune['id_commune'] == $officier['id_commune']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($commune['nom_commune']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Rôle <span class="required">*</span></label>
                                    <select class="form-select" name="role" required>
                                        <option value="">Sélectionner le rôle</option>
                                        <option value="officier_communal" <?php echo ($officier['role'] === 'officier_communal') ? 'selected' : ''; ?>>Officier Communal</option>
                                        <option value="admin" <?php echo ($officier['role'] === 'admin') ? 'selected' : ''; ?>>Administrateur</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <a href="officiers.php" class="btn btn-outline">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Modifier l'Officier
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