// Menu Burger JavaScript
document.addEventListener('DOMContentLoaded', () => {
    const burgerMenuContainer = document.getElementById('burger-menu-container');
    const headerContainer = document.querySelector('.header-container');
    const navbar = document.querySelector('.navbar');
    const menu = document.querySelector('.menu');

    // Create burger menu button
    const burgerButton = document.createElement('div');
    burgerButton.classList.add('burger-menu');
    burgerButton.innerHTML = `
        <span></span>
        <span></span>
        <span></span>
    `;

    // Create burger menu modal
    const burgerModal = document.createElement('div');
    burgerModal.classList.add('burger-modal');
    burgerModal.style.display = 'none';

    // Move navbar content to burger modal
    const burgerModalContent = document.createElement('div');
    burgerModalContent.classList.add('burger-modal-content');
    
    // Move header container content to burger modal
    // Preserve original logo placement
    const originalLogo = document.querySelector('.logo');
    const clonedLogo = originalLogo ? originalLogo.cloneNode(true) : null;
    
    burgerModalContent.appendChild(navbar.cloneNode(true));
    
    // Add logo at the top of the menu if it exists
    if (clonedLogo) {
        const logoContainer = document.createElement('div');
        logoContainer.classList.add('burger-logo-container');
        logoContainer.appendChild(clonedLogo);
        burgerModalContent.appendChild(logoContainer);
    }
    
    burgerModalContent.appendChild(menu.cloneNode(true));

    burgerModal.appendChild(burgerModalContent);

    // Close button for modal
    const closeButton = document.createElement('div');
    closeButton.classList.add('burger-close');
    closeButton.innerHTML = '&times;';
    burgerModal.appendChild(closeButton);

    // Add to container
    burgerMenuContainer.appendChild(burgerButton);
    burgerMenuContainer.appendChild(burgerModal);

    // Toggle burger menu
    burgerButton.addEventListener('click', () => {
        burgerModal.style.display = 'block';
    });

    // Close burger menu
    closeButton.addEventListener('click', () => {
        burgerModal.style.display = 'none';
    });

    // Close modal if clicked outside
    burgerModal.addEventListener('click', (e) => {
        if (e.target === burgerModal) {
            burgerModal.style.display = 'none';
        }
    });
});