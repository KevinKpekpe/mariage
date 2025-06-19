<?php
require_once '../db.php';
require_once '../functions.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    
    $result = authenticateUser($pdo, $email, $password);
    
    if ($result['success']) {
        // Redirect based on role
        if ($result['role'] === 'admin') {
            header('Location: /admin/index.php');
        } else {
            header('Location: /admin/index.php');
        }
        exit;
    } else {
        $errors = $result['errors'];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/admin/auth.css">
    <title>Mantis - Login</title>
</head>
<body>
    <div class="background">
        <div class="bg-blur bg-blur-1"></div>
        <div class="bg-blur bg-blur-2"></div>
        <div class="bg-blur bg-blur-3"></div>
    </div>

    <div class="container">
        <div class="login-wrapper">
            <div class="login-form-section">
                <div class="form-header">
                    <h1 class="form-title">Connexion</h1>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="error-message">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form id="loginForm" method="POST" action="login.php">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="info@codedthemes.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="password-container">
                            <input type="password" class="form-input" id="password" name="password" placeholder="••••••" required>
                            <button type="button" class="password-toggle" aria-label="Afficher/Masquer le mot de passe">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <div class="checkbox-container">
                            <input type="checkbox" class="checkbox" id="remember" name="remember">
                            <label for="remember" class="checkbox-label">Se souvenir de moi</label>
                        </div>
                        <a href="#" class="forgot-password">Mot de passe oublié?</a>
                    </div>

                    <button type="submit" class="login-button">Connexion</button>
                </form>

                <div class="footer">
                    © Made with love by Me<a href="#"> Agathe</a>
                    <div class="footer-links">
                        <a href="#">Terms and Conditions</a> | <a href="#">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleBtn = document.querySelector('.password-toggle');
            const icon = toggleBtn.querySelector('i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.querySelector('.password-toggle').addEventListener('click', togglePassword);

        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'scale(1.01)';
            });

            input.addEventListener('blur', function() {
                this.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>