<?php
/**
 * Template Name: PBI Hubungi Kami (Interactive Contact Page)
 * Description: Template khusus untuk halaman hubungi kami dengan integrasi WhatsApp Messenger & Customizer.
 * Author: Pangestu Rahmat N (arumsaricorporation.co.id)
 */

defined('ABSPATH') || exit;

get_header();

// Fetch contact details from Customizer
$address  = get_theme_mod('pbi_footer_address', 'Kantor Pusat PBI, Banjarnegara, Jawa Tengah, Indonesia');
$email    = get_theme_mod('pbi_footer_email', 'admin@pesantrenbisnisindonesia.org');
$phone    = get_theme_mod('pbi_footer_phone', '+62 813-3453-7381');
$whatsapp = get_theme_mod('pbi_social_whatsapp', '6281334537381');

$fb_url = get_theme_mod('pbi_social_facebook', 'https://facebook.com/pesantrenbisnisindonesia');
$ig_url = get_theme_mod('pbi_social_instagram', 'https://instagram.com/official.pbi');
$yt_url = get_theme_mod('pbi_social_youtube', 'https://youtube.com/pesantrenbisnisindonesia');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <!-- Page Title Banner -->
    <div class="pbi-page-header" style="background: linear-gradient(135deg, var(--pbi-primary), var(--pbi-charcoal)); padding: 60px 0; color: #fff; text-align: center; position: relative; overflow: hidden;">
        <div class="pbi-container" style="position: relative; z-index: 2;">
            <h1 class="pbi-page-header__title" style="margin: 0; font-size: 36px; font-weight: 700; color: #ffffff; letter-spacing: -0.5px;"><?php the_title(); ?></h1>
            <p style="margin: 10px 0 0 0; color: rgba(255,255,255,0.8); font-size: 16px;">Hubungi tim kami untuk pertanyaan, kemitraan, atau konsultasi program pelatihan PBI</p>
        </div>
        <div style="position: absolute; top: -50%; left: -20%; width: 60%; height: 200%; background: radial-gradient(circle, rgba(212,175,55,0.15) 0%, rgba(0,0,0,0) 70%); z-index: 1;"></div>
    </div>

    <!-- Contact Section Content -->
    <div class="pbi-container" style="padding: 60px 15px; max-width: 1100px; margin: 0 auto;">
        
        <div class="pbi-contact-grid">
            
            <!-- Left: Contact Details Cards -->
            <div class="pbi-contact-info-col">
                <h2 class="pbi-contact-section-title">Informasi Resmi Sekretariat</h2>
                <p class="pbi-contact-section-desc">Silakan hubungi kami atau kunjungi sekretariat kami di alamat berikut:</p>
                
                <div class="pbi-contact-card">
                    <div class="pbi-contact-card__icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div class="pbi-contact-card__content">
                        <h3>Alamat Kantor Pusat</h3>
                        <p><?php echo esc_html($address); ?></p>
                    </div>
                </div>

                <div class="pbi-contact-card">
                    <div class="pbi-contact-card__icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="pbi-contact-card__content">
                        <h3>Hubungi via Email</h3>
                        <p><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></p>
                    </div>
                </div>

                <div class="pbi-contact-card">
                    <div class="pbi-contact-card__icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div class="pbi-contact-card__content">
                        <h3>Telepon & Hotline</h3>
                        <p><?php echo esc_html($phone); ?></p>
                    </div>
                </div>

                <div class="pbi-contact-card">
                    <div class="pbi-contact-card__icon">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div class="pbi-contact-card__content">
                        <h3>Jam Operasional</h3>
                        <p>Senin - Sabtu: 08.00 - 16.00 WIB<br>Minggu & Hari Libur Nasional: Tutup</p>
                    </div>
                </div>

                <!-- Social Follow Us -->
                <div class="pbi-contact-socials-box">
                    <h3>Ikuti Media Sosial PBI</h3>
                    <div class="pbi-contact-socials-links">
                        <?php if ($fb_url) : ?>
                            <a href="<?php echo esc_url($fb_url); ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if ($ig_url) : ?>
                            <a href="<?php echo esc_url($ig_url); ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if ($yt_url) : ?>
                            <a href="<?php echo esc_url($yt_url); ?>" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                        <?php endif; ?>
                        <?php if ($whatsapp) : ?>
                            <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right: Interactive WhatsApp Consultation Form -->
            <div class="pbi-contact-form-col">
                <div class="pbi-contact-form-box">
                    <div class="pbi-contact-form-box__header">
                        <i class="fa-brands fa-whatsapp"></i>
                        <div>
                            <h3>Pesan Cepat WhatsApp</h3>
                            <p>Kirim pertanyaan langsung ke Admin PBI</p>
                        </div>
                    </div>
                    
                    <form id="pbi-wa-contact-form" onsubmit="sendContactToWhatsApp(event);">
                        <div class="pbi-form-group">
                            <label for="wa-name">Nama Lengkap *</label>
                            <input type="text" id="wa-name" placeholder="Masukkan nama lengkap Anda" required>
                        </div>

                        <div class="pbi-form-group">
                            <label for="wa-subject">Kategori Pertanyaan *</label>
                            <select id="wa-subject" required>
                                <option value="" disabled selected>Pilih keperluan Anda</option>
                                <option value="Informasi Pendaftaran Pelatihan">Pendaftaran Pelatihan Terdekat</option>
                                <option value="Keanggotaan UMKM PBI">Keanggotaan & Direktori UMKM</option>
                                <option value="Kerja Sama & Kemitraan">Kerjasama / Sinergi Bisnis</option>
                                <option value="Pertanyaan Umum">Pertanyaan Umum Lainnya</option>
                            </select>
                        </div>

                        <div class="pbi-form-group">
                            <label for="wa-message">Isi Pesan *</label>
                            <textarea id="wa-message" rows="5" placeholder="Tuliskan pertanyaan secara jelas dan lengkap..." required></textarea>
                        </div>

                        <button type="submit" class="pbi-wa-submit-btn">
                            <i class="fa-brands fa-whatsapp"></i> Kirim ke WhatsApp
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Google Maps Embed Container -->
        <div style="margin-top: 50px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; height: 350px;">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126497.43389025983!2d109.61333799655762!3d-7.398918237937517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e700a0fe4ef6f53%3A0x3027d756b3bcf90!2sKabupaten%20Banjarnegara%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

    </div>

