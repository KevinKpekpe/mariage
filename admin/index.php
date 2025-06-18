<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Registre Mariages Civils - Dashboard</title>
    <link rel="stylesheet" href="/admin/style.css">
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
                <a href="#" class="nav-item active">
                    <span class="nav-icon">📊</span>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon">💒</span>
                    Mariages
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon">👥</span>
                    Personnes
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon">👨‍⚖️</span>
                    Officiers
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Gestion</div>
                <a href="#" class="nav-item">
                    <span class="nav-icon">🏛️</span>
                    Communes
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon">👨‍👩‍👧‍👦</span>
                    Parents
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon">✍️</span>
                    Témoins
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <h1 class="header-title">Dashboard</h1>
            <div class="header-actions">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Rechercher...">
                    <span class="search-icon">🔍</span>
                </div>
                <div class="user-profile">
                    <div class="user-avatar">OC</div>
                    <span>Officier Civil</span>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Total Mariages</div>
                        <div class="stat-icon bg-blue">💒</div>
                    </div>
                    <div class="stat-value">1,247</div>
                    <div class="stat-change positive">
                        <span>↗</span>
                        +12% ce mois
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Mariages ce Mois</div>
                        <div class="stat-icon bg-green">📅</div>
                    </div>
                    <div class="stat-value">89</div>
                    <div class="stat-change positive">
                        <span>↗</span>
                        +8% vs mois dernier
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Personnes Enregistrées</div>
                        <div class="stat-icon bg-purple">👥</div>
                    </div>
                    <div class="stat-value">2,894</div>
                    <div class="stat-change positive">
                        <span>↗</span>
                        +156 ce mois
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Communes Actives</div>
                        <div class="stat-icon bg-orange">🏛️</div>
                    </div>
                    <div class="stat-value">24</div>
                    <div class="stat-change">
                        <span>→</span>
                        Stable
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="main.js"></script>
</body>

</html>