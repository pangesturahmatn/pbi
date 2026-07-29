<?php
/**
 * Template Name: PBI Tentang PBI (Tentang Kami)
 * Description: Template khusus untuk halaman profil Tentang PBI dengan pemutar video lama dan seksi kustom script.
 * Author: Pangestu Rahmat N (arumsaricorporation.co.id)
 */

defined('ABSPATH') || exit;

get_header();

// Fetch settings from Customizer
$about_video = get_theme_mod('pbi_about_video', '<iframe width="560" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>');
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
        <div class="pbi-entry-content" style="font-size: 17px; line-height: 1.8; color: var(--pbi-charcoal); margin-bottom: 50px;">
            <?php 
            while (have_posts()) : the_post();
                the_content();
            endwhile; 
            ?>
        </div>

        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 40px 0;">

        <!-- Video Showcase Section (Video Lama) -->
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
                    // Output the embed code directly
                    if (!empty($about_video)) {
                        echo $about_video;
                    } else {
                        echo '<p style="padding: 40px; background: #f1f5f9; border-radius: 8px; color: #64748b;">Belum ada video yang disematkan.</p>';
                    }
                    ?>
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