</article>

<!-- Custom styling for Contact Grid Layout -->
<style>
.pbi-contact-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 40px;
    align-items: start;
}
.pbi-contact-section-title {
    font-size: 26px;
    color: var(--pbi-primary);
    font-weight: 700;
    margin: 0 0 10px 0;
}
.pbi-contact-section-desc {
    color: #64748b;
    font-size: 15px;
    line-height: 1.6;
    margin: 0 0 30px 0;
}
.pbi-contact-card {
    display: flex;
    gap: 15px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}
.pbi-contact-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.03);
    border-color: var(--pbi-primary);
}
.pbi-contact-card__icon {
    width: 44px;
    height: 44px;
    background: rgba(11, 70, 40, 0.08);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--pbi-primary);
    font-size: 18px;
    flex-shrink: 0;
}
.pbi-contact-card__content h3 {
    margin: 0 0 4px 0;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #1e293b;
    font-weight: 600;
}
.pbi-contact-card__content p {
    margin: 0;
    color: #64748b;
    font-size: 15px;
    line-height: 1.5;
}
.pbi-contact-card__content a {
    color: var(--pbi-primary);
    text-decoration: none;
    font-weight: 600;
}
.pbi-contact-card__content a:hover {
    text-decoration: underline;
}
.pbi-contact-socials-box {
    margin-top: 30px;
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 10px;
    padding: 20px;
}
.pbi-contact-socials-box h3 {
    margin: 0 0 12px 0;
    font-size: 15px;
    color: #1e293b;
    font-weight: 600;
}
.pbi-contact-socials-links {
    display: flex;
    gap: 12px;
}
.pbi-contact-socials-links a {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 16px;
    transition: all 0.3s ease;
}
.pbi-contact-socials-links a:hover {
    background: var(--pbi-primary);
    color: #ffffff;
    border-color: var(--pbi-primary);
    transform: scale(1.1);
}
.pbi-contact-socials-links a[aria-label="WhatsApp"]:hover {
    background: #25d366;
    border-color: #25d366;
}

/* Form Styles */
.pbi-contact-form-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    border-radius: 12px;
    padding: 30px;
}
.pbi-contact-form-box__header {
    display: flex;
    align-items: center;
    gap: 15px;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 20px;
    margin-bottom: 25px;
}
.pbi-contact-form-box__header i {
    font-size: 32px;
    color: #25d366;
}
.pbi-contact-form-box__header h3 {
    margin: 0 0 3px 0;
    font-size: 18px;
    color: #1e293b;
    font-weight: 700;
}
.pbi-contact-form-box__header p {
    margin: 0;
    font-size: 13px;
    color: #64748b;
}
.pbi-form-group {
    margin-bottom: 20px;
}
.pbi-form-group label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 8px;
}
.pbi-form-group input,
.pbi-form-group select,
.pbi-form-group textarea {
    width: 100%;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 15px;
    font-family: inherit;
    color: #334155;
    background: #ffffff;
    transition: all 0.3s ease;
}
.pbi-form-group input:focus,
.pbi-form-group select:focus,
.pbi-form-group textarea:focus {
    outline: none;
    border-color: var(--pbi-primary);
    box-shadow: 0 0 0 3px rgba(11, 70, 40, 0.1);
}
.pbi-wa-submit-btn {
    width: 100%;
    background: #25d366;
    color: #ffffff;
    border: none;
    border-radius: 30px;
    padding: 14px 20px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
}
.pbi-wa-submit-btn:hover {
    background: #20ba5a;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
}

@media (max-width: 768px) {
    .pbi-contact-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}
</style>

<script type="text/javascript">
function sendContactToWhatsApp(e) {
    e.preventDefault();
    
    var name = document.getElementById('wa-name').value;
    var subject = document.getElementById('wa-subject').value;
    var msg = document.getElementById('wa-message').value;
    
    // Formatting text for WhatsApp API
    var text = "*Pertanyaan Baru dari Halaman Kontak*\n\n" +
               "*Nama:* " + name + "\n" +
               "*Kategori:* " + subject + "\n\n" +
               "*Pesan:*\n" + msg;
               
    var encodedText = encodeURIComponent(text);
    var waUrl = "https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp)); ?>?text=" + encodedText;
    
    // Redirect in new window
    window.open(waUrl, '_blank');
}
</script>

<?php
get_footer();
