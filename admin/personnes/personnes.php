<?php
require_once __DIR__ . '/../header.php';

// Récupération des filtres
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$per_page = 5;
$offset = ($page - 1) * $per_page;

// Récupération des personnes
$result = getAllPersons($pdo, $search, $per_page, $offset);
$persons = $result['data'];
$total_count = $result['total_count'];
$total_pages = ceil($total_count / $per_page);

// Traitement de la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id_to_delete = (int) $_POST['delete_id'];
    $delete_result = deletePerson($pdo, $id_to_delete);

    if ($delete_result['success']) {
        header('Location: /admin/personnes/personnes.php');
        exit;
    } else {
        $delete_error = implode('<br>', $delete_result['errors']);
        $delete_warnings = $delete_result['warnings'] ?? [];
    }
}




?>
<!-- Page Content -->
<div class="page-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-title">
            <div class="page-title-icon"><i class="fas fa-users"></i></div>
            <h1>Liste des Personnes</h1>
        </div>
        <a href="/admin/personnes/ajout_personne.php" class="add-person-btn">
            <span><i class="fas fa-plus"></i></span>
            Ajouter une Personne
        </a>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <form method="GET" class="filters-form">
            <div class="filters-row">
                <div class="filter-group search-filter">
                    <label class="filter-label">Rechercher</label>
                    <div class="search-box">
                        <input type="text" class="search-input" placeholder="Nom, prénom, profession..."
                            name="search" value="<?php echo htmlspecialchars($search); ?>">
                        <span class="search-icon"><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header">
            <h2 class="table-title">Personnes Enregistrées</h2>
            <div class="table-count">
                <?php echo number_format($total_count, 0, ',', ' '); ?> personne<?php echo $total_count > 1 ? 's' : ''; ?>
                <?php if ($search || $type_filter || $nationality_filter): ?>
                    (<?php echo count($persons); ?> affichée<?php echo count($persons) > 1 ? 's' : ''; ?>)
                <?php endif; ?>
            </div>
        </div>

        <?php if (!$result['success']): ?>
            <div class="error-message">
                <p><?php echo htmlspecialchars($result['error']); ?></p>
            </div>
        <?php elseif (empty($persons)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-users"></i></div>
                <h3>Aucune personne trouvée</h3>
                <?php if ($search || $type_filter || $nationality_filter): ?>
                    <p>Aucune personne ne correspond aux critères de recherche.</p>
                    <a href="?" class="btn btn-outline">Voir toutes les personnes</a>
                <?php else: ?>
                    <p>Aucune personne n'est encore enregistrée dans le système.</p>
                    <a href="/admin/personnes/ajout_personne.php" class="btn btn-primary">Ajouter la première personne</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <table class="persons-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Nom & Prénom</th>
                        <th>Type</th>
                        <th>Date de Naissance</th>
                        <th>Lieu de Naissance</th>
                        <th>Nationalité</th>
                        <th>Profession</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($persons as $person): ?>
                        <tr>
                            <td>
                                <?php
                                $photo_path = getPersonPhoto($person['photo']);
                                if ($photo_path):
                                ?>
                                    <div class="person-photo">
                                        <img src="../../<?php echo htmlspecialchars($photo_path); ?>" alt="Photo actuelle" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                <?php else: ?>
                                    <div class="person-photo placeholder">
                                        <?php echo getPersonInitials($person['nom'], $person['prenom']); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="person-name">
                                    <?php echo htmlspecialchars(strtoupper($person['nom']) . ' ' . ucfirst($person['prenom'])); ?>
                                </div>
                                <div class="person-details">
                                    ID: <?php echo str_pad($person['id_personne'], 5, '0', STR_PAD_LEFT); ?>
                                </div>
                            </td>
                            <td>
                                <span class="person-type-badge <?php echo $person['type_personne']; ?>">
                                    <?php echo ucfirst($person['type_personne']); ?>
                                </span>
                            </td>
                            <td><?php echo formatDate($person['date_naissance']); ?></td>
                            <td><?php echo htmlspecialchars($person['lieu_naissance'] ?: '-'); ?></td>
                            <td><?php echo htmlspecialchars($person['nationalite']); ?></td>
                            <td><?php echo htmlspecialchars($person['profession'] ?: '-'); ?></td>
                            <td>
                                <div class="actions-cell">
                                    <button class="action-btn view" title="Voir les détails"
                                        onclick="viewPerson(<?php echo $person['id_personne']; ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn edit" title="Modifier"
                                        onclick="editPerson(<?php echo $person['id_personne']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Supprimer <?php echo htmlspecialchars($person['prenom'] . ' ' . $person['nom']); ?> ?')">
                                        <input type="hidden" name="delete_id" value="<?php echo $person['id_personne']; ?>">
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

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <div class="pagination-info">
                        Page <?php echo $page; ?> sur <?php echo $total_pages; ?>
                        (<?php echo (($page - 1) * $per_page) + 1; ?>-<?php echo min($page * $per_page, $total_count); ?> sur <?php echo $total_count; ?>)
                    </div>
                    <div class="pagination-controls">
                        <?php if ($page > 1): ?>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => 1])); ?>" class="pagination-btn">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>" class="pagination-btn">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        <?php endif; ?>

                        <?php
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);

                        for ($i = $start_page; $i <= $end_page; $i++):
                        ?>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"
                                class="pagination-btn <?php echo $i === $page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>" class="pagination-btn">
                                <i class="fas fa-angle-right"></i>
                            </a>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $total_pages])); ?>" class="pagination-btn">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    function viewPerson(id) {
        window.location.href = `/admin/personnes/voir_personne.php?id=${id}`;
    }

    function editPerson(id) {
        window.location.href = `/admin/personnes/modifier_personne.php?id=${id}`;
    }
</script>
</body>

</html>