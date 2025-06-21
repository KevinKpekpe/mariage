<?php
require_once __DIR__ . '/../header.php';

// Pagination and search
$search = $_GET['search'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 15;
$offset = ($page - 1) * $limit;

$result = getAllMariages($pdo, $search, $limit, $offset);

$mariages = $result['data'];
$total_count = $result['total_count'];
$total_pages = ceil($total_count / $limit);

$success_message = '';
if (isset($_GET['success'])) {
    if ($_GET['success'] === 'add') {
        $success_message = 'Le mariage a été ajouté avec succès.';
    } elseif ($_GET['success'] === 'edit') {
        $success_message = 'Le mariage a été modifié avec succès.';
    } elseif ($_GET['success'] === 'delete') {
        $success_message = 'Le mariage a été supprimé avec succès.';
    }
}
?>

        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <div class="page-title-icon"><i class="fas fa-heart"></i></div>
                    <h1>Gestion des Mariages</h1>
                </div>
                <a href="ajout_mariage.php" class="add-person-btn">
                    <span><i class="fas fa-plus"></i></span>
                    Ajouter un Mariage
                </a>
            </div>

            <?php if ($success_message): ?>
            <div class="alert alert-success" style="margin-bottom: 20px;">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
            <?php endif; ?>

            <!-- Filters Section -->
            <div class="filters-section">
                <form method="GET" class="filters-form">
                    <div class="filters-row">
                        <div class="filter-group search-filter">
                            <label class="filter-label">Rechercher</label>
                            <div class="search-box">
                                <input type="text" class="search-input" placeholder="Acte, noms, commune..." name="search" value="<?php echo htmlspecialchars($search); ?>">
                                <span class="search-icon"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Table Section -->
            <div class="table-section">
                <div class="table-header">
                    <h2 class="table-title">Mariages Enregistrés</h2>
                    <div class="table-count">
                        <?php echo number_format($total_count, 0, ',', ' '); ?> mariage<?php echo $total_count > 1 ? 's' : ''; ?>
                    </div>
                </div>

                <?php if (!$result['success']): ?>
                <div class="error-message">
                    <p><?php echo htmlspecialchars($result['error']); ?></p>
                </div>
                <?php elseif (empty($mariages)): ?>
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-heart"></i></div>
                    <h3>Aucun mariage trouvé</h3>
                    <?php if ($search): ?>
                        <p>Aucun mariage ne correspond à votre recherche.</p>
                        <a href="mariages.php" class="btn btn-outline">Voir tous les mariages</a>
                    <?php else: ?>
                        <p>Aucun mariage n'est encore enregistré.</p>
                        <a href="ajout_mariage.php" class="btn btn-primary">Ajouter le premier mariage</a>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                    <table class="persons-table">
                        <thead>
                            <tr>
                                <th>N° Acte</th>
                                <th>Date Célébration</th>
                                <th>Époux</th>
                                <th>Épouse</th>
                                <th>Officier</th>
                                <th>Commune</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($mariages as $mariage): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($mariage['numero_acte_mariage']); ?></td>
                                        <td><?php echo htmlspecialchars(formatDate($mariage['date_celebration'])); ?></td>
                                        <td><?php echo htmlspecialchars($mariage['nom_epoux']); ?></td>
                                        <td><?php echo htmlspecialchars($mariage['nom_epouse']); ?></td>
                                        <td><?php echo htmlspecialchars($mariage['nom_officier']); ?></td>
                                        <td><?php echo htmlspecialchars($mariage['nom_commune']); ?></td>
                                        <td>
                                            <div class="actions-cell">
                                                <a href="modifier_mariage.php?id=<?php echo $mariage['id_mariage']; ?>" class="action-btn edit" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="supprimer_mariage.php?id=<?php echo $mariage['id_mariage']; ?>" class="action-btn delete" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce mariage ?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
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
                    </div>
                    <div class="pagination-controls">
                        <?php if ($page > 1): ?>
                            <a href="?page=1&search=<?php echo urlencode($search); ?>" class="pagination-btn">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                            <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn <?php echo $i === $page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn">
                                <i class="fas fa-angle-right"></i>
                            </a>
                            <a href="?page=<?php echo $total_pages; ?>&search=<?php echo urlencode($search); ?>" class="pagination-btn">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>