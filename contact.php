<?php
/**
 * Berka Pano - İletişim Sayfası
 * Form kaldırıldı. Net kurumsal bilgiler, Google Harita, çalışma saatleri ve hızlı iletişim aksiyonları
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/lang.php';

$pageTitle = t('nav_contact');

require_once __DIR__ . '/inc/header.php';
?>

<div style="background: var(--color-primary-dark); color: #fff; padding: 60px 0; border-bottom-left-radius: var(--radius-xl); border-bottom-right-radius: var(--radius-xl);">
    <div class="container" style="text-align: center;">
        <span class="section-tag" style="color: #38bdf8;"><?= t('nav_contact') ?></span>
        <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 12px;"><?= t('contact_title') ?></h1>
        <p style="color: #cbd5e1; max-width: 600px; margin: 0 auto; font-size: 1.1rem;">
            Elektrik panosu imalatı, teknik danışmanlık ve fiyat teklifleri için bize doğrudan ulaşabilirsiniz.
        </p>
    </div>
</div>

<div class="container section-wrapper">
    <div class="contact-clean-grid">
        <!-- Sol Panel: Resmi Şirket Bilgileri & Çalışma Saatleri -->
        <div>
            <div class="info-box-card">
                <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--color-primary); margin-bottom: 24px;">
                    Berkapano İletişim Detayları
                </h2>

                <!-- Adres -->
                <div class="info-item">
                    <div class="info-icon-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div>
                        <span class="info-label">Fabrika & Ofis Adresi</span>
                        <div class="info-value">
                            Gazipaşa, Borsa Cd. Bilen Sitesi no:22 D:E, 01140 Seyhan / Adana
                        </div>
                    </div>
                </div>

                <!-- Telefon -->
                <div class="info-item">
                    <div class="info-icon-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                    </div>
                    <div>
                        <span class="info-label">Telefon & WhatsApp</span>
                        <div class="info-value">
                            <a href="tel:05434504542">0543 450 45 42</a>
                        </div>
                    </div>
                </div>

                <!-- E-Posta -->
                <div class="info-item">
                    <div class="info-icon-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <div>
                        <span class="info-label">E-Posta</span>
                        <div class="info-value">
                            <a href="mailto:info@berkapano.com">info@berkapano.com</a>
                        </div>
                    </div>
                </div>

                <!-- Sosyal Medya -->
                <div class="info-item">
                    <div class="info-icon-badge">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"/></svg>
                    </div>
                    <div>
                        <span class="info-label">Sosyal Medya Kanalları</span>
                        <div class="info-value" style="display: flex; gap: 14px; margin-top: 4px;">
                            <a href="https://www.instagram.com/berkapano/" target="_blank" rel="noopener" style="color: #e1306c; font-weight: 700;">Instagram</a>
                            <span>&bull;</span>
                            <a href="https://tr.linkedin.com/company/berka-pano" target="_blank" rel="noopener" style="color: #0284c7; font-weight: 700;">LinkedIn</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Çalışma Saatleri Kartı -->
            <div class="info-box-card">
                <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--color-primary); margin-bottom: 16px;">
                    Çalışma Saatleri
                </h3>
                <table class="hours-table">
                    <tbody>
                        <tr>
                            <td>Pazartesi</td>
                            <td>08:00 – 18:00</td>
                        </tr>
                        <tr>
                            <td>Salı</td>
                            <td>08:00 – 18:00</td>
                        </tr>
                        <tr>
                            <td>Çarşamba</td>
                            <td>08:00 – 18:00</td>
                        </tr>
                        <tr>
                            <td>Perşembe</td>
                            <td>08:00 – 18:00</td>
                        </tr>
                        <tr>
                            <td>Cuma</td>
                            <td>08:00 – 18:00</td>
                        </tr>
                        <tr>
                            <td>Cumartesi</td>
                            <td>08:00 – 12:00</td>
                        </tr>
                        <tr>
                            <td>Pazar</td>
                            <td style="color: #ef4444;">Kapalı</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Hızlı Aksiyon Butonları -->
            <div style="display: flex; gap: 14px; flex-wrap: wrap;">
                <a href="tel:05434504542" class="btn btn-primary" style="flex: 1; min-width: 200px; padding: 14px;">
                    Hemen Ara
                </a>
                <a href="https://wa.me/905434504542?text=Merhaba,%20Berka%20Pano%20ile%20ilgili%20g%C3%B6r%C3%BC%C5%9Fmek%20istiyorum." target="_blank" rel="noopener" class="btn btn-outline" style="flex: 1; min-width: 200px; padding: 14px; background: #25d366; color: #fff; border-color: #25d366;">
                    WhatsApp'tan Yaz
                </a>
            </div>
        </div>

        <!-- Sağ Panel: Tam Boyutlu Google Harita -->
        <div class="map-wrapper">
            <iframe 
                src="https://maps.google.com/maps?q=Gazipa%C5%9Fa%2C+Borsa+Cd.+Bilen+Sitesi+no%3A22+D%3AE%2C+01140+Seyhan%2FAdana&t=&z=16&ie=UTF8&iwloc=&output=embed" 
                width="100%" 
                height="100%" 
                style="border:0; min-height: 540px; display:block;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
