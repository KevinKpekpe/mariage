<?php
require_once __DIR__ . '/../header.php'; 

function obtenirInitialesOfficier(string $nom, string $prenom): string {
    $nom_initial = !empty($nom) ? strtoupper(substr($nom, 0, 1)) : '';
    $prenom_initial = !empty($prenom) ? strtoupper(substr($prenom, 0, 1)) : '';
    return $nom_initial . $prenom_initial;
}

$search = $_GET['search'] ?? ''; 
$limit = 50;
$offset = 0; 

$officiersData = obtenirTousOfficiers($pdo, $search, $limit, $offset);

$officiers = $officiersData['data'];
$totalOfficiers = $officiersData['total_count'];
$errorMessage = $officiersData['error'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id_to_delete = (int) $_POST['delete_id'];
    $delete_result = supprimerOfficier($pdo, $id_to_delete);

    if ($delete_result['success']) {
        header('Location: officiers.php');
        exit;
    } else {
        $delete_error = implode('<br>', $delete_result['errors']);
    }
}
?>

<!-- Page Content -->
<div class="page-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <div class="page-title-icon"><i class="fas fa-user-tie"></i></div>
            <h1>Liste des Officiers</h1>
        </div>
        <a href="ajout_officier.php" class="add-person-btn">
            <span><i class="fas fa-plus"></i></span>
            Ajouter un Officier
        </a>
    </div>

    <!-- Search Section -->
    <div class="filters-section">
        <div class="filters-row">
            <div class="filter-group search-filter">
                <label class="filter-label">Rechercher</label>
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Nom, prénom, matricule, email, commune..." id="searchInput" value="<?= htmlspecialchars($search) ?>">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header">
            <h2 class="table-title">Officiers Enregistrés</h2>
            <div class="table-count">
                <?= htmlspecialchars($totalOfficiers) ?> officier(s)
            </div>
        </div>

        <?php if ($errorMessage): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
        <?php elseif (empty($officiers)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-user-tie"></i></div>
                <h3>Aucun officier trouvé</h3>
                <?php if ($search): ?>
                    <p>Aucun officier ne correspond aux critères de recherche.</p>
                    <a href="officiers.php" class="btn btn-outline">Voir tous les officiers</a>
                <?php else: ?>
                    <p>Aucun officier n'est encore enregistré dans le système.</p>
                    <a href="ajout_officier.php" class="btn btn-primary">Ajouter le premier officier</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <table class="persons-table">
                <thead>
                    <tr>
                        <th>Initial</th>
                        <th>Nom & Prénom</th>
                        <th>Rôle</th>
                        <th>Matricule</th>
                        <th>Email</th>
                        <th>Commune</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($officiers as $officier): ?>
                        <tr>
                            <td>
                                <div class="person-photo placeholder">
                                    <?= htmlspecialchars(obtenirInitialesOfficier($officier['nom'], $officier['prenom'])) ?>
                                </div>
                            </td>
                            <td>
                                <div class="person-name"><?= htmlspecialchars($officier['prenom'] . ' ' . $officier['nom']) ?></div>
                                <div class="person-details">ID: <?= htmlspecialchars($officier['id_officier']) ?></div>
                            </td>
                            <td>
                                <span class="person-type-badge homme">
                                    <?= htmlspecialchars(ucfirst(str_replace('_', ' ', $officier['role']))) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($officier['matricule'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($officier['email']) ?></td>
                            <td><?= htmlspecialchars($officier['nom_commune'] ?? '-') ?></td>
                            <td>
                                <div class="actions-cell">
                                    <a class="action-btn view" href="voir_officier.php?id=<?= htmlspecialchars($officier['id_officier']) ?>" title="Voir Détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a class="action-btn edit" href="modifier_officier.php?id=<?= htmlspecialchars($officier['id_officier']) ?>" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Supprimer <?php echo htmlspecialchars($officier['prenom'] . ' ' . $officier['nom']); ?> ?')">
                                        <input type="hidden" name="delete_id" value="<?php echo $officier['id_officier']; ?>">
                                        <button class="action-btn delete" title="Supprimer" type="submit">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const applyFiltersBtn = document.getElementById('applyFilters');
    
    // Fonction pour effectuer la recherche
    function performSearch() {
        const searchTerm = searchInput.value.trim();
        const currentUrl = new URL(window.location);
        
        if (searchTerm) {
            currentUrl.searchParams.set('search', searchTerm);
        } else {
            currentUrl.searchParams.delete('search');
        }
        
        window.location.href = currentUrl.toString();
    }
    
    // Recherche en cliquant sur le bouton
    applyFiltersBtn.addEventListener('click', performSearch);
    
    // Recherche en appuyant sur Entrée
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
});
</script>

