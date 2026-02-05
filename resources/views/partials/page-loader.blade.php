<style>
    #page-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 999999;
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }

    .loader-circle {
        width: 50px;
        height: 50px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #10b981;
        border-radius: 50%;
        animation: loader-spin 0.6s linear infinite;
    }

    @keyframes loader-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .loader-hidden {
        opacity: 0 !important;
        visibility: hidden !important;
    }
</style>

<div id="page-loader">
    <div class="loader-circle"></div>
</div>

<script>
    (function() {
        // Temps minimum d'affichage du loader (1 seconde)
        const minDisplayTime = 1000;
        const startTime = Date.now();

        document.addEventListener("DOMContentLoaded", function () {
            const elapsedTime = Date.now() - startTime;
            const remainingTime = Math.max(0, minDisplayTime - elapsedTime);

            setTimeout(function () {
                const loader = document.getElementById("page-loader");
                if (loader) {
                    loader.classList.add("loader-hidden");
                    setTimeout(() => {
                        loader.remove();
                    }, 500);
                }
            }, remainingTime);
        });
    })();
</script>
