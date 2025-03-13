<?php
// Autoriser les requêtes CORS depuis http://localhost pour le développement
header("Access-Control-Allow-Origin: http://localhost"); // Remplacez par le domaine du frontend en production
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Vérifiez si la requête est une pré-vérification CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

session_start();

// Exemple de vérification d'authentification (remplacez par votre logique)
$isAuthenticated = isset($_SESSION['user']); // Vérifiez si l'utilisateur est authentifié

// Répondre avec un message JSON
echo json_encode(["authenticated" => $isAuthenticated, "session" => $_SESSION]);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Université Akahwyen - Portail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="logout.css">
    <style>
        /* Styles supplémentaires pour assurer le bon fonctionnement de la vidéo d'arrière-plan */
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .video-background video {
            position: absolute;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            object-fit: cover;
        }

        .video-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Assombrit légèrement la vidéo */
            z-index: -1;
        }

        /* Ajout de styles pour modal de chargement et messages d'erreur */
        .loading-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .spinner {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #2b5d8c;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            color: white;
            font-size: 18px;
        }

        .error-message {
            display: none;
            color: #ff3333;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 5px;
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Conteneur de la vidéo en arrière-plan -->
    <div class="video-background">
        <video autoplay muted loop playsinline>
            <source src="Video.mp4" type="video/mp4">
            Votre navigateur ne prend pas en charge les vidéos HTML5.
        </video>
    </div>

    <!-- Overlay pour assombrir légèrement la vidéo -->
    <div class="video-overlay"></div>

    <div class="container">
        <div class="university-title">
            <div class="university-logo">
                <img src="image.jpg" alt="Université Akahwyen Logo">
            </div>
            <h1 class="header-title">Université al Akhawyen</h1>
        </div>

        <button id="outlookBtn" class="outlook-btn">
            <i class="fas fa-square"></i>
            Se Connecter à Outlook
        </button>

        <div class="error-message" id="errorMessage">
            Authentification échouée. Veuillez réessayer.
        </div>
    </div>

    <!-- Modal de chargement -->
    <div class="loading-modal" id="loadingModal">
        <div class="spinner"></div>
        <div class="loading-text">Vérification de l'authentification...</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logo = document.querySelector('.university-logo img');
            logo.onerror = function() {
                const logoContainer = document.querySelector('.university-logo');
                logoContainer.innerHTML = '<div style="font-size: 28px; font-weight: bold; color: #2b5d8c;">UA</div>';
            };

            const video = document.querySelector('video');
            video.play().catch(error => {
                console.log("Lecture automatique non autorisée:", error);
                const playButton = document.createElement('button');
                playButton.textContent = "Cliquez pour jouer la vidéo";
                playButton.style.position = "fixed";
                playButton.style.bottom = "20px";
                playButton.style.right = "20px";
                playButton.style.zIndex = "1000";
                playButton.onclick = () => video.play();
                document.body.appendChild(playButton);
            });

            document.getElementById('outlookBtn').addEventListener('click', function() {
                document.getElementById('loadingModal').style.display = 'flex';
                document.getElementById('errorMessage').style.display = 'none';

                fetch('https://students.aui.ma/api/check', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        credentials: 'include'
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('loadingModal').style.display = 'none';

                        if (data.authenticated) { // Vérifiez si l'utilisateur est authentifié
                            window.location.href = 'dashboard.php';
                        } else {
                            document.getElementById('errorMessage').style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la vérification de l\'authentification:', error);
                        document.getElementById('loadingModal').style.display = 'none';
                        document.getElementById('errorMessage').textContent = 'Erreur de connexion au serveur. Veuillez réessayer plus tard.';
                        document.getElementById('errorMessage').style.display = 'block';
                    });
            });
        });
    </script>
</body>

</html>