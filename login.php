<?php
session_start();
require_once 'connect.php';
$errorMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT * FROM signup WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        // Login success
        header('Location: index.html');
        exit();
    } else {
        // Login failed
        $errorMsg = 'Invalid email or password. Please sign up if you don\'t have an account.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="minilogo.png" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .login-form,
        .logo-container {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease 0.5s;
        }

        .login-form.visible,
        .logo-container.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .glow-input:focus {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        button[type="submit"] {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
            }

            50% {
                box-shadow: 0 4px 24px rgba(59, 130, 246, 0.25);
            }

            100% {
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-900 to-blue-900 min-h-screen flex flex-col items-center justify-center p-4">

    <!-- Login Form -->
    <div class="login-form max-w-md w-full bg-white/10 backdrop-blur-md rounded-xl shadow-xl overflow-hidden border border-white/20"
        id="loginForm">
        <div class="p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Welcome Back !</h1>
                <p class="text-white/80">Hi, Please Login</p>
                <?php if (!empty($errorMsg)): ?>
                <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow">
                    <?php echo $errorMsg; ?>
                    <a href="signup.php" class="ml-2 text-blue-600 underline font-semibold">Sign Up</a>
                </div>
                <?php endif; ?>
            </div>


                <form class="space-y-6" method="POST" action="">
                    <div>
                        <label for="email" class="block text-sm font-medium text-white/80 mb-1">Email Address</label>
                        <input type="email" id="email" name="email"
                            class="glow-input w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:bg-white/20 transition duration-200"
                            placeholder="your@email.com" required autofocus>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-white/80 mb-1">Password</label>
                        <input type="password" id="password" name="password"
                            class="glow-input w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:bg-white/20 transition duration-200"
                            placeholder="••••••••" required>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember"
                                class="h-4 w-4 text-blue-500 focus:ring-blue-400 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-white/80">Remember me</label>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 px-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition duration-200">
                        Login
                    </button>
                </form>

            <div class="mt-6 text-center">
                <p class="text-white/80 text-sm">
                    Don't have an account?
                    <a href="signup.php" class="text-blue-400 hover:text-blue-300 font-medium transition">Sign Up</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Logo Container -->
    <div id="logoContainer" class="logo-container mt-6 flex justify-center">
        <img src="logoecriture.png" alt="Logo" class="h-12">
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.getElementById('loginForm');
            const logoContainer = document.getElementById('logoContainer');

            // Add visible class with timeout for animation sync
            setTimeout(() => {
                loginForm.classList.add('visible');
                logoContainer.classList.add('visible');
            }, 300);

        });
    </script>

</body>

</html>