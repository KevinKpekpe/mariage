<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Administration Registre des Mariages Civils</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset & General Styles (Copied from your provided CSS) */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #17a2b8;
            --secondary-color: #343a40;
            --accent-color: #ffc107;
            --light-color: #e9ecef;
            /* Changed light color */
            --dark-color: #212529;
            --text-color: #495057;
            --shadow-color: rgba(0, 0, 0, 0.15);
            --border-radius: 0.5rem;
            --font-family: 'Poppins', sans-serif;
            --transition-duration: 0.3s;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--light-color);
            color: var(--text-color);
            line-height: 1.7;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: var(--primary-color);
            transition: color var(--transition-duration) ease;
        }

        a:hover {
            color: var(--secondary-color);
        }

        /* Utility Classes (Copied from your provided CSS) */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .section-title {
            font-size: 2.75rem;
            color: var(--secondary-color);
            text-align: center;
            margin-bottom: 2.5rem;
            font-weight: 700;
            text-shadow: 0 2px 4px var(--shadow-color);
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--primary-color);
            color: white;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: all var(--transition-duration) ease;
            box-shadow: 0 4px 6px var(--shadow-color);
            border: none;
            cursor: pointer;
            font-family: var(--font-family);
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 6px 10px var(--shadow-color);
        }

        /* Header Styles (Copied from your provided CSS) */
        header {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 5px var(--shadow-color);
            padding: 1.25rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
        }

        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            transition: transform var(--transition-duration) ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo img {
            height: 55px;
            margin-right: 15px;
        }

        .logo h1 {
            font-size: 1.85rem;
            color: var(--dark-color);
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Footer Styles (Copied from your provided CSS) */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 3.5rem 0;
            text-align: center;
        }

        footer p {
            margin-bottom: 1rem;
            font-size: 0.95rem;
            opacity: 0.8;
        }

        .footer-links {
            margin-top: 2rem;
        }

        .footer-links a {
            color: var(--light-color);
            margin: 0 1.25rem;
            font-weight: 500;
            transition: color var(--transition-duration) ease;
        }

        .footer-links a:hover {
            color: var(--accent-color);
            text-decoration: underline;
        }

        /* Login Specific Styles (Modified to use variables) */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 200px);
            padding: 20px;
        }

        .login-form {
            width: 100%;
            max-width: 450px;
            background-color: white;
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: 0 5px 15px var(--shadow-color);
        }

        .login-form h2 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: 600;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo img {
            height: 80px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-family: var(--font-family);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(23, 162, 184, 0.2);
        }

        .btn-login {
            width: 100%;
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all var(--transition-duration) ease;
            font-family: var(--font-family);
        }

        .btn-login:hover {
            background-color: var(--secondary-color);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color var(--transition-duration) ease;
        }

        .back-link a:hover {
            text-decoration: underline;
            color: var(--secondary-color);
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #f5c6cb;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin-left: 30px;
        }

        nav ul li a {
            color: var(--dark-color);
            font-weight: 500;
            padding: 10px 15px;
            border-radius: var(--border-radius);
            transition: background-color var(--transition-duration) ease, color var(--transition-duration) ease;
        }

        nav ul li a:hover {
            background-color: var(--primary-color);
            color: white;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-form">
            <div class="login-logo">
                <img src="../logo.png" alt="Logo Administration">
            </div>

            <h2>Connexion à l'Administration</h2>

            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur:</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" name="submit_login" class="btn btn-login">Se connecter</button>

                <div class="back-link">
                    <a href="../index.php">Retour au site public</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>