<style>
    .why-choose-grid {
        display: grid;
        grid-template-columns: repeat(3, 389px);
        gap: 32px;
        max-width: 100%;
        justify-content: center;
        margin: 0 auto;
    }

    @media (max-width: 1280px) {
        .why-choose-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }

    @media (max-width: 768px) {
        .why-choose-grid {
            grid-template-columns: 1fr !important;
        }
    }

    section {
        border: none !important;
        border-top: none !important;
        border-bottom: none !important;
        background-color: #ffffff !important;
    }

    body {
        background-color: #ffffff !important;
    }

    * {
        border-color: transparent !important;
    }

    .step-connector {
        position: absolute;
        top: 32px;
        left: calc(50% + 32px);
        right: calc(-50% + 32px);
        height: 2px;
        background: linear-gradient(90deg, rgba(128, 221, 203, 0.7) 0%, rgba(144, 224, 208, 0.9) 50%, rgba(128, 221, 203, 0.7) 100%);
        z-index: 1;
        pointer-events: none;
    }

    @media (max-width: 1024px) {
        .step-connector {
            display: none;
        }
    }

    /* MOBILE ONLY STYLES - Ne pas affecter le desktop */
    @media (max-width: 1024px) {

        /* Empêcher le débordement horizontal */
        body {
            overflow-x: hidden !important;
            max-width: 100vw !important;
        }

        * {
            max-width: 100% !important;
        }

        header {
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px) !important;
        }

        /* Masquer le menu desktop sur mobile */
        .desktop-menu {
            display: none !important;
        }

        /* Afficher le header mobile */
        .mobile-header {
            display: flex !important;
        }

        /* Afficher le bouton hamburger */
        .mobile-menu-button {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* Menu mobile - masqué par défaut avec animation slide */
        .mobile-menu {
            display: block;
            position: fixed;
            top: calc(3px + 64px);
            left: 0;
            right: 0;
            background-color: rgb(255, 255, 255);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 999;
            max-height: calc(100vh - 67px);
            overflow-y: auto;
            border-top: 1px solid rgba(229, 231, 235, 0.5);
            transform: translateY(-100%);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
            pointer-events: none;
        }

        .mobile-menu.active {
            transform: translateY(0);
            opacity: 1;
            pointer-events: auto;
        }

        .mobile-menu a {
            display: block;
            padding: 16px 20px;
            color: rgb(55, 65, 81);
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
            transition: background-color 0.2s ease;
        }

        .mobile-menu a:hover,
        .mobile-menu a:active {
            background-color: rgb(249, 250, 251);
        }

        .mobile-menu a.active {
            background: linear-gradient(180deg, rgb(10, 150, 120) 0%, rgb(16, 185, 150) 100%);
            color: rgb(255, 255, 255);
        }

        /* Header mobile - Style site de référence (Contact) */
        .mobile-header {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 16px 24px !important;
            min-height: 64px !important;
            position: relative;
            z-index: 1000;
            background-color: transparent !important;
            box-shadow: none !important;
            border-bottom: none !important;
        }

        /* Bouton hamburger - Style Contact */
        .mobile-menu-button {
            display: flex !important;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 44px;
            height: 44px;
            background: transparent;
            border: none !important;
            border-radius: 0;
            cursor: pointer;
            padding: 0;
            z-index: 1001;
            gap: 6px;
            position: relative;
            visibility: visible !important;
            opacity: 1 !important;
            margin-left: 0 !important;
            /* Reset margin */
        }

        .mobile-menu-button span {
            width: 24px;
            height: 3px;
            background-color: #000000 !important;
            border-radius: 0;
            transition: all 0.3s ease;
            display: block;
            position: relative;
        }

        .mobile-menu-button:hover,
        .mobile-menu-button:active {
            background: transparent !important;
            border: none !important;
        }

        /* Masquer le bouton Se connecter du header sur mobile */
        .desktop-login-button,
        .desktop-menu {
            display: none !important;
        }

        /* Ajuster le padding du header */
        header nav {
            padding: 12px 0 !important;
        }

        /* Sections mobile - Style site de référence */
        section {
            padding-left: 24px !important;
            padding-right: 24px !important;
            padding-top: 48px !important;
            padding-bottom: 48px !important;
        }

        /* Hero section mobile - Style selon image */
        .hero-section {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            min-height: 100vh !important;
            position: relative !important;
            overflow: hidden !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Image de fond Hero mobile - Style selon site de référence */
        .hero-section>div[style*="background: linear-gradient(to right bottom"] {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100% !important;
            height: 100% !important;
        }

        .hero-section img[alt="Bannière CEGME"] {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            object-position: center center !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            z-index: 1 !important;
            opacity: 0.4 !important;
        }

        /* Overlay gradient sur l'image */
        .hero-section>div[style*="background: linear-gradient(to right bottom"]>div[style*="background: linear-gradient"] {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            z-index: 2 !important;
        }

        /* Conteneur de contenu - Pixel perfect site de référence */
        .hero-section>div[style*="padding-top: 120px"] {
            padding-top: 80px !important;
            padding-bottom: 0 !important;
            padding-left: 24px !important;
            padding-right: 24px !important;
            min-height: 100vh !important;
            position: relative !important;
            z-index: 10 !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: flex-start !important;
            text-align: center !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Largeur des éléments pour correspondre exactement */
        .hero-section>div[style*="padding-top: 120px"]>.hero-title,
        .hero-section>div[style*="padding-top: 120px"]>.hero-description,
        .hero-section>div[style*="padding-top: 120px"]>.hero-buttons {
            max-width: 344px !important;
            width: 100% !important;
        }

        .hero-section>div[style*="padding-top: 120px"]>.hero-buttons {
            max-width: 100% !important;
        }

        .hero-section>div[style*="padding-top: 120px"]>.inline-block {
            max-width: none !important;
            width: auto !important;
            visibility: visible !important;
            opacity: 1 !important;
            display: inline-block !important;
            position: relative !important;
            z-index: 20 !important;
        }

        /* Badge Hero mobile - Pixel perfect site de référence */
        .hero-section .inline-block {
            padding: 4px 16px !important;
            font-size: 13px !important;
            margin-bottom: 24px !important;
            margin-top: 30px !important;
            background-color: rgba(16, 185, 129, 0.3) !important;
            border: 1px solid rgb(5, 150, 105) !important;
            border-radius: 9999px !important;
            width: auto !important;
            max-width: 85% !important;
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
            position: relative !important;
            z-index: 20 !important;
        }

        .hero-section .inline-block p {
            font-size: 16px !important;
            line-height: 28px !important;
            color: rgb(110, 231, 183) !important;
            font-weight: 500 !important;
            padding: 0 !important;
            margin: 0 !important;
            visibility: visible !important;
            opacity: 1 !important;
            display: block !important;
        }

        /* Titre Hero mobile - Pixel perfect site de référence */
        .hero-title {
            font-size: 48px !important;
            line-height: 60px !important;
            padding: 0 !important;
            margin-bottom: 24px !important;
            margin-top: 0 !important;
            font-weight: 700 !important;
            width: 344px !important;
            max-width: 100% !important;
            color: rgb(255, 255, 255) !important;
        }

        .hero-title span {
            display: block !important;
            margin-bottom: 0 !important;
            font-size: 48px !important;
            line-height: 60px !important;
            font-weight: 700 !important;
        }

        .hero-title span.hidden {
            display: none !important;
        }

        .hero-title span.text-white {
            font-size: 48px !important;
            line-height: 60px !important;
            color: rgb(255, 255, 255) !important;
        }

        .hero-title span[style*="color: rgb(20, 184, 166)"] {
            font-size: 48px !important;
            line-height: 60px !important;
            background: linear-gradient(to right, rgb(52, 211, 153), rgb(45, 212, 191)) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
            color: transparent !important;
        }

        /* Description Hero mobile - Pixel perfect site de référence */
        .hero-description {
            font-size: 24px !important;
            line-height: 48px !important;
            padding: 0 !important;
            margin-bottom: 40px !important;
            margin-top: 0 !important;
            color: rgb(229, 231, 235) !important;
            max-width: 768px !important;
            width: 344px !important;
            font-weight: 400 !important;
        }

        /* Boutons Hero mobile - Pixel perfect site de référence */
        .hero-buttons {
            display: flex !important;
            flex-direction: column !important;
            gap: 16px !important;
            padding: 0 !important;
            margin-top: 0 !important;
            margin-bottom: 32px !important;
            width: 100% !important;
            max-width: 100% !important;
            align-items: stretch !important;
            justify-content: center !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .hero-buttons a {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 32px !important;
            font-size: 18px !important;
            line-height: 28px !important;
            text-align: center !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 48px !important;
            min-height: 48px !important;
            border-radius: 9999px !important;
            background-color: rgb(5, 150, 105) !important;
            color: rgb(255, 255, 255) !important;
            font-weight: 500 !important;
            gap: 8px !important;
            flex-shrink: 0 !important;
            box-sizing: border-box !important;
        }

        .hero-buttons>span {
            width: 100% !important;
            max-width: 100% !important;
            padding: 24px 32px !important;
            font-size: 18px !important;
            line-height: 28px !important;
            text-align: center !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 52px !important;
            min-height: 52px !important;
            border-radius: 9999px !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
            border: 2px solid rgb(255, 255, 255) !important;
            color: rgb(255, 255, 255) !important;
            font-weight: 500 !important;
            gap: 8px !important;
            flex-shrink: 0 !important;
            box-sizing: border-box !important;
        }

        .hero-buttons>span.hidden {
            display: none !important;
        }

        .hero-buttons a svg {
            width: 20px !important;
            height: 20px !important;
            stroke-width: 2.5 !important;
        }

        /* Statistiques mobile - Style site de référence */
        .stats-grid,
        .grid.grid-cols-1.md\\:grid-cols-4,
        div[style*="grid-template-columns: repeat(4"] {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
            padding: 0 24px !important;
        }

        /* Statistiques - réduire taille des icônes et textes */
        .stats-grid>div {
            padding: 20px !important;
        }

        .stats-grid .text-4xl,
        .stats-grid .text-5xl {
            font-size: 32px !important;
        }

        .stats-grid .text-xl {
            font-size: 16px !important;
        }

        /* Cartes mobile - empiler verticalement */
        .card-grid,
        .grid.grid-cols-1.md\\:grid-cols-2,
        .grid.grid-cols-1.md\\:grid-cols-3 {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
        }

        /* Titres de sections mobile */
        h2 {
            font-size: 28px !important;
            line-height: 36px !important;
            margin-bottom: 16px !important;
            padding: 0 16px !important;
        }

        /* Textes descriptifs mobile */
        p.text-lg,
        p.text-xl {
            font-size: 16px !important;
            line-height: 24px !important;
            padding: 0 16px !important;
        }

        /* Images mobile */
        img {
            max-width: 100% !important;
            height: auto !important;
        }

        /* Boutons mobile - taille tactile */
        button,
        a[class*="button"],
        a[class*="btn"] {
            min-height: 44px !important;
            padding: 12px 20px !important;
            font-size: 16px !important;
        }

        /* Footer mobile */
        footer {
            padding: 40px 24px 24px !important;
        }

        footer .grid {
            grid-template-columns: 1fr !important;
            gap: 32px !important;
        }

        footer h3 {
            font-size: 18px !important;
            margin-bottom: 16px !important;
        }

        /* About section mobile - empiler image et texte */
        .grid.grid-cols-1.lg\\:grid-cols-2,
        section[style*="background: linear-gradient(to bottom, #ffffff"] .grid {
            grid-template-columns: 1fr !important;
            gap: 32px !important;
            align-items: flex-start !important;
        }

        /* Section "L'Expertise au Service de l'Émergence" mobile - Style site de référence */
        section[style*="background: linear-gradient(to bottom, rgb(248, 250, 252)"] {
            padding: 48px 24px 24px !important;
            /* Reduced bottom padding */
        }

        /* Image dans section About mobile */
        section[style*="background: linear-gradient(to bottom, rgb(248, 250, 252)"] .relative.w-full {
            display: block !important;
            order: 1 !important;
            width: 100% !important;
            margin-bottom: 16px !important;
        }

        /* Remove card styling (shadow, border) from the inner wrapper on mobile */
        section[style*="background: linear-gradient(to bottom, rgb(248, 250, 252)"] .relative.w-full>div {
            box-shadow: none !important;
            border: none !important;
            background: transparent !important;
            min-height: auto !important;
            /* Override inline min-height */
            height: auto !important;
        }

        section[style*="background: linear-gradient(to bottom, rgb(248, 250, 252)"] img[alt="Équipe CEGME"] {
            width: 100% !important;
            height: 250px !important;
            /* Reduced height */
            min-height: auto !important;
            max-height: 250px !important;
            /* Reduced height */
            object-fit: cover !important;
            object-position: center !important;
        }

        /* Grid mobile pour section About */
        section[style*="background: linear-gradient(to bottom, rgb(248, 250, 252)"] .grid {
            grid-template-columns: 1fr !important;
            gap: 32px !important;
        }

        section[style*="background: linear-gradient(to bottom, #ffffff"] div[style*="min-height: 550px"] {
            min-height: 300px !important;
            max-height: 400px !important;
        }

        /* Texte dans section About mobile */
        section[style*="background: linear-gradient(to bottom, #ffffff"] .w-full:not(.relative) {
            order: 2 !important;
            width: 100% !important;
            padding: 0 !important;
        }

        section[style*="background: linear-gradient(to bottom, #ffffff"] h2 {
            font-size: 26px !important;
            line-height: 34px !important;
            margin-bottom: 16px !important;
            padding: 0 !important;
        }

        section[style*="background: linear-gradient(to bottom, #ffffff"] p {
            font-size: 15px !important;
            line-height: 24px !important;
            margin-bottom: 16px !important;
            padding: 0 !important;
        }

        section[style*="background: linear-gradient(to bottom, #ffffff"] .space-y-6 {
            gap: 16px !important;
        }

        /* Projets récents mobile */
        .project-card,
        a[href="/services"] {
            margin-bottom: 24px !important;
            width: 100% !important;
        }

        /* Images de projets mobile */
        .project-card img,
        a[href="/services"] img {
            height: 200px !important;
            object-fit: cover !important;
        }

        /* Logos partenaires mobile */
        .flex.flex-wrap {
            justify-content: center !important;
            gap: 12px !important;
            padding: 0 16px !important;
        }

        /* Cartes de logos partenaires mobile */
        .flex.flex-wrap>div {
            min-width: 120px !important;
            min-height: 100px !important;
            padding: 16px !important;
        }

        .flex.flex-wrap img {
            max-height: 50px !important;
        }

        /* Mot de la direction mobile */
        .max-w-3xl {
            max-width: 100% !important;
            padding: 0 16px !important;
        }

        /* Espacement général mobile */
        .mb-16,
        .mb-12 {
            margin-bottom: 24px !important;
        }

        .gap-12,
        .gap-16 {
            gap: 24px !important;
        }

        /* Footer visibility */
        .desktop-footer {
            display: none !important;
        }

        .mobile-footer-home {
            display: block !important;
        }

        /* FIX: Force footer logo size */
        .mobile-footer-home img {
            height: 40px !important;
            width: auto !important;
            max-width: none !important;
        }
    }

    /* FIX: Force vertical stacking up to 1024px (Tablet & Mobile) */
    @media (max-width: 1024px) {

        .stats-grid-container,
        .identity-grid-container,
        .approach-grid-container,
        .benefits-grid-container,
        .activities-grid-container,
        .projects-grid-container {
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 32px !important;
        }

        /* Stats items vertical alignment */
        .stats-grid-container>div {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            margin-bottom: 32px !important;
        }

        .stats-grid-container>div:last-child {
            margin-bottom: 0 !important;
        }
    }

    /* Desktop - masquer le menu mobile */
    @media (min-width: 769px) {

        .mobile-menu-button,
        .mobile-menu,
        .mobile-header {
            display: none !important;
        }

        ```css footer {
            padding: 40px 24px 24px !important;
        }

        footer .grid {
            grid-template-columns: 1fr !important;
            gap: 32px !important;
        }

        footer h3 {
            font-size: 18px !important;
            margin-bottom: 16px !important;
        }

        /* About section mobile - empiler image et texte */
        .grid.grid-cols-1.lg\:grid-cols-2,
        section[style*="background: linear-gradient(to bottom, #ffffff"] .grid {
            grid-template-columns: 1fr !important;
            gap: 32px !important;
            align-items: flex-start !important;
        }

        /* Section "L'Expertise au Service de l'Émergence" mobile - Style site de référence */
        section[style*="background: linear-gradient(to bottom, rgb(248, 250, 252)"] {
            padding: 48px 24px 24px !important;
            /* Reduced bottom padding */
        }

        /* Image dans section About mobile */
        section[style*="background: linear-gradient(to bottom, rgb(248, 250, 252)"] .relative.w-full {
            display: block !important;
            order: 1 !important;
            width: 100% !important;
            margin-bottom: 16px !important;
        }

        /* Remove card styling (shadow, border) from the inner wrapper on mobile */
        section[style*="background: linear-gradient(to bottom, rgb(248, 250, 252)"] .relative.w-full>div {
            box-shadow: none !important;
            border: none !important;
            background: transparent !important;
            min-height: auto !important;
            /* Override inline min-height */
            height: auto !important;
        }

        section[style*="background: linear-gradient(to bottom, rgb(248, 250, 252)"] img[alt="Équipe CEGME"] {
            width: 100% !important;
            height: 250px !important;
            /* Reduced height */
            min-height: auto !important;
            max-height: 250px !important;
            /* Reduced height */
            object-fit: cover !important;
            object-position: center !important;
        }

        /* Grid mobile pour section About */
        section[style*="background: linear-gradient(to bottom, rgb(248, 250, 252)"] .grid {
            grid-template-columns: 1fr !important;
            gap: 32px !important;
        }

        section[style*="background: linear-gradient(to bottom, #ffffff"] div[style*="min-height: 550px"] {
            min-height: 300px !important;
            max-height: 400px !important;
        }

        /* Texte dans section About mobile */
        section[style*="background: linear-gradient(to bottom, #ffffff"] .w-full:not(.relative) {
            order: 2 !important;
            width: 100% !important;
            padding: 0 !important;
        }

        section[style*="background: linear-gradient(to bottom, #ffffff"] h2 {
            font-size: 26px !important;
            line-height: 34px !important;
            margin-bottom: 16px !important;
            padding: 0 !important;
        }

        section[style*="background: linear-gradient(to bottom, #ffffff"] p {
            font-size: 15px !important;
            line-height: 24px !important;
            margin-bottom: 16px !important;
            padding: 0 !important;
        }

        section[style*="background: linear-gradient(to bottom, #ffffff"] .space-y-6 {
            gap: 16px !important;
        }

        /* Projets récents mobile */
        .project-card,
        a[href="/services"] {
            margin-bottom: 24px !important;
            width: 100% !important;
        }

        /* Images de projets mobile */
        .project-card img,
        a[href="/services"] img {
            height: 200px !important;
            object-fit: cover !important;
        }

        /* Logos partenaires mobile */
        .flex.flex-wrap {
            justify-content: center !important;
            gap: 12px !important;
            padding: 0 16px !important;
        }

        /* Cartes de logos partenaires mobile */
        .flex.flex-wrap>div {
            min-width: 120px !important;
            min-height: 100px !important;
            padding: 16px !important;
        }

        .flex.flex-wrap img {
            max-height: 50px !important;
        }

        /* Mot de la direction mobile */
        .max-w-3xl {
            max-width: 100% !important;
            padding: 0 16px !important;
        }

        /* Espacement général mobile */
        .mb-16,
        .mb-12 {
            margin-bottom: 24px !important;
        }

        .gap-12,
        .gap-16 {
            gap: 24px !important;
        }

        /* Footer visibility */
        .desktop-footer {
            display: none !important;
        }

        .mobile-footer-home {
            display: block !important;
        }

        /* FIX: Force footer logo size */
        .mobile-footer-home img {
            height: 40px !important;
            width: auto !important;
            max-width: none !important;
        }
    }

    /* FIX: Force vertical stacking up to 1024px (Tablet & Mobile) */
    @media (max-width: 1024px) {

        .stats-grid-container,
        .identity-grid-container,
        .approach-grid-container,
        .benefits-grid-container,
        .activities-grid-container,
        .projects-grid-container {
            display: grid !important;
            grid-template-columns: 1fr !important;
            gap: 32px !important;
        }

        /* Stats items vertical alignment */
        .stats-grid-container>div {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            text-align: center !important;
            margin-bottom: 32px !important;
        }

        .stats-grid-container>div:last-child {
            margin-bottom: 0 !important;
        }
    }

    /* Desktop - masquer le menu mobile */
    @media (min-width: 769px) {

        .mobile-menu-button,
        .mobile-menu,
        .mobile-header {
            display: none !important;
        }

        .desktop-menu {
            display: flex !important;
        }

        .mobile-footer-home {
            display: none !important;
        }

        /* Restored Mobile Logo Styles - Placed correctly inside style block */
        .mobile-logo {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            min-width: 0;
        }

        .mobile-logo a {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
            flex: 1;
            text-decoration: none !important;
        }

        .mobile-logo img {
            height: 64px !important;
            width: auto !important;
            flex-shrink: 0;
        }

        .mobile-logo .flex.flex-col {
            min-width: 0;
            flex: 1;
        }

        .mobile-logo span.font-bold {
            font-size: 20px !important;
            line-height: 1.2 !important;
            font-weight: 800 !important;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        .mobile-logo .text-xs,
        .mobile-logo .text-sm {
            font-size: 13px !important;
            line-height: 1.2 !important;
            margin-top: 2px !important;
        }
    }

    /* GLOBAL HEADER IMAGE RESTRAINT (Outside media query) */
    header img {
        height: 64px !important;
        width: auto !important;
        max-width: none !important;
    }
</style>
```