<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Mantis - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Public Sans", sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            position: relative;
        }

        /* Arrière-plan avec formes colorées */
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .bg-blur {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
        }

        .bg-blur-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #4285f4, #34a853);
            top: -50px;
            left: -100px;
        }

        .bg-blur-2 {
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, #34a853, #fbbc05);
            bottom: -50px;
            left: 50px;
        }

        .bg-blur-3 {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #ea4335, #fbbc05);
            top: 150px;
            right: -80px;
        }

        /* Container principal */
        .container {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 450px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            min-height: auto;
        }

        /* Partie gauche - Formulaire */
        .login-form-section {
            flex: 1;
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
            border-radius: 12px;
        }

        .logo-text {
            font-size: 22px;
            font-weight: 600;
            color: #1976d2;
        }

        /* En-tête du formulaire */
        .form-header {
            margin-bottom: 30px;
        }

        .form-title {
            font-size: 28px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: #1976d2;
            font-size: 14px;
            text-decoration: none;
        }

        .form-subtitle:hover {
            text-decoration: underline;
        }

        /* Champs du formulaire */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #1a1a1a;
            font-size: 14px;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d0d7de;
            border-radius: 6px;
            font-size: 14px;
            color: #1a1a1a;
            background: #fff;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #1976d2;
            box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.1);
        }

        .form-input::placeholder {
            color: #656d76;
        }

        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #656d76;
            font-size: 16px;
        }

        /* Options du formulaire */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox {
            width: 16px;
            height: 16px;
            accent-color: #1976d2;
        }

        .checkbox-label {
            font-size: 14px;
            color: #1a1a1a;
        }

        .forgot-password {
            color: #1976d2;
            font-size: 14px;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Bouton de connexion */
        .login-button {
            width: 100%;
            padding: 12px;
            background: #1976d2;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            margin-bottom: 32px;
            transition: background-color 0.2s;
        }

        .login-button:hover {
            background: #1565c0;
        }

        /* Pied de page */
        .footer {
            text-align: center;
            font-size: 12px;
            color: #656d76;
        }

        .footer a {
            color: #1976d2;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .footer-links {
            margin-top: 8px;
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #4caf50;
            color: white;
            padding: 16px 20px;
            border-radius: 8px;
            font-size: 14px;
            z-index: 1000;
            min-width: 200px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification-title {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .notification-text {
            font-size: 12px;
            opacity: 0.9;
        }

        .notification-close {
            position: absolute;
            top: 8px;
            right: 8px;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 16px;
            padding: 4px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
                margin: 20px;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            }

            .login-form-section {
                padding: 40px 30px;
            }

            .social-buttons {
                flex-direction: column;
            }

            .social-button {
                justify-content: center;
            }
        }
    </style>
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
                <!-- En-tête du formulaire -->
                <div class="form-header">
                    <h1 class="form-title">Connexion</h1>
                </div>

                <!-- Formulaire -->
                <form id="loginForm">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" placeholder="info@codedthemes.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Mot de passe</label>
                        <div class="password-container">
                            <input type="password" class="form-input" id="password" placeholder="••••••" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">👁</button>
                        </div>
                    </div>

                    <div class="form-options">
                        <div class="checkbox-container">
                            <input type="checkbox" class="checkbox" id="remember">
                            <label for="remember" class="checkbox-label">Se souvenir de moi</label>
                        </div>
                        <a href="#" class="forgot-password">Mot de passe oublié?</a>
                    </div>

                    <button type="submit" class="login-button">Connexion</button>
                </form>
                <!-- Pied de page -->
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
        // Toggle password
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleBtn = document.querySelector('.password-toggle');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleBtn.textContent = '🙈';
            } else {
                passwordField.type = 'password';
                toggleBtn.textContent = '👁';
            }
        }

        // Gestion du formulaire
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = this.querySelector('input[type="email"]').value;
            const password = this.querySelector('input[type="password"]').value;

            if (email && password) {
                const btn = this.querySelector('.login-button');
                const originalText = btn.textContent;
                btn.textContent = 'Logging in...';
                btn.disabled = true;

                setTimeout(() => {
                    alert('Login successful! (Demo)');
                    btn.textContent = originalText;
                    btn.disabled = false;
                }, 1500);
            }
        });

        // Effets focus
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