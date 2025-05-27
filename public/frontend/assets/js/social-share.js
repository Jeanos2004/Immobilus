/**
 * Gestion du partage sur les réseaux sociaux
 */
function shareProperty() {
    // Récupérer les informations de la propriété
    const propertyTitle = document.querySelector('.top-details .left-column h3').innerText;
    const propertyUrl = window.location.href;
    const propertyImage = document.querySelector('.carousel-inner .image-box img').src;
    
    // Créer le modal de partage
    Swal.fire({
        title: 'Partager cette propriété',
        html: `
            <div class="social-share-buttons">
                <a href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(propertyUrl)}" target="_blank" class="btn btn-facebook">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?text=${encodeURIComponent(propertyTitle)}&url=${encodeURIComponent(propertyUrl)}" target="_blank" class="btn btn-twitter">
                    <i class="fab fa-twitter"></i> Twitter
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(propertyUrl)}&title=${encodeURIComponent(propertyTitle)}" target="_blank" class="btn btn-linkedin">
                    <i class="fab fa-linkedin-in"></i> LinkedIn
                </a>
                <a href="https://pinterest.com/pin/create/button/?url=${encodeURIComponent(propertyUrl)}&media=${encodeURIComponent(propertyImage)}&description=${encodeURIComponent(propertyTitle)}" target="_blank" class="btn btn-pinterest">
                    <i class="fab fa-pinterest-p"></i> Pinterest
                </a>
                <a href="https://api.whatsapp.com/send?text=${encodeURIComponent(propertyTitle + ' ' + propertyUrl)}" target="_blank" class="btn btn-whatsapp">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
                <a href="mailto:?subject=${encodeURIComponent('Découvrez cette propriété : ' + propertyTitle)}&body=${encodeURIComponent('Bonjour,\n\nJ\'ai trouvé cette propriété qui pourrait vous intéresser :\n\n' + propertyTitle + '\n\n' + propertyUrl)}" class="btn btn-email">
                    <i class="far fa-envelope"></i> Email
                </a>
            </div>
            <div class="copy-link-container mt-3">
                <div class="input-group">
                    <input type="text" id="property-url" class="form-control" value="${propertyUrl}" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-copy" type="button" onclick="copyLink()">Copier</button>
                    </div>
                </div>
            </div>
        `,
        showConfirmButton: false,
        showCloseButton: true,
        customClass: {
            container: 'social-share-modal'
        }
    });
}

// Fonction pour copier le lien dans le presse-papier
function copyLink() {
    const copyText = document.getElementById("property-url");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    
    // Afficher un message de confirmation
    const copyButton = document.querySelector('.btn-copy');
    const originalText = copyButton.innerText;
    copyButton.innerText = 'Copié !';
    copyButton.classList.add('btn-success');
    
    setTimeout(function() {
        copyButton.innerText = originalText;
        copyButton.classList.remove('btn-success');
    }, 2000);
}

// Ajouter les styles pour les boutons de partage
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        .social-share-modal .swal2-content {
            padding: 0 20px;
        }
        
        .social-share-buttons {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .social-share-buttons a {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-share-buttons a i {
            margin-right: 8px;
        }
        
        .social-share-buttons .btn-facebook {
            background-color: #3b5998;
        }
        
        .social-share-buttons .btn-twitter {
            background-color: #1da1f2;
        }
        
        .social-share-buttons .btn-linkedin {
            background-color: #0077b5;
        }
        
        .social-share-buttons .btn-pinterest {
            background-color: #bd081c;
        }
        
        .social-share-buttons .btn-whatsapp {
            background-color: #25d366;
        }
        
        .social-share-buttons .btn-email {
            background-color: #848484;
        }
        
        .social-share-buttons a:hover {
            opacity: 0.8;
            transform: translateY(-2px);
        }
        
        .copy-link-container {
            margin-top: 15px;
        }
        
        .btn-copy {
            background-color: #2dbe6c;
            color: white;
        }
        
        .btn-success {
            background-color: #28a745;
        }
    `;
    document.head.appendChild(style);
});
