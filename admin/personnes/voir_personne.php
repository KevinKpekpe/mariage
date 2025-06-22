<?php

require_once __DIR__ . '/../header.php';

// Vérifier si l'utilisateur est connecté
if (!estConnecte()) {
    header('Location: /../login.php');
    exit;
}

// Récupérer l'ID de la personne depuis l'URL
$id_personne = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_personne <= 0) {
    header('Location: /admin/personnes/personnes.php');
    exit;
}

// Appel à obtenirPersonne
$person_result = obtenirPersonne($pdo, $id_personne);

if (!$person_result['success']) {
    $error_message = $person_result['error'] ?? 'Erreur inconnue';
    $personne = null;
} else {
    $personne = $person_result['data'];
}

// Calcul de l'âge
$age = null;
if ($personne && !empty($personne['date_naissance'])) {
    try {
        $date_naissance = new DateTime($personne['date_naissance']);
        $aujourd_hui = new DateTime();
        $age = $aujourd_hui->diff($date_naissance)->y;
    } catch (Exception $e) {
        $age = null;
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

    <?php if (isset($delete_error)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <?php echo $delete_error; ?>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <div class="page-title-icon"><i class="fas fa-user"></i></div>
            <div>
                <h1><?php echo htmlspecialchars($personne['prenom'] . ' ' . $personne['nom']); ?></h1>
                <div class="breadcrumb">
                    <a href="/admin/personnes/personnes.php">Personnes</a>
                    <span>→</span>
                    <span><?php echo htmlspecialchars($personne['prenom'] . ' ' . $personne['nom']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Container -->
    <div class="details-container">
        <!-- Photo Card -->
        <div class="photo-card">
            <?php if (!empty($personne['photo'])): ?>
                <img src="../../<?php echo htmlspecialchars($personne['photo']); ?>" 
                    alt="<?php echo htmlspecialchars($personne['prenom'] . ' ' . $personne['nom']); ?>" 
                    class="person-photo">
            <?php else: ?>
                <div class="photo-placeholder">
                    <div class="initials-circle">
                        <?php echo obtenirInitialesPersonne($personne['nom'], $personne['prenom']); ?>
                    </div>
                </div>
            <?php endif; ?>

            <h2 class="person-name"><?php echo htmlspecialchars($personne['prenom'] . ' ' . $personne['nom']); ?></h2>
            <div class="person-id">ID: PER-<?php echo str_pad($personne['id_personne'], 6, '0', STR_PAD_LEFT); ?></div>
            <div class="person-type">
                <span><i class="fas fa-<?php echo $personne['type_personne'] === 'femme' ? 'female' : 'male'; ?>"></i></span>
                <?php echo ucfirst($personne['type_personne']); ?>
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
                <h2>Informations Détaillées</h2>
                <div class="status-badge active">
                    Dernière mise à jour: <?php echo formaterDate($personne['date_mise_a_jour'] ?? $personne['date_creation']); ?>
                </div>
            </div>

            <div class="info-content">
                <div class="info-sections">
                    <!-- Informations Personnelles -->
                    <div class="info-section">
                        <div class="section-title">
                            <span class="section-icon"><i class="fas fa-user"></i></span>
                            Informations Personnelles
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Nom complet</div>
                                <div class="info-value"><?php echo htmlspecialchars($personne['prenom'] . ' ' . $personne['nom']); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Sexe</div>
                                <div class="info-value"><?php echo ucfirst($personne['type_personne']); ?></div>
                            </div>
                            <?php if ($age !== null): ?>
                            <div class="info-item">
                                <div class="info-label">Âge</div>
                                <div class="info-value"><?php echo $age; ?> ans</div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Naissance et Origine -->
                    <div class="info-section">
                        <div class="section-title">
                            <span class="section-icon"><i class="fas fa-birthday-cake"></i></span>
                            Naissance et Origine
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Date de naissance</div>
                                <div class="info-value <?php echo empty($personne['date_naissance']) ? 'empty' : ''; ?>">
                                    <?php echo !empty($personne['date_naissance']) ? formaterDate($personne['date_naissance']) : 'Non renseigné'; ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Lieu de naissance</div>
                                <div class="info-value <?php echo empty($personne['lieu_naissance']) ? 'empty' : ''; ?>">
                                    <?php echo !empty($personne['lieu_naissance']) ? htmlspecialchars($personne['lieu_naissance']) : 'Non renseigné'; ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Nationalité</div>
                                <div class="info-value"><?php echo htmlspecialchars($personne['nationalite']); ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations Professionnelles -->
                    <?php if (!empty($personne['profession'])): ?>
                    <div class="info-section">
                        <div class="section-title">
                            <span class="section-icon"><i class="fas fa-briefcase"></i></span>
                            Informations Professionnelles
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Profession</div>
                                <div class="info-value"><?php echo htmlspecialchars($personne['profession']); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Adresse -->
                    <?php if (!empty($personne['adresse_actuelle'])): ?>
                    <div class="info-section">
                        <div class="section-title">
                            <span class="section-icon"><i class="fas fa-map-marker-alt"></i></span>
                            Adresse de Résidence
                        </div>
                        <div class="info-grid full-width">
                            <div class="info-item">
                                <div class="info-label">Adresse complète</div>
                                <div class="info-value"><?php echo htmlspecialchars($personne['adresse_actuelle']); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Informations système -->
                    <div class="info-section">
                        <div class="section-title">
                            <span class="section-icon"><i class="fas fa-info-circle"></i></span>
                            Informations Système
                        </div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Date de création</div>
                                <div class="info-value"><?php echo formaterDate($personne['date_creation']); ?></div>
                            </div>
                            <?php if (!empty($personne['date_mise_a_jour'])): ?>
                            <div class="info-item">
                                <div class="info-label">Dernière modification</div>
                                <div class="info-value"><?php echo formaterDate($personne['date_mise_a_jour']); ?></div>
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