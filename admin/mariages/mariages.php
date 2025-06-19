<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Registre Mariages Civils - Mariages</title>
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
                <a href="#" class="nav-item active">
                    <span class="nav-icon"><i class="fas fa-heart"></i></span>
                    Mariages
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-users"></i></span>
                    Personnes
                </a>
                <a href="#" class="nav-item">
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
            <h1 class="header-title">Mariages</h1>
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
                    <div class="page-title-icon"><i class="fas fa-heart"></i></div>
                    <h1>Liste des Mariages</h1>
                </div>
                <a href="#" class="add-person-btn">
                    <span><i class="fas fa-plus"></i></span>
                    Ajouter un Mariage
                </a>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <div class="filters-row">
                    <div class="filter-group search-filter">
                        <label class="filter-label">Rechercher</label>
                        <div class="search-box">
                            <input type="text" class="search-input" placeholder="Numéro d'acte, époux, épouse..." id="searchInput">
                            <span class="search-icon"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">État de l'acte</label>
                        <select class="filter-select" id="etatActeFilter">
                            <option value="">Tous</option>
                            <option value="actif">Actif</option>
                            <option value="dissous">Dissous</option>
                            <option value="annule">Annulé</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Commune</label>
                        <select class="filter-select" id="communeFilter">
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
                    <h2 class="table-title">Mariages Enregistrés</h2>
                    <div class="table-count" id="mariageCount">542 Mariages</div>
                </div>

                <table class="persons-table">
                    <thead>
                        <tr>
                            <th>Numéro d'acte</th>
                            <th>Date de célébration</th>
                            <th>Époux</th>
                            <th>Épouse</th>
                            <th>Commune</th>
                            <th>État de l'acte</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="mariagesTableBody">
                        <!-- Sample data -->
                        <tr>
                            <td>ACT-2024-001</td>
                            <td>15/07/2024</td>
                            <td>Jean Dupont</td>
                            <td>Marie Mbemba</td>
                            <td>Kinshasa</td>
                            <td>
                                <span class="person-type-badge homme">Actif</span>
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>ACT-2024-002</td>
                            <td>22/08/2024</td>
                            <td>Pierre Kabongo</td>
                            <td>Sophie N'Guyen</td>
                            <td>Lubumbashi</td>
                            <td>
                                <span class="person-type-badge femme">Dissous</span>
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <button class="action-btn view"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>ACT-2024-003</td>
                            <td>01/09/2024</td>
                            <td>Luc Martin</td>
                            <td>Aisha Diallo</td>
                            <td>Kinshasa</td>
                            <td>
                                <span class="person-type-badge homme">Annulé</span>
                            </td>
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