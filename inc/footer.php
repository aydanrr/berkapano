<?php
/**
 * Berka Pano - Footer Bileşeni
 * Uçan WhatsApp ve Uçan Instagram butonları
 * Plain text logo, güncel firma adres & çalışma saatleri
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

if (!isset($settings)) {
    $settings = getSettings($db);
}
?>

    <!-- Alt Bilgi (Footer) -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <!-- Düz Yazıyla Berkapano -->
                    <a href="index.php" class="logo" style="color: #fff; margin-bottom: 16px; display: inline-block;">
                        Berkapano
                    </a>
                    <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 22px; color: #cbd5e1;"><?= t('footer_about') ?></p>
                    <div style="display: flex; gap: 16px; align-items: center;">
                        <a href="https://www.instagram.com/berkapano/" target="_blank" rel="noopener" style="color:#e1306c; font-size: 0.95rem; font-weight:800; display:flex; align-items:center; gap:6px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"/></svg>
                            <span>Instagram</span>
                        </a>
                        <a href="https://tr.linkedin.com/company/berka-pano" target="_blank" rel="noopener" style="color:#38bdf8; font-size: 0.95rem; font-weight:800; display:flex; align-items:center; gap:6px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                            <span>LinkedIn</span>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="footer-col-title"><?= t('quick_links') ?></h4>
                    <ul class="footer-links">
                        <li><a href="index.php"><?= t('nav_home') ?></a></li>
                        <li><a href="page.php?slug=hakkimizda"><?= t('nav_about') ?></a></li>
                        <li><a href="products.php"><?= t('nav_products') ?></a></li>
                        <li><a href="page.php?slug=kalite-politikamiz"><?= t('nav_corporate') ?></a></li>
                        <li><a href="page.php?slug=referanslar"><?= t('nav_references') ?></a></li>
                        <li><a href="contact.php"><?= t('nav_contact') ?></a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer-col-title"><?= t('contact_info') ?></h4>
                    <p style="font-size: 0.92rem; margin-bottom: 12px; line-height: 1.6; color: #cbd5e1;">
                        <strong>Adres:</strong> <a href="https://maps.app.goo.gl/FhFeZCzzNvWz7edZ7" target="_blank" rel="noopener" style="color: #cbd5e1; text-decoration: underline; text-underline-offset: 3px;">Gazipaşa, Borsa Cd. Bilen Sitesi no:22 D:E, 01140 Seyhan / Adana</a>
                    </p>
                    <p style="font-size: 0.92rem; margin-bottom: 12px; color: #cbd5e1;">
                        <strong>Telefon:</strong> <a href="tel:05434504542" style="color: #38bdf8; font-weight: 700;">0543 450 45 42</a>
                    </p>
                    <p style="font-size: 0.92rem; color: #cbd5e1;">
                        <strong>Çalışma Saatleri:</strong><br>
                        Pazartesi - Cuma: 08:00 – 18:00<br>
                        Cumartesi: 08:00 – 12:00 | Pazar: Kapalı
                    </p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> Berkapano. <?= t('all_rights_reserved') ?></p>
            </div>
        </div>
    </footer>

    <!-- ==========================================================================
         UÇAN BUTONLAR: SOLDA INSTAGRAM, SAĞDA WHATSAPP
         ========================================================================== -->
    <!-- Sol Köşe: Uçan Instagram Butonu -->
    <a href="https://www.instagram.com/berkapano/" target="_blank" rel="noopener" class="floating-btn-wrap floating-instagram" title="Bizi Instagram'da Takip Edin">
        <div class="floating-circle">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"/></svg>
        </div>
        <span class="floating-label">Instagram</span>
    </a>

    <!-- Sağ Köşe: Uçan WhatsApp Butonu -->
    <a href="https://wa.me/905434504542?text=Merhaba,%20Berka%20Pano%20hakk%C4%B1nda%20bilgi%20ve%20fiyat%20teklifi%20almak%20istiyorum." target="_blank" rel="noopener" class="floating-btn-wrap floating-whatsapp" title="WhatsApp ile Hızlı İletişim">
        <span class="floating-label">WhatsApp Destek</span>
        <div class="floating-circle">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
        </div>
    </a>

    <!-- Mobil Menü Scripti -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('mobileMenuToggle');
            const menu = document.getElementById('navMenu');
            if (toggle && menu) {
                toggle.addEventListener('click', () => {
                    menu.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>
