<?php
require_once __DIR__ . '/../header.php';

// Vérifier si l'utilisateur est connecté
if (!estConnecte()) {
    header('Location: /../login.php');
    exit;
}

// Récupérer l'ID du mariage depuis l'URL
$id_mariage = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_mariage <= 0) {
    header('Location: /admin/mariages/mariages.php');
    exit;
}

// Appel à obtenirDetailsMariage
$mariage_result = obtenirDetailsMariage($pdo, $id_mariage);

if (!$mariage_result['success']) {
    $error_message = $mariage_result['error'] ?? 'Erreur inconnue';
    $mariage = null;
    $epoux = null;
    $epouse = null;
} else {
    $data = $mariage_result['data'];
    $mariage = $data['mariage'];
    $epoux = null;
    $epouse = null;
    foreach ($data['epoux'] as $personne) {
        if ($personne['type_role'] === 'époux') {
            $epoux = $personne;
        } elseif ($personne['type_role'] === 'épouse') {
            $epouse = $personne;
        }
    }
}

// Calcul de l'âge des époux
$age_epoux = null;
$age_epouse = null;

if ($epoux && !empty($epoux['date_naissance'])) {
    try {
        $date_naissance = new DateTime($epoux['date_naissance']);
        $aujourd_hui = new DateTime();
        $age_epoux = $aujourd_hui->diff($date_naissance)->y;
    } catch (Exception $e) {
        $age_epoux = null;
    }
}

if ($epouse && !empty($epouse['date_naissance'])) {
    try {
        $date_naissance = new DateTime($epouse['date_naissance']);
        $aujourd_hui = new DateTime();
        $age_epouse = $aujourd_hui->diff($date_naissance)->y;
    } catch (Exception $e) {
        $age_epouse = null;
    }
}
?>

