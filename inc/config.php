<?php
/**
 * Berka Pano - Kurumsal Web Çözümü
 * Sistem Yapılandırması ve Hibrit Veritabanı Motoru
 * MySQL & SQLite Otomatik Algılama / Sıfır Hata Garantisi
 * PHP 8.1, 8.2, 8.3, 8.4+ Tam Uyumlu
 */

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

define('ROOT_PATH', dirname(__DIR__));
define('DATA_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'data');
define('UPLOADS_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'images');

if (!is_dir(DATA_PATH)) {
    mkdir(DATA_PATH, 0755, true);
}

// ---------------------------------------------------------
// Akıllı Veritabanı Bağlantısı (Önce MySQL, Olmazsa SQLite)
// ---------------------------------------------------------
$db = null;
$dbType = 'mysql';

// 1. MySQL Bağlantı Denemesi (XAMPP Varsayılanı: localhost, root, şifresiz)
$mysqlHost = '127.0.0.1';
$mysqlDb   = 'berkapano_db';
$mysqlUser = 'root';
$mysqlPass = '';

if (extension_loaded('pdo_mysql')) {
    try {
        // Önce veritabanı var mı kontrol et, yoksa oluştur
        $initPdo = new PDO("mysql:host={$mysqlHost};charset=utf8mb4", $mysqlUser, $mysqlPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $initPdo->exec("CREATE DATABASE IF NOT EXISTS `{$mysqlDb}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        unset($initPdo);

        $db = new PDO("mysql:host={$mysqlHost};dbname={$mysqlDb};charset=utf8mb4", $mysqlUser, $mysqlPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        $dbType = 'mysql';
    } catch (Throwable $e) {
        $db = null;
    }
}

// 2. MySQL başarısız olursa SQLite Denemesi
if (!$db && extension_loaded('pdo_sqlite')) {
    try {
        $dbFile = DATA_PATH . DIRECTORY_SEPARATOR . 'berkapano.sqlite';
        $db = new PDO('sqlite:' . $dbFile, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        $dbType = 'sqlite';
    } catch (Throwable $e) {
        $db = null;
    }
}

if (!$db) {
    die("Veritabanı bağlantı hatası: Sunucunuzda PDO MySQL veya PDO SQLite sürücüsü aktif edilmelidir.");
}

// ---------------------------------------------------------
// Otomatik Tablo Mimarisi (MySQL & SQLite Çapraz Uyumlu)
// ---------------------------------------------------------
if ($dbType === 'mysql') {
    $db->exec("
        CREATE TABLE IF NOT EXISTS `settings` (
            `setting_key` VARCHAR(100) PRIMARY KEY,
            `setting_value` TEXT
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `users` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(150) NOT NULL,
            `email` VARCHAR(191) UNIQUE NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            `role` VARCHAR(50) NOT NULL DEFAULT 'admin',
            `is_protected` TINYINT(1) DEFAULT 0,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `pages` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `slug` VARCHAR(150) UNIQUE NOT NULL,
            `title_tr` VARCHAR(255) NOT NULL,
            `title_en` VARCHAR(255) NOT NULL,
            `content_tr` LONGTEXT,
            `content_en` LONGTEXT,
            `banner_image` VARCHAR(255),
            `sort_order` INT DEFAULT 0,
            `is_active` TINYINT(1) DEFAULT 1,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `products` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `category` VARCHAR(100) NOT NULL DEFAULT 'Genel',
            `title_tr` VARCHAR(255) NOT NULL,
            `title_en` VARCHAR(255) NOT NULL,
            `code` VARCHAR(100) NOT NULL,
            `short_desc_tr` TEXT,
            `short_desc_en` TEXT,
            `specs_tr` TEXT,
            `specs_en` TEXT,
            `image` VARCHAR(255),
            `is_featured` TINYINT(1) DEFAULT 0,
            `sort_order` INT DEFAULT 0,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `media_news` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `type` VARCHAR(50) NOT NULL DEFAULT 'photo',
            `badge_tr` VARCHAR(100),
            `badge_en` VARCHAR(100),
            `title_tr` VARCHAR(255) NOT NULL,
            `title_en` VARCHAR(255) NOT NULL,
            `date_text_tr` VARCHAR(100),
            `date_text_en` VARCHAR(100),
            `subtext_tr` VARCHAR(150),
            `subtext_en` VARCHAR(150),
            `image` VARCHAR(255),
            `link` VARCHAR(255),
            `sort_order` INT DEFAULT 0,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `features` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `step_number` VARCHAR(20) NOT NULL,
            `title_tr` VARCHAR(255) NOT NULL,
            `title_en` VARCHAR(255) NOT NULL,
            `desc_tr` TEXT NOT NULL,
            `desc_en` TEXT NOT NULL,
            `sort_order` INT DEFAULT 0,
            `is_highlighted` TINYINT(1) DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `contact_messages` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `fullname` VARCHAR(150) NOT NULL,
            `email` VARCHAR(191) NOT NULL,
            `phone` VARCHAR(50),
            `subject` VARCHAR(255),
            `message` TEXT NOT NULL,
            `is_read` TINYINT(1) DEFAULT 0,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
} else {
    // SQLite Tablo Yapısı
    $db->exec("
        CREATE TABLE IF NOT EXISTS settings (
            setting_key TEXT PRIMARY KEY,
            setting_value TEXT
        );

        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            role TEXT NOT NULL DEFAULT 'admin',
            is_protected INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS pages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            slug TEXT UNIQUE NOT NULL,
            title_tr TEXT NOT NULL,
            title_en TEXT NOT NULL,
            content_tr TEXT,
            content_en TEXT,
            banner_image TEXT,
            sort_order INTEGER DEFAULT 0,
            is_active INTEGER DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            category TEXT NOT NULL DEFAULT 'Genel',
            title_tr TEXT NOT NULL,
            title_en TEXT NOT NULL,
            code TEXT NOT NULL,
            short_desc_tr TEXT,
            short_desc_en TEXT,
            specs_tr TEXT,
            specs_en TEXT,
            image TEXT,
            is_featured INTEGER DEFAULT 0,
            sort_order INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS media_news (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            type TEXT NOT NULL DEFAULT 'photo',
            badge_tr TEXT,
            badge_en TEXT,
            title_tr TEXT NOT NULL,
            title_en TEXT NOT NULL,
            date_text_tr TEXT,
            date_text_en TEXT,
            subtext_tr TEXT,
            subtext_en TEXT,
            image TEXT,
            link TEXT,
            sort_order INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS features (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            step_number TEXT NOT NULL,
            title_tr TEXT NOT NULL,
            title_en TEXT NOT NULL,
            desc_tr TEXT NOT NULL,
            desc_en TEXT NOT NULL,
            sort_order INTEGER DEFAULT 0,
            is_highlighted INTEGER DEFAULT 0
        );

        CREATE TABLE IF NOT EXISTS contact_messages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            fullname TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT,
            subject TEXT,
            message TEXT NOT NULL,
            is_read INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");
}

// ---------------------------------------------------------
// Süperadmin Kullanıcısını Doğrula / Ekle
// ---------------------------------------------------------
$superEmail = 'suleymannozer0@gmail.com';
$superPass = '7530';

$stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$superEmail]);
$existingUser = $stmt->fetch();

if (!$existingUser) {
    $hashed = password_hash($superPass, PASSWORD_DEFAULT);
    $ins = $db->prepare("INSERT INTO users (name, email, password, role, is_protected) VALUES (?, ?, ?, 'superadmin', 1)");
    $ins->execute(['Süleyman Özer', $superEmail, $hashed]);
} else {
    if (!password_verify($superPass, $existingUser['password'])) {
        $hashed = password_hash($superPass, PASSWORD_DEFAULT);
        $upd = $db->prepare("UPDATE users SET password = ?, role = 'superadmin', is_protected = 1 WHERE email = ?");
        $upd->execute([$hashed, $superEmail]);
    }
}

// ---------------------------------------------------------
// Varsayılan Site Ayarlarını Yükle
// ---------------------------------------------------------
$defaultSettings = [
    'site_title_tr' => 'Berka Pano Elektrik & Otomasyon Sistemleri',
    'site_title_en' => 'Berka Pano Electrical & Automation Systems',
    'site_tagline_tr' => 'Endüstriyel Güç & Dağıtım Panolarında Yenilikçi Çözümler',
    'site_tagline_en' => 'Innovative Solutions in Industrial Power & Distribution Panels',
    'company_name' => 'Berka Pano Ltd. Şti.',
    'phone' => '+90 (212) 555 01 23',
    'phone2' => '+90 (532) 555 01 24',
    'email' => 'info@berkapano.com',
    'address' => 'İkitelli OSB, İsdök Sanayi Sitesi 4. Blok No:18 Başakşehir / İstanbul',
    'map_embed' => 'https://maps.google.com/maps?q=Istanbul&t=&z=13&ie=UTF8&iwloc=&output=embed',
    'primary_color' => '#143464',
    'hero_big_text' => 'BERKA PANO',
    'hero_code' => 'BP-900',
    'hero_title_tr' => 'Yeni Nesil Ağır Sanayi Dağıtım ve Otomasyon Panosu',
    'hero_title_en' => 'Next Generation Heavy Industrial Distribution & Automation Panel',
    'hero_image' => 'berkapano1.jpg',
    'hero_desc_tr' => 'En zorlu endüstriyel koşullara uygun, modüler, tip testli ve IP65 yüksek koruma sınıfına sahip pano çözümleri.',
    'hero_desc_en' => 'Modular, type-tested and IP65 high protection class panel solutions tailored for demanding industrial environments.',
    'social_instagram' => 'https://instagram.com/berkapano',
    'social_linkedin' => 'https://linkedin.com/company/berkapano',
    'social_facebook' => 'https://facebook.com/berkapano'
];

foreach ($defaultSettings as $k => $v) {
    $c = $db->prepare("SELECT COUNT(*) FROM settings WHERE setting_key = ?");
    $c->execute([$k]);
    if ($c->fetchColumn() == 0) {
        $ins = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)");
        $ins->execute([$k, $v]);
    }
}

// ---------------------------------------------------------
// Varsayılan Özellik Kartları (Tasarım görselindeki 01, 02, 03 blokları)
// ---------------------------------------------------------
$cFeat = $db->query("SELECT COUNT(*) FROM features")->fetchColumn();
if ($cFeat == 0) {
    $db->exec("
        INSERT INTO features (step_number, title_tr, title_en, desc_tr, desc_en, sort_order, is_highlighted) VALUES
        ('01', 'Mühendislik & Tasarım', 'Engineering & Design', 'En güncel CAD/EPLAN yazılımları ile projelerinizi sıfır hata payıyla dijital ortamda modelledik.', 'We model your projects in digital environment with zero margin of error using CAD/EPLAN.', 1, 0),
        ('02', 'Tip Testli Güvenilirlik', 'Type-Tested Reliability', 'Uluslararası IEC normlarında onaylı, modüler montaj ve yüksek kısa devre dayanımı sağladık.', 'Certified to international IEC norms, ensuring modular assembly and high short-circuit resistance.', 2, 0),
        ('03', 'Sahada Hızlı Devreye Alma', 'Rapid On-Site Commissioning', 'Her panoyu fabrikasyon testlerden geçirerek hızlı montaj ve kesintisiz enerji akışına hazır hale getirdik.', 'We factory test every panel to ensure rapid installation and uninterrupted energy flow.', 3, 1)
    ");
}

// ---------------------------------------------------------
// Varsayılan Ürünler
// ---------------------------------------------------------
$cProd = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
if ($cProd == 0) {
    $db->exec("
        INSERT INTO products (category, title_tr, title_en, code, short_desc_tr, short_desc_en, specs_tr, specs_en, image, is_featured, sort_order) VALUES
        ('Ana Dağıtım', 'BP-900 Ağır Sanayi Dağıtım Panosu', 'BP-900 Heavy Industrial Distribution Panel', 'BP-900', 'Form 4B yapısında, 6300A akıma kadar dayanıklı modüler ana dağıtım panosu.', 'Form 4B structure, modular main distribution board up to 6300A.', 'Anma Akımı: 6300A | Koruma: IP55/IP65 | Standart: IEC 61439-1/2', 'Rated Current: 6300A | Protection: IP55/IP65 | Standard: IEC 61439-1/2', 'berkapano1.jpg', 1, 1),
        ('Otomasyon & PLC', 'PLC & MCC Motor Kontrol Panosu', 'PLC & MCC Motor Control Center', 'MCC-400', 'Akıllı motor sürücüleri ve uzaktan SCADA entegrasyonuna sahip kontrol panoları.', 'Control panels featuring smart motor drives and remote SCADA integration.', 'Voltaj: 400V AC | Frekans: 50/60 Hz | Haberleşme: Profinet / Modbus', 'Voltage: 400V AC | Frequency: 50/60 Hz | Comms: Profinet / Modbus', 'berkapano2.jpg', 1, 2),
        ('Kompanzasyon', 'Otomatik Harmonik Filtreli Kompanzasyon', 'Automatic Harmonic Filtered Compensation', 'HK-850', 'Tesislerde reaktif güç cezasını önleyen, tiristörlü hızlı kompanzasyon panosu.', 'Fast thyristor switching compensation panel eliminating reactive penalties.', 'Kapasite: 50 - 1200 kVAr | Filtreleme: 189 Hz / P7 | IP Seviyesi: IP54', 'Capacity: 50 - 1200 kVAr | Filter: 189 Hz / P7 | IP Level: IP54', 'berkapano3.jpg', 1, 3),
        ('Tali Dağıtım', 'Modüler Aydınlatma & Priz Dağıtım Panosu', 'Modular Lighting & Socket Distribution Panel', 'TD-200', 'Hastaneler, plazalar ve fabrikalar için kompakt, estetik tali dağıtım çözümü.', 'Compact, aesthetic sub-distribution solution for hospitals, plazas and factories.', 'Montaj Tipi: Sıva Üstü / Sıva Altı | Kilit: Çift Kilit Mekanizması', 'Mount Type: Surface / Flush | Lock: Double Lock Mechanism', 'berkapano4.jpg', 0, 4),
        ('Şantiye Panoları', 'Mobil Şantiye & Saha Güç Kutusu', 'Mobile Site & Field Power Box', 'SP-100', 'Zorlu inşaat ortamları için darbelere dayanıklı polyester gövde.', 'High-impact polyester enclosure engineered for harsh construction environments.', 'Darbe Dayanımı: IK10 | Koruma: IP67 | Soketler: Mennekes CEE', 'Impact Resistance: IK10 | Protection: IP67 | Sockets: Mennekes CEE', 'berkapano5.jpg', 0, 5),
        ('Dış Ortam Panoları', 'Paslanmaz Çelik Dış Mekan Panosu', 'Stainless Steel Outdoor Enclosure', 'SS-700', 'AISI 304/316 paslanmaz çelik, korozyona dayanıklı güneş ve yağmur korumalı.', 'AISI 304/316 stainless steel corrosion-resistant outdoor enclosure.', 'Malzeme: 316 Paslanmaz | Çatı: Eğimli Yağmurluk | Havalandırma: Filtreli Fan', 'Material: 316 Stainless | Roof: Sloped Rain Cover | Vent: Filtered Fan', 'berkapano6.jpg', 1, 6)
    ");
}

// ---------------------------------------------------------
// Varsayılan Medya & Haber Kartları
// ---------------------------------------------------------
$cMedia = $db->query("SELECT COUNT(*) FROM media_news")->fetchColumn();
if ($cMedia == 0) {
    $db->exec("
        INSERT INTO media_news (type, badge_tr, badge_en, title_tr, title_en, date_text_tr, date_text_en, subtext_tr, subtext_en, image, link, sort_order) VALUES
        ('video', 'VİDEO', 'VIDEO', 'Berka Pano Yeni Yüksek Teknolojili Üretim Tesisimiz Açıldı', 'Berka Pano New High-Tech Production Facility Opened', '28 EKİM 2024', '28 OCT 2024', 'Üretim Turu', 'Factory Tour', 'berkapano7.jpg', '#', 1),
        ('photo', 'FOTOĞRAF', 'PHOTO', 'Uluslararası Enerji & Otomasyon Fuarı Standımız ve Lansmanımız', 'Our Booth and Product Launch at the International Energy Fair', '05 KASIM 2024', '05 NOV 2024', '18 FOTOĞRAF', '18 PHOTOS', 'berkapano8.jpg', '#', 2),
        ('photo', 'FOTOĞRAF', 'PHOTO', 'Ağır Sanayi Tipi BP-900 Panolarımızın Seri Üretimi Başladı', 'Serial Production of Heavy Industrial BP-900 Panels Launched', '08 KASIM 2024', '08 NOV 2024', '24 FOTOĞRAF', '24 PHOTOS', 'berkapano9.jpg', '#', 3)
    ");
}

// ---------------------------------------------------------
// Varsayılan Kurumsal Sayfalar
// ---------------------------------------------------------
$cPages = $db->query("SELECT COUNT(*) FROM pages")->fetchColumn();
if ($cPages == 0) {
    $db->exec("
        INSERT INTO pages (slug, title_tr, title_en, content_tr, content_en, banner_image, sort_order) VALUES
        ('hakkimizda', 'Hakkımızda', 'About Us', 
        '<p>Berka Pano olarak, endüstriyel elektrik, güç dağıtımı ve otomasyon panoları imalatında sektörün öncü ve güvenilir çözüm ortağıyız. Yılların getirdiği mühendislik tecrübesi, modern makine parkurumuz ve uluslararası IEC 61439-1/2 tip test sertifikalı tasarımlarımızla ağır sanayiden ticari tesislere kadar enerjiyi güvenle yönlendiriyoruz.</p><p>Misyonumuz; en zorlu saha şartlarında dahi kusursuz çalışan, yüksek güvenlikli, estetik ve sürdürülebilir pano çözümlerini en yüksek mühendislik disipliniyle sunmaktır.</p>',
        '<p>At Berka Pano, we are the industry-leading solution partner in the manufacturing of industrial electrical distribution, power panels, and automation enclosures. With years of engineering expertise, modern machinery, and international IEC 61439-1/2 certified type-tested designs, we safely direct energy from heavy industry to commercial facilities.</p>',
        'berkapano1.jpg', 1),
        
        ('kalite-politikamiz', 'Kalite Politikamız', 'Quality Policy',
        '<p>Tüm imalat aşamalarımızda ISO 9001:2015, ISO 14001 ve ISO 45001 entegre yönetim sistemlerini tavizsiz uyguluyoruz. Ürünlerimiz rutin fabrikasyon dielektrik, izolasyon, fonksiyonel test ve IP sızdırmazlık kontrollerinden geçirilerek sevk edilir.</p>',
        '<p>We strictly apply ISO 9001:2015, ISO 14001, and ISO 45001 integrated management standards across all production processes. Every panel undergoes dielectric, insulation, and IP protection checks before delivery.</p>',
        'berkapano6.jpg', 2),

        ('referanslar', 'Referanslarımız', 'Our References',
        '<p>Türkiye ve dünyada enerji santralleri, organize sanayi bölgeleri, çimento fabrikaları, veri merkezleri ve hastaneler gibi yüzlerce kritik projede Berka Pano güvencesi tercih edilmiştir.</p>',
        '<p>Berka Pano assurance is trusted in hundreds of critical projects including power stations, industrial zones, cement plants, data centers, and hospital complexes worldwide.</p>',
        'berkapano3.jpg', 3)
    ");
}

function getSettings(PDO $db): array {
    $stmt = $db->query("SELECT setting_key, setting_value FROM settings");
    $settings = [];
    while ($row = $stmt->fetch()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    return $settings;
}

$settings = getSettings($db);

function e(?string $string): string {
    return htmlspecialchars($string ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
