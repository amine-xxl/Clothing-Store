<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'connect.php';
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO signup (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$firstName, $lastName, $email, $hashedPassword]);
    header('Location: index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" href="minilogo.png" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 10;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.7s ease;
            overflow: hidden;
        }

        .cinematic-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 15;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.25) 40%, rgba(0, 0, 0, 0.25) 60%, rgba(0, 0, 0, 0.7) 100%);
            transition: opacity 0.7s;
        }

        video {
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            display: block;
            filter: brightness(0.95) contrast(1.1) saturate(1.1);
            transition: opacity 0.7s;
            box-shadow: 0 0 80px 0 rgba(0, 0, 0, 0.7);
        }

        .video-container.fading video,
        .video-container.fading .cinematic-overlay {
            opacity: 0.2;
        }

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

        .spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            z-index: 20;
            transform: translate(-50%, -50%);
            width: 48px;
            height: 48px;
            border: 6px solid #fff;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            background: transparent;
        }

        @keyframes spin {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .video-container.fading {
            opacity: 0 !important;
            transition: opacity 0.7s ease;
            pointer-events: none;
        }

        #skipButton {
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            color: #fff;
            font-weight: bold;
            border: none;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
            opacity: 0.97;
            z-index: 20;
            animation: pulse 1.5s infinite;
        }

        #skipButton:hover {
            background: linear-gradient(to right, #2563eb, #1e40af);
            color: #fff;
            opacity: 1;
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

        @media (max-width: 600px) {
            .video-container,
            video,
            .cinematic-overlay {
                width: 100vw !important;
                height: 100vh !important;
            }

            #skipButton {
                top: 12px !important;
                right: 12px !important;
                font-size: 1rem;
                padding: 8px 16px;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-900 to-blue-900 min-h-screen flex flex-col items-center justify-center p-4">

    <!-- Video Container -->
    <div class="video-container" id="videoContainer">
        <div class="cinematic-overlay"></div>
        <div class="spinner" id="videoSpinner" aria-label="Loading video"></div>
        <video autoplay muted id="introVideo" playsinline tabindex="0" aria-label="Intro video" style="display:none;"
            poster="cinematic_poster.jpg" onerror="document.getElementById('videoErrorMsg').style.display='block'">
            <source src="videx2222_hd.mp4" type="video/mp4">
            <source src="videx2222.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
        <div id="videoErrorMsg" style="display:none;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:#fff;background:rgba(0,0,0,0.7);padding:20px;border-radius:8px;z-index:30;">
            Sorry, the intro video could not be loaded.
        </div>
        <button id="skipButton"
            class="absolute top-4 right-4 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold px-5 py-2 rounded-lg shadow-lg hover:from-blue-700 hover:to-blue-900 transition duration-300"
            aria-label="Skip intro video">
            Skip  &gt;&gt;
        </button>
    </div>

    <!-- Login Form -->
    <div class="login-form max-w-md w-full bg-white/10 backdrop-blur-md rounded-xl shadow-xl overflow-hidden border border-white/20"
        id="loginForm">
        <div class="p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">First Time ?!</h1>
                <p class="text-white/80">Welcome, Please Sign Up</p>
            </div>

            <form class="space-y-6" method="POST">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-white/80 mb-1">First Name</label>
                            <input type="text" id="firstName" name="firstName"
                                class="glow-input w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:bg-white/20 transition duration-200"
                                placeholder="Your First Name" required>
                        </div>
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-white/80 mb-1">Last Name</label>
                            <input type="text" id="lastName" name="lastName"
                                class="glow-input w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:bg-white/20 transition duration-200"
                                placeholder="Your Last Name" required>
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-white/80 mb-1">Email Address</label>
                        <input type="email" id="email" name="email"
                            class="glow-input w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:bg-white/20 transition duration-200"
                            placeholder="your@email.com" required>
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
                        Sign Up
                    </button>
                </form>

            <div class="mt-6 text-center">
                <p class="text-white/80 text-sm">
                    Do you have an account?
                    <a href="login.php" class="text-blue-400 hover:text-blue-300 font-medium transition">Login</a>
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
            const videoContainer = document.getElementById('videoContainer');
            const video = document.getElementById('introVideo');
            const loginForm = document.getElementById('loginForm');
            const logoContainer = document.getElementById('logoContainer');
            const skipButton = document.getElementById('skipButton');
            const spinner = document.getElementById('videoSpinner');
            let skipped = false;

            // Show spinner until video is ready
            video.addEventListener('canplay', function () {
                spinner.style.display = 'none';
                video.style.display = '';
                video.style.opacity = '0';
                setTimeout(() => { video.style.opacity = '1'; }, 100); // Fade-in effect
            });

            // Fade out video container
            function showFormAndLogo() {
                if (skipped) return;
                skipped = true;
                videoContainer.classList.add('fading');
                setTimeout(() => {
                    videoContainer.classList.add('hidden');
                    loginForm.classList.add('visible');
                    logoContainer.classList.add('visible');
                }, 700);
            }

            video.addEventListener('ended', showFormAndLogo);
            skipButton.addEventListener('click', showFormAndLogo);

            // Allow Enter key to skip
            document.addEventListener('keydown', function(e) {
                if (!skipped && (e.key === 'Enter' || e.key === ' ')) {
                    showFormAndLogo();
                }
            });

            // Accessibility: focus video for keyboard skip
            video.focus();
            skipButton.focus();
            skipButton.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    skipButton.click();
                }
            });
        });
    </script>

</body>

</html>