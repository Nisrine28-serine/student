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
            background-color: rgba(0, 0, 0, 0.5); /* Assombrit légèrement la vidéo */
            z-index: -1;
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
        
        <button onclick="window.location.href='dashboard.php'" class="outlook-btn">
            <i class="fas fa-square"></i>
            Se Connecter à Outlook
        </button>
    </div>

    <script>
        // Make sure the logo loads properly
        document.addEventListener('DOMContentLoaded', function() {
            const logo = document.querySelector('.university-logo img');
            logo.onerror = function() {
                // If the logo fails to load, replace with text
                const logoContainer = document.querySelector('.university-logo');
                logoContainer.innerHTML = '<div style="font-size: 28px; font-weight: bold; color: #2b5d8c;">UA</div>';
            };
            
            // Assurez-vous que la vidéo commence à jouer
            const video = document.querySelector('video');
            video.play().catch(error => {
                console.log("Lecture automatique non autorisée:", error);
                // Créer un bouton pour jouer la vidéo si la lecture automatique est bloquée
                const playButton = document.createElement('button');
                playButton.textContent = "Cliquez pour jouer la vidéo";
                playButton.style.position = "fixed";
                playButton.style.bottom = "20px";
                playButton.style.right = "20px";
                playButton.style.zIndex = "1000";
                playButton.onclick = () => video.play();
                document.body.appendChild(playButton);
            });
        });
    </script>
</body>
</html>