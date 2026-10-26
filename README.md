# BERKA PANO - KURUMSAL WEB SİTESİ VE XPANEL KULLANIM KILAVUZU

Bu proje, modern kurumsal kimlik, yüksek kontrastlı endüstriyel tipografi, yumuşak hatlar (soft-radius) ve PHP 8.1, 8.2, 8.3, 8.4+ sürümleriyle tam uyumlu olacak şekilde geliştirilmiştir.

---

## 1. YÖNETİM PANELİ (XPANEL) GİRİŞ BİLGİLERİ

- **Giriş URL:** `http://localhost/berkapano/xpanel/login.php` (veya `http://127.0.0.1:8088/xpanel/login.php`)
- **Yönetici E-Posta:** `suleymannozer0@gmail.com`
- **Şifre:** `7530`
- **Rol:** `superadmin` (Dışarıdan silinemez, yetkisi kısıtlanamaz şekilde veritabanında korunmaktadır.)

---

## 2. GELİŞTİRİLEN BÖLÜMLER & ÖZELLİKLER

1. **Görsel Tasarım Formatı & Hero Alanı:**
   - Arka planda büyük transparan model kodu filigranı (Örn: `BP-900`).
   - Merkezde yüksek çözünürlüklü endüstriyel pano görseli (`images/` klasöründeki görsellerle).
   - Keskin köşeler yerine modern, yumuşak kavisler (`border-radius: 16px - 24px`, pill butonlar).

2. **01 - 02 - 03 Özellik Şeritleri:**
   - Tasarımdaki 3'lü blok (`01 Mühendislik`, `02 Tip Testli Güvenilirlik`, `03 Koyu Vurgulu Saha Devreye Alma`).
   - Yönetim panelinden metinleri, başlıkları ve vurguları tek tıkla düzenlenebilir.

3. **Medya & Haber Kartları (Görselin Altındaki Bölüm):**
   - Rozet (VİDEO, FOTOĞRAF), tarih etiketi, başlık ve alt galeri sayısı içeren 3'lü şık kart grubu.
   - Yönetim panelinden yeni kart eklenebilir, silinebilir veya görselleri değiştirilebilir.

4. **Ürünler Kataloğu & Filtreleme (`products.php`):**
   - Kategorilere göre filtreleme (Ana Dağıtım, MCC/Otomasyon, Kompanzasyon vb.).
   - Her ürün için anında teklif isteme butonu.

5. **Kurumsal Sayfalar (`page.php`):**
   - `Hakkımızda`, `Kalite Politikamız`, `Referanslarımız` gibi sayfalar.
   - Panelden sınırsız yeni kurumsal sayfa veya alan ekleme imkanı.

6. **İki Dilli Mimari (i18n):**
   - Türkçe (TR) ve İngilizce (EN) anında dil değiştirme desteği.
   - Hiçbir metin hardcoded değildir; `inc/lang.php` ve veritabanı çift kolon yapısıyla çalışır.

7. **İletişim & Teklif Formu (`contact.php`):**
   - Ziyaretçilerin doğrudan teklif veya mesaj iletebildiği sistem.
   - Gelen tüm mesajlar xpanel içerisindeki **Gelen Mesajlar** ekranına anında düşer.

---

## 3. PHP SÜRÜM UYUMLULUĞU

- PHP 8.1, PHP 8.2, PHP 8.3 ve PHP 8.4+ standartları (`declare(strict_types=1);`, PDO prepared statements, null-safe fonksiyonlar ve güncel password_hash API) eksiksiz uygulanmıştır.
- Sürüm yükseltmelerinde bozulma yapmaz; harici kütüphane bağımlılığı olmadan saf ve yüksek performanslı çalışır.
