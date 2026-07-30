<?php
/**
 * Template Name: Masuk Anggota (Landing Page App & Web)
 * Description: Custom page template for /masuk-anggota to guide users to Flutter Mobile App or Web Login fallback.
 */
defined('ABSPATH') || exit;

get_header();

$primary = get_theme_mod('pbi_primary_color', '#0B4628');
$accent  = get_theme_mod('pbi_accent_color', '#D4AF37');
?>

<div class="pbi-masuk-anggota-hero" style="background: linear-gradient(135deg, <?php echo esc_attr($primary); ?> 0%, #052414 100%); padding: 100px 0 80px; color: #ffffff; position: relative; overflow: hidden;">
    <!-- Decorative Glows -->
    <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(212,175,55,0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    <div style="position: absolute; bottom: -50px; left: -50px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(212,175,55,0.1) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="pbi-container" style="max-width: 1000px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between; gap: 40px; flex-wrap: wrap; position: relative; z-index: 2;">
        
        <!-- Left Side: App Pitch -->
        <div style="flex: 1; min-width: 320px;">
            <span style="background: <?php echo esc_attr($accent); ?>; color: #fff; padding: 5px 16px; font-size: 11px; font-weight: 700; border-radius: 20px; text-transform: uppercase; letter-spacing: 1.5px; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(212,175,55,0.3);">
                <i class="fa-solid fa-mobile-screen-button"></i> PBI Mobile App (Flutter)
            </span>
            <h1 style="color: #ffffff; margin: 0 0 15px; font-size: 36px; font-weight: 800; line-height: 1.3;">
                Akses Komunitas PBI<br>Dalam Genggaman Anda
            </h1>
            <p style="margin: 0 0 30px; color: rgba(255,255,255,0.85); font-size: 16px; line-height: 1.7;">
                Nikmati kemudahan akses direktori UMKM alumni, info program terupdate, dan fitur jejaring sosial wirausaha muslim langsung dari aplikasi mobile resmi PBI di smartphone Anda.
            </p>

            <!-- App Benefits -->
            <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 35px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="background: rgba(255,255,255,0.1); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: <?php echo esc_attr($accent); ?>; font-size: 14px;">
                        <i class="fa-solid fa-users"></i>
                    </span>
                    <span style="font-size: 14.5px; font-weight: 600; color: rgba(255,255,255,0.9);">Hubungi &amp; Kolaborasi dengan 700+ Alumni</span>
                </div>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="background: rgba(255,255,255,0.1); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: <?php echo esc_attr($accent); ?>; font-size: 14px;">
                        <i class="fa-solid fa-store"></i>
                    </span>
                    <span style="font-size: 14.5px; font-weight: 600; color: rgba(255,255,255,0.9);">Promosikan Produk UMKM Anda Nasional</span>
                </div>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="background: rgba(255,255,255,0.1); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: <?php echo esc_attr($accent); ?>; font-size: 14px;">
                        <i class="fa-solid fa-bell"></i>
                    </span>
                    <span style="font-size: 14.5px; font-weight: 600; color: rgba(255,255,255,0.9);">Notifikasi Jadwal Kegiatan &amp; Event Terbaru</span>
                </div>
            </div>

            <!-- Download Badges -->
            <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 25px;">
                <!-- Google Play Button -->
                <a href="https://play.google.com/store" target="_blank" rel="noopener" style="display: flex; align-items: center; background: #000000; border: 1px solid rgba(255,255,255,0.2); padding: 8px 18px; border-radius: 8px; text-decoration: none; color: #fff; gap: 10px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                    <i class="fa-brands fa-google-play" style="font-size: 24px; color: #3BCCFF;"></i>
                    <div style="text-align: left; line-height: 1.2;">
                        <div style="font-size: 10px; text-transform: uppercase; color: rgba(255,255,255,0.6);">Dapatkan di</div>
                        <div style="font-size: 15px; font-weight: 700;">Google Play</div>
                    </div>
                </a>

                <!-- App Store Button -->
                <a href="https://apps.apple.com" target="_blank" rel="noopener" style="display: flex; align-items: center; background: #000000; border: 1px solid rgba(255,255,255,0.2); padding: 8px 18px; border-radius: 8px; text-decoration: none; color: #fff; gap: 10px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                    <i class="fa-brands fa-apple" style="font-size: 26px; color: #ffffff;"></i>
                    <div style="text-align: left; line-height: 1.2;">
                        <div style="font-size: 10px; text-transform: uppercase; color: rgba(255,255,255,0.6);">Download di</div>
                        <div style="font-size: 15px; font-weight: 700;">App Store</div>
                    </div>
                </a>
            </div>
            
            <p style="font-size: 12px; color: rgba(255,255,255,0.6); margin: 0;">*Aplikasi mobile PBI dikembangkan menggunakan Flutter Framework.</p>
        </div>

        <!-- Right Side: Web Login Card -->
        <div style="flex: 0 0 360px; min-width: 320px; background: rgba(255,255,255,0.08); border-radius: 20px; border: 1px solid rgba(255,255,255,0.15); padding: 30px; backdrop-filter: blur(15px); text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
            <div style="background: rgba(212,175,55,0.15); width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: <?php echo esc_attr($accent); ?>; font-size: 24px; margin: 0 auto 20px;">
                <i class="fa-solid fa-desktop"></i>
            </div>
            <h3 style="color: #ffffff; margin: 0 0 10px; font-size: 20px; font-weight: 700;">Akses via Web Browser</h3>
            <p style="color: rgba(255,255,255,0.8); font-size: 13.5px; line-height: 1.6; margin: 0 0 25px;">
                Jika Anda menggunakan komputer/laptop atau ingin mengakses direktori langsung melalui browser web, silakan masuk ke portal web anggota.
            </p>

            <?php if (is_user_logged_in()) : ?>
                <div style="background: rgba(46,125,50,0.15); border: 1px solid rgba(46,125,50,0.3); border-radius: 8px; padding: 12px; margin-bottom: 20px; font-size: 13.5px; color: #a5d6a7;">
                    <i class="fa-solid fa-circle-check" style="margin-right: 4px;"></i> Anda saat ini sudah masuk (logged in).
                </div>
                <a href="<?php echo esc_url(home_url('/bisnis-member/')); ?>" class="pbi-btn pbi-btn--accent" style="display: block; text-decoration: none; padding: 12px; font-size: 14.5px; font-weight: 700; border-radius: 8px; margin-bottom: 12px;">
                    <i class="fa-solid fa-network-wired"></i> Buka Direktori UMKM
                </a>
                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" style="color: rgba(255,255,255,0.6); font-size: 12.5px; text-decoration: underline;">
                    Keluar Akun
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url(wp_login_url(home_url('/bisnis-member/'))); ?>" class="pbi-btn pbi-btn--accent" style="display: block; text-decoration: none; padding: 12px; font-size: 14.5px; font-weight: 700; border-radius: 8px; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(212,175,55,0.2);">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk Web Member
                </a>
                <span style="font-size: 12.5px; color: rgba(255,255,255,0.5);">Gunakan username &amp; password anggota Anda.</span>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php
get_footer();
