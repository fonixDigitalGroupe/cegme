<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const button = document.getElementById('mobileMenuButton');

        menu.classList.toggle('active');
        button.classList.toggle('active');
    }

    // Fermer le menu au clic sur un lien
    document.querySelectorAll('.mobile-menu a').forEach(link => {
        link.addEventListener('click', () => {
            const menu = document.getElementById('mobileMenu');
            const button = document.getElementById('mobileMenuButton');
            menu.classList.remove('active');
            button.classList.remove('active');
        });
    });

    // Fermer le menu en cliquant en dehors
    document.addEventListener('click', (e) => {
        const menu = document.getElementById('mobileMenu');
        const button = document.getElementById('mobileMenuButton');
        const isClickInsideMenu = menu.contains(e.target);
        const isClickOnButton = button.contains(e.target);

        if (!isClickInsideMenu && !isClickOnButton && menu.classList.contains('active')) {
            menu.classList.remove('active');
            button.classList.remove('active');
        }
    });
</script>