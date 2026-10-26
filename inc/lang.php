<?php
/**
 * Berka Pano - i18n Çoklu Dil Sözlüğü ve Çeviri Motoru
 * TR ve EN Desteği (Genişletilebilir mimari)
 * PHP 8.1 - 8.4+ Tam Uyumlu
 */

declare(strict_types=1);

if (!isset($_SESSION)) {
    session_start();
}

// Aktif Dili Belirle (URL parametresi, Session veya Varsayılan 'tr')
if (isset($_GET['lang']) && in_array(strtolower($_GET['lang']), ['tr', 'en'], true)) {
    $_SESSION['lang'] = strtolower($_GET['lang']);
}

$currentLang = $_SESSION['lang'] ?? 'tr';

$translations = [
    'tr' => [
        // Navigasyon
        'nav_home' => 'Ana Sayfa',
        'nav_about' => 'Hakkımızda',
        'nav_corporate' => 'Kurumsal',
        'nav_products' => 'Ürünlerimiz',
        'nav_features' => 'Özellikler',
        'nav_media' => 'Medya & Haberler',
        'nav_references' => 'Referanslar',
        'nav_contact' => 'İletişim',
        'nav_quote' => 'Teklif Al',
        'nav_catalog' => 'Katalog',

        // Hero & Tasarım Alanları
        'hero_badge' => 'ENDÜSTRİYEL GÜÇ SİSTEMLERİ',
        'hero_slide_num' => '01 — 03',
        'learn_more' => 'İncele',
        'discover_products' => 'Ürünleri Keşfet',
        'get_in_touch' => 'Bize Ulaşın',
        'download_specs' => 'Teknik Şartname',
        'explore_gallery' => 'Galeriye Git',
        'featured_products' => 'Öne Çıkan Ürünlerimiz',
        'featured_products_desc' => 'Uluslararası standartlarda, yüksek dayanıklılık ve kesintisiz güvenlik sunan elektrik panosu çözümlerimiz.',
        'all_products' => 'Tüm Ürünler',
        'media_section_title' => 'Medya & Güncel Haberler',
        'media_section_desc' => 'Tesisimizden son gelişmeler, fuar katılımlarımız ve ürün lansmanlarımız.',
        'all_media' => 'Tüm Haberler',
        'view_details' => 'Detayları Gör',
        'product_code' => 'Ürün Kodu',
        'technical_specs' => 'Teknik Özellikler',

        // İstatistik & Sayaç
        'stat_1_num' => '25+',
        'stat_1_title' => 'Yıllık Deneyim',
        'stat_2_num' => '1200+',
        'stat_2_title' => 'Tamamlanan Proje',
        'stat_3_num' => '35+',
        'stat_3_title' => 'İhracat Ülkesi',
        'stat_4_num' => '%100',
        'stat_4_title' => 'Tip Testli Garanti',

        // İletişim Formu
        'contact_title' => 'Bizimle İletişime Geçin',
        'contact_desc' => 'Projeniz için teknik danışmanlık, pano teklifi veya özel tasarım gereksinimleriniz için bize yazın.',
        'form_name' => 'Adınız Soyadınız',
        'form_email' => 'E-posta Adresiniz',
        'form_phone' => 'Telefon Numaranız',
        'form_subject' => 'Konu / Proje Türü',
        'form_message' => 'Mesajınız...',
        'form_submit' => 'Mesajı Gönder',
        'form_success' => 'Mesajınız başarıyla iletildi. Yetkili mühendisimiz en kısa sürede sizinle irtibata geçecektir.',
        'form_error' => 'Lütfen tüm zorunlu alanları eksiksiz doldurunuz.',

        // Footer
        'footer_about' => 'Berka Pano, alçak gerilim ana dağıtım, MCC, kompanzasyon ve otomasyon panoları üretiminde yüksek kalite ve güvenilirlik sunar.',
        'quick_links' => 'Hızlı Bağlantılar',
        'our_services' => 'Çözümlerimiz',
        'contact_info' => 'İletişim Bilgileri',
        'all_rights_reserved' => 'Tüm hakları saklıdır.',
        'admin_panel' => 'Yönetim Paneli'
    ],
    'en' => [
        // Navigasyon
        'nav_home' => 'Home',
        'nav_about' => 'About Us',
        'nav_corporate' => 'Corporate',
        'nav_products' => 'Products',
        'nav_features' => 'Features',
        'nav_media' => 'Media & News',
        'nav_references' => 'References',
        'nav_contact' => 'Contact',
        'nav_quote' => 'Request Quote',
        'nav_catalog' => 'Catalogue',

        // Hero & Tasarım Alanları
        'hero_badge' => 'INDUSTRIAL POWER SYSTEMS',
        'hero_slide_num' => '01 — 03',
        'learn_more' => 'Explore',
        'discover_products' => 'Discover Products',
        'get_in_touch' => 'Contact Us',
        'download_specs' => 'Technical Specs',
        'explore_gallery' => 'View Gallery',
        'featured_products' => 'Featured Solutions',
        'featured_products_desc' => 'Electrical distribution panels engineered to international standards with durability and safety.',
        'all_products' => 'All Products',
        'media_section_title' => 'Media & Latest Updates',
        'media_section_desc' => 'Latest news, manufacturing milestones, and global exhibition announcements.',
        'all_media' => 'All News',
        'view_details' => 'View Details',
        'product_code' => 'Product Code',
        'technical_specs' => 'Technical Specifications',

        // İstatistik & Sayaç
        'stat_1_num' => '25+',
        'stat_1_title' => 'Years Experience',
        'stat_2_num' => '1200+',
        'stat_2_title' => 'Completed Projects',
        'stat_3_num' => '35+',
        'stat_3_title' => 'Export Countries',
        'stat_4_num' => '100%',
        'stat_4_title' => 'Type-Tested Assurance',

        // İletişim Formu
        'contact_title' => 'Get In Touch With Us',
        'contact_desc' => 'Reach out to our engineering team for technical consulting, project quotes or custom panel designs.',
        'form_name' => 'Full Name',
        'form_email' => 'Email Address',
        'form_phone' => 'Phone Number',
        'form_subject' => 'Subject / Project Type',
        'form_message' => 'Your Message...',
        'form_submit' => 'Send Message',
        'form_success' => 'Your message has been sent successfully. Our engineers will contact you shortly.',
        'form_error' => 'Please fill in all required fields.',

        // Footer
        'footer_about' => 'Berka Pano delivers premium quality and reliability in manufacturing low voltage distribution, MCC, and automation panels.',
        'quick_links' => 'Quick Links',
        'our_services' => 'Solutions',
        'contact_info' => 'Contact Information',
        'all_rights_reserved' => 'All rights reserved.',
        'admin_panel' => 'Admin Panel'
    ]
];

/**
 * Anahtar kelimeyi aktif dilde çevirir
 */
function t(string $key, ?string $lang = null): string {
    global $translations, $currentLang;
    $l = $lang ?? $currentLang;
    return $translations[$l][$key] ?? $translations['tr'][$key] ?? $key;
}

/**
 * Dinamik model alanını aktif dile göre seçer (örn: title_tr veya title_en)
 */
function localized(?array $row, string $fieldPrefix, ?string $lang = null): string {
    if (!$row) {
        return '';
    }
    global $currentLang;
    $l = $lang ?? $currentLang;
    $field = $fieldPrefix . '_' . $l;
    if (!empty($row[$field])) {
        return (string)$row[$field];
    }
    // Geriye dönük Türkçe fallback
    $fallbackField = $fieldPrefix . '_tr';
    return (string)($row[$fallbackField] ?? $row[$fieldPrefix] ?? '');
}
