<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'connect.php';
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';
    $stmt = $pdo->prepare("INSERT INTO contact (firstname, lastname, email, adress, phone, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$first_name, $last_name, $email, $address, $phone, $message]);
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact | Don't Be Shy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="icon" href="minilogo.png" sizes="32x32" type="image/png">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background-color: #f8f8f8;
        }

        /* Navbar */
        .navbar-brand img {
            height: 30px;
        }

        .nav-link {
            font-weight: 500;
            font-size: 0.9rem;
            color: #333;
            position: relative;
        }

        .nav-link::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            transform-origin: center;
            height: 2px;
            width: 100%;
            background-color: #112180;
            transition: transform 0.3s ease;
        }

        .nav-link:hover::after {
            transform: translateX(-50%) scaleX(1);
        }

        .form-control {
            width: 250px;
        }

        .icon {
            font-size: 1.2rem;
            margin-right: 4px;
        }

        .icon-group {
            position: relative;
        }

        .icon-group:hover {
            background-color: rgb(235, 235, 235);
            border-radius: 10px;
            transition: background-color 0.3s;
        }

        a {
            text-decoration: none;
            color: #333;
        }

        /* Hero Section */
        .gradient-mask {
            position: relative;
            display: flex;
            justify-content: flex-end;
            width: 100%;
            overflow: hidden;
            background-color: #f8f8f8;
        }

        .gradient-mask img {
            width: 52%;
            max-width: none;
            object-fit: cover;
            -webkit-mask-image: linear-gradient(to right, transparent 0%, rgba(0, 0, 0, 0.3) 8%, black 30%, black 100%);
            mask-image: linear-gradient(to right, transparent 0%, rgba(0, 0, 0, 0.3) 8%, black 30%, black 100%);
            -webkit-mask-size: 100%;
            mask-size: 100%;
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            animation: fadeSlide 1.2s ease-out forwards;
        }

        .fade-text {
            position: absolute;
            top: 50%;
            left: 5%;
            transform: translateY(-50%);
            color: #111;
            font-size: clamp(1rem, 2.5vw, 2rem);
            font-weight: bold;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            animation: fadeText 1.4s ease-in-out forwards;
        }

        .hero-section {
            position: relative;
            overflow: hidden;
        }

        .hero-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            width: 100%;
            height: 90vh;
            background-color: #f8f8f8;
        }

        .hero-img {
            width: 60%;
            object-fit: cover;
            -webkit-mask-image: linear-gradient(to right, transparent 0%, rgba(0, 0, 0, 0.3) 10%, black 35%, black 100%);
            mask-image: linear-gradient(to right, transparent 0%, rgba(0, 0, 0, 0.3) 10%, black 35%, black 100%);
            -webkit-mask-size: 100%;
            mask-size: 100%;
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            animation: fadeSlide 1.2s ease-out forwards;
        }

        .hero-content {
            position: absolute;
            left: 5%;
            max-width: 500px;
            color: #111;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.07);
            animation: fadeText 1.4s ease-out forwards;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .hero-desc {
            font-size: 1.1rem;
            color: #444;
        }

        .btn-shop {
            background-color: #ff4d4d;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s ease;
            margin-top: 10px;
            display: inline-block;
            border: none;
            cursor: pointer;
        }

        .btn-shop:hover {
            background-color: #e60000;
        }

        /* Animations */
        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeText {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Footer */
        footer {
            background-color: #f8f9fa;
            padding: 30px 0;
            color: #130d0d;
        }

        .footer-links a {
            color: #333;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #112190;
        }
        address a:hover{
            color: #112190;
        }

        /* Category Section */
        .shop-category {
            text-align: center;
            background-color: #f7f9fb;
            padding: 3rem 1rem;
        }

        .shop-category h2 {
            font-weight: 600;
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .shop-category h2 span {
            border-bottom: 3px solid #ff4d4d;
            padding-bottom: 5px;
            color: #111;
        }

        .category-grid {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .category-card {
            position: relative;
            width: 380px;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            background-color: #fff;
        }

        .category-card:hover {
            transform: translateY(-8px);
        }

        .category-card img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            display: block;
        }

        .overlay {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1.25rem 1rem;
            color: white;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent 60%);
            box-sizing: border-box;
        }

        .overlay h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .shop-link {
            display: inline-block;
            margin-top: 8px;
            font-size: 0.9rem;
            color: white;
            text-decoration: underline;
            font-weight: 500;
        }

        .shop-link:hover {
            color: #112180;
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .category-grid {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .gradient-mask {
                flex-direction: column;
                align-items: center;
            }

            .gradient-mask img {
                width: 100%;
                -webkit-mask-image: none;
                mask-image: none;
            }

            .fade-text,
            .hero-content {
                position: static;
                transform: none;
                text-align: center;
                padding: 15px;
                margin-top: -20px;
                background-color: transparent;
                box-shadow: none;
            }

            .form-control {
                width: 100px;
            }

            .navbar-nav {
                text-align: center;
            }

            .btn-shop {
                margin-top: 15px;
            }

            .hero-title {
                font-size: 1.8rem;
            }

            .hero-desc {
                font-size: 1rem;
            }
        }

        @media (max-width: 600px) {
            .category-card {
                width: 90%;
                max-width: 350px;
            }
        }


        /* Contact Section Upgrade */
        .contact-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 60px 30px;
            background: linear-gradient(to right, #112190, #fff);
            color: white;
        }

        .contact-left,
        .contact-right {
            flex: 1;
            min-width: 300px;
            margin: 15px;
        }

        .contact-left h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .contact-left p {
            font-size: 1rem;
            margin: 12px 0;
            display: flex;
            align-items: center;
        }

        .contact-left i {
            margin-right: 10px;
            color: #f3fcfc;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .form-row input {
            flex: 1;
            min-width: 140px;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background: #444;
            color: white;
            font-size: 1rem;
        }

        textarea {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            background: #444;
            color: white;
            resize: none;
            border: none;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        button[type="submit"] {
            background-color: #112180;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: bold;
            color: white;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0c1761;
        }

        /* === Contact Form Inputs & Textarea Hover + Focus Effects === */
        .contact-container input,
        .contact-container textarea {
            border: 2px solid transparent;
            background-color: #444;
            color: white;
            transition: all 0.3s ease;
            outline: none;
        }

        .contact-container input:hover,
        .contact-container textarea:hover {
            border-color: #112180;
            background-color: #555;
        }

        .contact-container input:focus,
        .contact-container textarea:focus {
            border-color: #112180;
            box-shadow: 0 0 10px #0c1761;
            background-color: #555;
            color: white;
        }

        /* === Submit Button Hover Glow === */
        button[type="submit"] {
            background-color: #112180;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: bold;
            color: white;
            transition: all 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0c1761;
            box-shadow: 0 0 12px rgba(17, 33, 128, 0.6);
        }

        .bag-count {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: #ff4d4d;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
            z-index: 2;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="logoecriture.png" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item mx-3"><a class="nav-link" href="index.html">HOME</a></li>
                    <li class="nav-item mx-3"><a class="nav-link" href="men.html">MEN <sup
                                style="font-size: 0.9rem; color: #dc3545; font-weight: 700;">Promo</sup></a></li>
                    <li class="nav-item mx-3"><a class="nav-link" href="women.html">WOMEN</a></li>
                    <li class="nav-item mx-3"><a class="nav-link" href="kids.html">KIDS <sup
                                style="font-size: 0.9rem; color: #dc3545; font-weight: 700;">Promo</sup></a></li>
                    <li class="nav-item mx-3"><a class="nav-link" href="contact.php">CONTACT-US</a></li>
                </ul>
                <form class="d-flex mx-2 align-items-center">
                    <i class="bi bi-search icon"></i>
                    <input class="form-control me-2" type="search" placeholder="Search for products">
                </form>
                <div class="d-flex align-items-center">
                    <div class="text-center mx-2 icon-group p-2"><a href="signup.php"><i class="bi bi-person icon"></i>
                            <div class="icon-text">Profile</div>
                        </a></div>
                    <div class="text-center mx-2 icon-group p-2">
                        <a href="whishlist.html">
                            <i class="bi bi-cart icon"></i>
                            <div class="icon-text">Wishlist</div>
                            <span class="bag-count" id="wishlistCounter">0</span>
                        </a>
                    </div>
                    <div class="text-center mx-2 icon-group p-2"><a href="bag.html"><i class="bi bi-bag icon"></i>
                            <div class="icon-text">Bag</div>
                            <span class="bag-count" id="bagCounter">0</span>
                        </a></div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main>
        <section class="contact-container">
            <div class="contact-left">
                <h2>Contact Us</h2>
                <p><a href="https://maps.app.goo.gl/iKbqP3HF9yxf2kjH7" style="color: white;"><i class="fa fa-home"></i>ISTA AL ADARISSA</a></p>
                <p><a href="mailto:digitalpartner212@gmail.com"  style="color: white;"><i class="fa fa-envelope"></i>digitalpartner212@gmail.com</a></p>
                <p><i class="fa fa-phone"></i> +212 651 14 82 66</p>
            </div>
            <div class="contact-right">
                <form  method="POST" action="">
                    <div class="form-row">
                        <input type="text" name="first_name" placeholder="First Name" required>
                        <input type="text" name="last_name" placeholder="Last Name" required>
                    </div>
                    <div class="form-row">
                        <input type="email" name="email" placeholder="E-mail" required>
                        <input type="text" name="address" placeholder="Address">
                    </div>
                    <div class="form-row">
                        <input type="text" name="phone" placeholder="Phone">
                    </div>
                    <textarea rows="4" name="message" placeholder="Your message..."></textarea>
                    <button type="submit">Envoyer</button>
                </form>
                <?php if (!empty($success)) {
                    echo '<div style="display:flex;justify-content:center;align-items:center;margin-top:30px;">
                        <div class="alert alert-success shadow-lg text-center" style="max-width:400px;width:100%;font-size:1.2rem;padding:25px 20px;border-radius:12px;background:linear-gradient(90deg,#112190 60%,#fff 100%);color:#fff;">
                            <i class="bi bi-check-circle-fill" style="font-size:2rem;color:#28a745;"></i><br>
                            Merci pour votre message !<br>Nous vous répondrons bientôt.
                        </div>
                    </div>';
                } ?>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <hr class="my-4 bg-light">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-4">Follow <strong>@Digital Partners</strong></h5>
                    <div class="footer-links">
                        <a href="#"><i class="bi bi-facebook"></i> Facebook</a>
                        <a href="#"><i class="bi bi-instagram"></i> Instagram</a>
                        <a href="#"><i class="bi bi-pinterest"></i> Pinterest</a>
                        <a href="#"><i class="bi bi-tiktok"></i> TikTok</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-4">Quick Links</h5>
                    <div class="footer-links">
                        <a href="index.html">Home</a>
                        <a href="men.html">Men</a>
                        <a href="women.html">Women</a>
                        <a href="kids.html">Kids</a>
                        <a href="contact.php">Contact-Us</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="mb-4">Customer Service</h5>
                    <div class="footer-links">
                        <a href="signup.php">My Account</a>
                        <a href="whishlist.html">Wishlist</a>
                        <a href="bag.html">Bag</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-4">Contact Us</h5>
                    <address>
                        <p><a href="https://maps.app.goo.gl/iKbqP3HF9yxf2kjH7"><i
                                    class="fas fa-map-marker-alt me-2"></i> ISTA AL ADARISSA</a></p>
                        <p><i class="fas fa-phone me-2"></i> (+212)612345678</p>
                        <p><a href="mailto:digitalpartner212@gmail.com"><i class="fas fa-envelope me-2"></i> digitalpartner212@gmail.com</p></a>
                    </address>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="row">
                <div class="text-center">
                    <p class="mb-0">&copy; 2025. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="cart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        updateCartCounter();
        updateWishlistCounter();
    });
    </script>
</body>

</html>