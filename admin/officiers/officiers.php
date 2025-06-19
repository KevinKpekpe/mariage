<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Registre Mariages Civils - Officiers</title>
    <link rel="stylesheet" href="/admin/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <div class="logo-diamond"></div>
                <div class="logo-text">Mariage</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Menu Principal</div>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-chart-bar"></i></span>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-heart"></i></span>
                    Mariages
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-users"></i></span>
                    Personnes
                </a>
                <a href="#" class="nav-item active">
                    <span class="nav-icon"><i class="fas fa-user-tie"></i></span>
                    Officiers
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Gestion</div>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-city"></i></span>
                    Communes
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-handshake"></i></span>
                    Parents
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-file-signature"></i></span>
                    Témoins
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <h1 class="header-title">Officiers</h1>
            <div class="header-actions">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Rechercher...">
                    <span class="search-icon"><i class="fas fa-search"></i></span>
                </div>
                <div class="user-profile">
                    <div class="user-avatar">OC</div>
                    <span>Officier Civil</span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-title">
                    <div class="page-title-icon"><i class="fas fa-user-tie"></i></div>
                    <h1>Liste des Officiers</h1>
                </div>
                <a href="#" class="add-person-btn">
                    <span><i class="fas fa-plus"></i></span>
                    Ajouter un Officier
                </a>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <div class="filters-row">
                    <div class="filter-group search-filter">
                        <label class="filter-label">Rechercher</label>
                        <div class="search-box">
                            <input type="text" class="search-input" placeholder="Nom, prénom, matricule..." id="searchInput">
                            <span class="search-icon"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Rôle</label>
                        <select class="filter-select" id="typeFilter">
                            <option value="">Tous</option>
                            <option value="admin">Admin</option>
                            <option value="officier_communal">Officier Communal</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Commune</label>
                        <select class="filter-select" id="nationalityFilter">
                            <option value="">Toutes</option>
                            <option value="Kinshasa">Kinshasa</option>
                            <option value="Lubumbashi">Lubumbashi</option>
                            <!-- Ajouter d'autres communes ici -->
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <div class="table-header">
                    <h2 class="table-title">Officiers Enregistrés</h2>
                    <div class="table-count" id="personCount">15 officiers</div>
                </div>

                <table class="persons-table">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Nom & Prénom</th>
                            <th>Rôle</th>
                            <th>Matricule</th>
                            <th>Email</th>
                            <th>Commune</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="personsTableBody">
                        <!-- Sample data -->
                        <tr>
                            <td>
                                <div class="person-photo placeholder">AB</div>
                            </td>
                            <td>
                                <div class="person-name">ALI Baba</div>
                                <div class="person-details">ID: 00001</div>
                            </td>
                            <td>
                                <span class="person-type-badge homme">Admin</span>
                            </td>
                            <td>MAT00001</td>
                            <td>ali.baba@example.com</td>
                            <td>Kinshasa</td>
                            <td>
                                <div class="actions-cell">
                                    <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="person-photo placeholder">CD</div>
                            </td>
                            <td>
                                <div class="person-name">Claire Dupont</div>
                                <div class="person-details">ID: 00002</div>
                            </td>
                            <td>
                                <span class="person-type-badge femme">Officier Communal</span>
                            </td>
                            <td>MAT00002</td>
                            <td>claire.dupont@example.com</td>
                            <td>Lubumbashi</td>
                            <td>
                                <div class="actions-cell">
                                    <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="person-photo placeholder">EF</div>
                            </td>
                            <td>
                                <div class="person-name">Emile Fabre</div>
                                <div class="person-details">ID: 00003</div>
                            </td>
                            <td>
                                <span class="person-type-badge homme">Officier Communal</span>
                            </td>
                            <td>MAT00003</td>
                            <td>emile.fabre@example.com</td>
                            <td>Kinshasa</td>
                            <td>
                                <div class="actions-cell">
                                    <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>