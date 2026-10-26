<?php
/**
 * Berka Pano - xpanel Alt Bölüm
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);
?>
        </div> <!-- .admin-content -->
    </main>

    <script>
    function toggleMobileMenu(forceState) {
        const sheet = document.getElementById('mobileBottomSheet');
        const overlay = document.getElementById('mobileSheetOverlay');
        if (!sheet || !overlay) return;

        const isCurrentlyOpen = sheet.classList.contains('active');
        const shouldOpen = typeof forceState === 'boolean' ? forceState : !isCurrentlyOpen;

        if (shouldOpen) {
            sheet.classList.add('active');
            overlay.classList.add('active');
            document.body.classList.add('mobile-sheet-open');
            sheet.setAttribute('aria-hidden', 'false');
        } else {
            sheet.classList.remove('active');
            overlay.classList.remove('active');
            document.body.classList.remove('mobile-sheet-open');
            sheet.setAttribute('aria-hidden', 'true');
        }
    }

    // ESC tuşu ile kapatma
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            toggleMobileMenu(false);
        }
    });
    </script>
</body>
</html>