<!-- Page Content -->
<div class="page-content">
    <?php if (isset($error_message)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <div class="page-title-icon"><i class="fas fa-heart"></i></div>
            <div>
                <h1>Acte de Mariage N° <?php echo htmlspecialchars($mariage['numero_acte_mariage']); ?></h1>
                <div class="breadcrumb">
                    <a href="/admin/mariages/mariages.php">Mariages</a>
                    <span>→</span>
                    <span>Acte N° <?php echo htmlspecialchars($mariage['numero_acte_mariage']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Container -->
    <div class="details-container">
        <!-- Acte Card -->
        <div class="photo-card">
            <div class="photo-placeholder">
                <div class="initials-circle">
                    <i class="fas fa-heart"></i>
                </div>
            </div>

            <h2 class="person-name">Acte de Mariage</h2>
            <div class="person-id">N° <?php echo htmlspecialchars($mariage['numero_acte_mariage']); ?></div>
            <div class="person-type">
                <span><i class="fas fa-calendar-alt"></i></span>
                <?php echo formaterDate($mariage['date_celebration']); ?>
            </div>

            <div style="margin-top: 20px;">
                <div class="status-badge active">
                    <i class="fas fa-check-circle"></i> Actif
                </div>
            </div>
        </div>

        <!-- Info Container -->
        <div class="info-container">
            <div class="info-header">
                <h2>Détails du Mariage</h2>
                <div class="status-badge active">
                    Dernière mise à jour: <?php echo formaterDate($mariage['date_mise_a_jour'] ?? $mariage['date_creation']); ?>
                </div>
            </div>

            <div class="info-content">
                <div class="info-sections">
                    <!-- Informations de l'Acte -->
                    <div class="info-section">
                        <div class="section-title">
                            <span class="section-icon"><i class="fas fa-file-alt"></i></span>
                            Informations de l'Acte
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Numéro d'acte</div>
                                <div class="info-value"><?php echo htmlspecialchars($mariage['numero_acte_mariage']); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Date de célébration</div>
                                <div class="info-value"><?php echo formaterDate($mariage['date_celebration']); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Heure de célébration</div>
                                <div class="info-value"><?php echo htmlspecialchars($mariage['heure_celebration']); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Régime matrimonial</div>
                                <div class="info-value"><?php echo htmlspecialchars($mariage['regime_matrimonial']); ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations de l'Époux -->
                    <div class="info-section">
                        <div class="section-title">
                            <span class="section-icon"><i class="fas fa-male"></i></span>
                            Informations de l'Époux
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Nom complet</div>
                                <div class="info-value"><?php echo htmlspecialchars($epoux ? ($epoux['nom'] . ' ' . $epoux['prenom']) : 'Non renseigné'); ?></div>
                            </div>
                            <?php if ($age_epoux !== null): ?>
                            <div class="info-item">
                                <div class="info-label">Âge</div>
                                <div class="info-value"><?php echo $age_epoux; ?> ans</div>
                            </div>
                            <?php endif; ?>
                            <div class="info-item">
                                <div class="info-label">Date de naissance</div>
                                <div class="info-value <?php echo ($epoux && empty($epoux['date_naissance'])) ? 'empty' : ''; ?>">
                                    <?php echo ($epoux && !empty($epoux['date_naissance'])) ? formaterDate($epoux['date_naissance']) : 'Non renseigné'; ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Lieu de naissance</div>
                                <div class="info-value <?php echo ($epoux && empty($epoux['lieu_naissance'])) ? 'empty' : ''; ?>">
                                    <?php echo ($epoux && !empty($epoux['lieu_naissance'])) ? htmlspecialchars($epoux['lieu_naissance']) : 'Non renseigné'; ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Nationalité</div>
                                <div class="info-value"><?php echo ($epoux && !empty($epoux['nationalite'])) ? htmlspecialchars($epoux['nationalite']) : 'Non renseigné'; ?></div>
                            </div>
                            <?php if ($epoux && !empty($epoux['profession'])): ?>
                            <div class="info-item">
                                <div class="info-label">Profession</div>
                                <div class="info-value"><?php echo htmlspecialchars($epoux['profession']); ?></div>
                            </div>
                            <?php endif; ?>
                            <?php if ($epoux && !empty($epoux['adresse_actuelle'])): ?>
                            <div class="info-item">
                                <div class="info-label">Adresse</div>
                                <div class="info-value"><?php echo htmlspecialchars($epoux['adresse_actuelle']); ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Informations de l'Épouse -->
                    <div class="info-section">
                        <div class="section-title">
                            <span class="section-icon"><i class="fas fa-female"></i></span>
                            Informations de l'Épouse
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Nom complet</div>
                                <div class="info-value"><?php echo htmlspecialchars($epouse ? ($epouse['nom'] . ' ' . $epouse['prenom']) : 'Non renseigné'); ?></div>
                            </div>
                            <?php if ($age_epouse !== null): ?>
                            <div class="info-item">
                                <div class="info-label">Âge</div>
                                <div class="info-value"><?php echo $age_epouse; ?> ans</div>
                            </div>
                            <?php endif; ?>
                            <div class="info-item">
                                <div class="info-label">Date de naissance</div>
                                <div class="info-value <?php echo ($epouse && empty($epouse['date_naissance'])) ? 'empty' : ''; ?>">
                                    <?php echo ($epouse && !empty($epouse['date_naissance'])) ? formaterDate($epouse['date_naissance']) : 'Non renseigné'; ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Lieu de naissance</div>
                                <div class="info-value <?php echo ($epouse && empty($epouse['lieu_naissance'])) ? 'empty' : ''; ?>">
                                    <?php echo ($epouse && !empty($epouse['lieu_naissance'])) ? htmlspecialchars($epouse['lieu_naissance']) : 'Non renseigné'; ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Nationalité</div>
                                <div class="info-value"><?php echo ($epouse && !empty($epouse['nationalite'])) ? htmlspecialchars($epouse['nationalite']) : 'Non renseigné'; ?></div>
                            </div>
                            <?php if ($epouse && !empty($epouse['profession'])): ?>
                            <div class="info-item">
                                <div class="info-label">Profession</div>
                                <div class="info-value"><?php echo htmlspecialchars($epouse['profession']); ?></div>
                            </div>
                            <?php endif; ?>
                            <?php if ($epouse && !empty($epouse['adresse_actuelle'])): ?>
                            <div class="info-item">
                                <div class="info-label">Adresse</div>
                                <div class="info-value"><?php echo htmlspecialchars($epouse['adresse_actuelle']); ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Informations de Célébration -->
                    <div class="info-section">
                        <div class="section-title">
                            <span class="section-icon"><i class="fas fa-church"></i></span>
                            Informations de Célébration
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Officier de célébration</div>
                                <div class="info-value"><?php echo htmlspecialchars($mariage['nom_officier'] . ' ' . $mariage['prenom_officier']); ?></div>
                            </div>
                            <?php if (!empty($mariage['matricule_officier'])): ?>
                            <div class="info-item">
                                <div class="info-label">Matricule officier</div>
                                <div class="info-value"><?php echo htmlspecialchars($mariage['matricule_officier']); ?></div>
                            </div>
                            <?php endif; ?>
                            <div class="info-item">
                                <div class="info-label">Commune</div>
                                <div class="info-value"><?php echo htmlspecialchars($mariage['nom_commune']); ?></div>
                            </div>
                            <?php if (!empty($mariage['district'])): ?>
                            <div class="info-item">
                                <div class="info-label">District</div>
                                <div class="info-value"><?php echo htmlspecialchars($mariage['district']); ?></div>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($mariage['province'])): ?>
                            <div class="info-item">
                                <div class="info-label">Province</div>
                                <div class="info-value"><?php echo htmlspecialchars($mariage['province']); ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Informations des Témoins -->
                    <div class="info-section">
                        <div class="section-title">
                            <span class="section-icon"><i class="fas fa-users"></i></span>
                            Informations des Témoins
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Témoin 1</div>
                                <div class="info-value"><?php echo htmlspecialchars($mariage['nom_complet_temoin_1']); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Témoin 2</div>
                                <div class="info-value"><?php echo htmlspecialchars($mariage['nom_complet_temoin_2']); ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations système -->
                    <div class="info-section">
                        <div class="section-title">
                            <span class="section-icon"><i class="fas fa-info-circle"></i></span>
                            Informations Système
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Date de création</div>
                                <div class="info-value"><?php echo formaterDate($mariage['date_creation']); ?></div>
                            </div>
                            <?php if (!empty($mariage['date_mise_a_jour'])): ?>
                            <div class="info-item">
                                <div class="info-label">Dernière modification</div>
                                <div class="info-value"><?php echo formaterDate($mariage['date_mise_a_jour']); ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>