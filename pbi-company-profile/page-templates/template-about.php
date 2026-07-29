<?php
/**
 * Template Name: PBI Tentang PBI (Tentang Kami)
 * Description: Template khusus untuk halaman profil Tentang PBI dengan pemutar video lama dan seksi kustom script.
 * Author: Pangestu Rahmat N (arumsaricorporation.co.id)
 */

defined('ABSPATH') || exit;

get_header();

// Fetch settings from Customizer
$about_video  = get_theme_mod('pbi_about_video', '<iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>');
$founder_name = get_theme_mod('pbi_about_founder_name', 'Ust. Arif Abu Syamil');
$board_name   = get_theme_mod('pbi_about_board_name', 'Bpk. Arif Hastono');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <!-- Page Title Banner -->
    <div class="pbi-page-header" style="background: linear-gradient(135deg, var(--pbi-primary), var(--pbi-charcoal)); padding: 60px 0; color: #fff; text-align: center; position: relative; overflow: hidden;">
        <div class="pbi-container" style="position: relative; z-index: 2;">
            <h1 class="pbi-page-header__title" style="margin: 0; font-size: 36px; font-weight: 700; color: #ffffff; letter-spacing: -0.5px;"><?php the_title(); ?></h1>
            <p style="margin: 10px 0 0 0; color: rgba(255,255,255,0.8); font-size: 16px;">Mengenal visi, misi, dan perjalanan perjuangan dakwah ekonomi umat PBI</p>
        </div>
        <div style="position: absolute; top: -50%; left: -20%; width: 60%; height: 200%; background: radial-gradient(circle, rgba(212,175,55,0.15) 0%, rgba(0,0,0,0) 70%); z-index: 1;"></div>
    </div>

    <!-- Page Content Body -->
    <div class="pbi-container" style="padding: 60px 15px; max-width: 900px; margin: 0 auto;">
        
        <!-- Main WYSIWYG Content from WordPress Editor -->
        <div class="pbi-entry-content" style="font-size: 17px; line-height: 1.8; color: var(--pbi-charcoal); margin-bottom: 40px;">
            <?php 
            while (have_posts()) : the_post();
                the_content();
            endwhile; 
            ?>
        </div>

        <!-- Section: Visi & Misi -->
        <div class="pbi-about-visi-misi" style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 50px;">
            <div style="background: #ffffff; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <h3 style="color: var(--pbi-primary); font-size: 22px; margin-bottom: 15px; display: flex; align-items: center; gap: 10px; margin-top: 0;">
                    <i class="fa-solid fa-eye" style="color: var(--pbi-accent);"></i> Visi Kami
                </h3>
                <p style="font-size: 15.5px; line-height: 1.7; color: #475569; margin: 0;">
                    "Mewujudkan 1 Juta Pengusaha Muslim Tangguh, Mulia, dan Gemar Berbagi yang menjadi pilar utama kebangkitan ekonomi umat secara nasional."
                </p>
            </div>
            
            <div style="background: #ffffff; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                <h3 style="color: var(--pbi-primary); font-size: 22px; margin-bottom: 15px; display: flex; align-items: center; gap: 10px; margin-top: 0;">
                    <i class="fa-solid fa-bullseye" style="color: var(--pbi-accent);"></i> Misi Kami
                </h3>
                <ul style="padding-left: 20px; font-size: 14.5px; color: #475569; display: flex; flex-direction: column; gap: 10px; margin: 0;">
                    <li>Menyelenggarakan pelatihan spiritualpreneurship terapan secara profesional dan gratis bagi umat.</li>
                    <li>Membina mental spiritual pengusaha Muslim agar berorientasi pada keberkahan hidup dunia dan akhirat.</li>
                    <li>Menggerakkan kepedulian sosial melalui ziswaf produktif guna menopang pemberdayaan ekonomi lemah.</li>
                </ul>
            </div>
        </div>
        
        <style>
        @media (max-width: 768px) {
            .pbi-about-visi-misi {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }
        }
        </style>

        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 50px 0;">

        <!-- Video Showcase Section (Video Lama/Baru) -->
        <div class="pbi-video-section" style="margin-top: 40px; text-align: center;">
            <div style="margin-bottom: 25px;">
                <span style="font-size: 13px; font-weight: 700; color: var(--pbi-accent); text-transform: uppercase; letter-spacing: 1.5px; display: inline-block; margin-bottom: 8px;">Dokumentasi Perjalanan</span>
                <h2 style="font-size: 28px; font-weight: 700; color: var(--pbi-primary); margin: 0;">Video Profil & Perjalanan PBI</h2>
                <p style="color: #64748b; margin-top: 5px; font-size: 15px;">Tonton cuplikan dokumentasi sejarah perjuangan dakwah ekonomi Pesantren Bisnis Indonesia</p>
            </div>

            <!-- Responsive Video Wrapper -->
            <div class="pbi-video-container" style="max-width: 800px; margin: 0 auto;">
                <div class="pbi-video-wrapper">
                    <?php 
                    // Helper to resolve simple YouTube URLs into embeds
                    if (!function_exists('pbi_get_youtube_embed')) {
                        function pbi_get_youtube_embed($url_or_iframe) {
                            if (empty($url_or_iframe)) return '';
                            if (strpos($url_or_iframe, '<iframe') !== false) {
                                return $url_or_iframe;
                            }
                            $url = trim($url_or_iframe);
                            $video_id = '';
                            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
                                $video_id = $match[1];
                            }
                            if (!empty($video_id)) {
                                return '<iframe src="https://www.youtube.com/embed/' . esc_attr($video_id) . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
                            }
                            if (filter_var($url, FILTER_VALIDATE_URL)) {
                                return '<video src="' . esc_url($url) . '" controls style="width:100%; max-height:450px; border-radius:12px;"></video>';
                            }
                            return $url_or_iframe;
                        }
                    }

                    // Output embed code
                    if (!empty($about_video)) {
                        echo pbi_get_youtube_embed($about_video);
                    } else {
                        echo '<p style="padding: 40px; background: #f1f5f9; border-radius: 8px; color: #64748b;">Belum ada video yang disematkan.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 50px 0;">

        <!-- Section: Pendiri & Pengurus Inti -->
        <div class="pbi-about-founders" style="margin-top: 40px;">
            <div style="text-align: center; margin-bottom: 40px;">
                <span style="font-size: 13px; font-weight: 700; color: var(--pbi-accent); text-transform: uppercase; letter-spacing: 1.5px; display: inline-block; margin-bottom: 8px;">Tokoh & Pengurus</span>
                <h2 style="font-size: 28px; font-weight: 700; color: var(--pbi-primary); margin: 0;">Pendiri & Pengurus Inti</h2>
                <p style="color: #64748b; margin-top: 5px; font-size: 15px;">Para penggerak utama perjuangan dakwah ekonomi Pesantren Bisnis Indonesia</p>
            </div>
            
            <div class="pbi-grid-3">
                <!-- Founder Card -->
                <div class="pbi-card pbi-card--interactive" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; text-align: center; padding: 30px 20px; display: flex; flex-direction: column; align-items: center; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; margin-bottom: 20px; border: 4px solid rgba(212,175,55,0.2); background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-user-tie" style="font-size: 55px; color: #94a3b8;"></i>
                    </div>
                    <h3 style="margin: 0; font-size: 18px; color: var(--pbi-primary); line-height: 1.3;"><?php echo esc_html($founder_name); ?></h3>
                    <p style="font-size: 12px; font-weight: 700; color: var(--pbi-accent); margin: 6px 0 12px 0; text-transform: uppercase; letter-spacing: 0.5px;">Founder & Guru Utama PBI</p>
                    <p style="font-size: 13.5px; color: #64748b; line-height: 1.65; margin: 0;">Inisiator utama dan perintis gerakan pelatihan dakwah wirausaha Pesantren Bisnis Indonesia secara nasional.</p>
                </div>

                <!-- Pengurus Card 1 -->
                <div class="pbi-card pbi-card--interactive" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; text-align: center; padding: 30px 20px; display: flex; flex-direction: column; align-items: center; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; margin-bottom: 20px; border: 4px solid rgba(11,70,40,0.1); background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-user" style="font-size: 55px; color: #94a3b8;"></i>
                    </div>
                    <h3 style="margin: 0; font-size: 18px; color: var(--pbi-primary); line-height: 1.3;"><?php echo esc_html($board_name); ?></h3>
                    <p style="font-size: 12px; font-weight: 700; color: var(--pbi-accent); margin: 6px 0 12px 0; text-transform: uppercase; letter-spacing: 0.5px;">Pengurus Inti PBI</p>
                    <p style="font-size: 13.5px; color: #64748b; line-height: 1.65; margin: 0;">Mengelola kegiatan operasional harian, koordinasi daerah, dan pelaksanaan program-program dakwah PBI pusat.</p>
                </div>

                <!-- Pengurus Card 2 -->
                <div class="pbi-card pbi-card--interactive" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; text-align: center; padding: 30px 20px; display: flex; flex-direction: column; align-items: center; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; margin-bottom: 20px; border: 4px solid rgba(11,70,40,0.1); background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-user-group" style="font-size: 45px; color: #94a3b8;"></i>
                    </div>
                    <h3 style="margin: 0; font-size: 18px; color: var(--pbi-primary); line-height: 1.3;">Koordinator Wilayah</h3>
                    <p style="font-size: 12px; font-weight: 700; color: var(--pbi-accent); margin: 6px 0 12px 0; text-transform: uppercase; letter-spacing: 0.5px;">Pengurus Daerah</p>
                    <p style="font-size: 13.5px; color: #64748b; line-height: 1.65; margin: 0;">Mengawal jejaring sinergi alumni daerah, kajian wirausaha rutin, serta program UMKM binaan di tingkat regional.</p>
                </div>
            </div>
        </div>

    </div>

    <!-- 
         ======================================================================
         [VERSI CODE - CUSTOM SCRIPT/HTML/CSS UNTUK TENTANG PBI]
         ======================================================================
         Seksi di bawah ini mencetak kode kustom (misal: tombol kustom, script kustom,
         form, CSS, atau HTML ekstra) yang Anda masukkan lewat Customizer.
    -->
    <div class="pbi-custom-code-area" style="width: 100%;">
        <?php 
        $custom_code = get_theme_mod('pbi_about_custom_code');
        if (!empty($custom_code)) {
            echo $custom_code; 
        }
        ?>
        
        <!-- TEMPAT PENGEDITAN FILE TEMPLATE LANGSUNG:
             Jika Anda lebih memilih menulis kode kustom (script/HTML) langsung 
             di file PHP ini daripada melalui Customizer, Anda dapat menyisipkannya 
             di bawah baris komentar ini:
        -->
        
        <!-- Tulis Kode / Script Kustom Anda di Sini (HTML, JS, CSS, dll) -->
        
    </div>

</article>

<!-- Styling khusus untuk Video Wrapper -->
<style>
.pbi-video-wrapper {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
    height: 0;
    overflow: hidden;
    border-radius: 14px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    border: 4px solid #ffffff;
    background: #000000;
}
.pbi-video-wrapper iframe,
.pbi-video-wrapper object,
.pbi-video-wrapper embed,
.pbi-video-wrapper video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}
</style>

<?php
get_footer();
