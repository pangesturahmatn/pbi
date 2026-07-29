<?php
/**
 * Footer Template for PBI Theme
 * Author: Pangestu Rahmat N (arumsaricorporation.co.id)
 */
defined('ABSPATH') || exit;
?>
    </main> <!-- #pbi-content-main -->

    <!-- Footer Section -->
    <footer id="pbi-colophon" class="pbi-footer">
        <div class="pbi-container pbi-footer__grid">
            
            <!-- Column 1: Tentang PBI (Menggunakan Customizer) -->
            <div class="pbi-footer__col">
                <!-- Footer Logo -->
                <div class="pbi-footer__logo" style="margin-bottom: 20px;">
                    <?php
                    $footer_logo = get_template_directory_uri() . '/assets/images/logo.png';
                    echo '<a href="' . esc_url(home_url('/')) . '" class="pbi-footer__logo-link" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">';
                    echo '<img src="' . esc_url($footer_logo) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="pbi-footer__logo-img" style="max-height: 45px; background: #FFFFFF; padding: 4px; border-radius: 6px; width: auto; display: block;">';
                    echo '<span class="pbi-footer__site-title" style="font-family: var(--pbi-font-headings); font-weight: 700; font-size: 15px; color: #FFFFFF; line-height: 1.2;">Pesantren Bisnis<br><span style="color: var(--pbi-accent); font-size: 11px; font-weight:600;">Indonesia</span></span>';
                    echo '</a>';
                    ?>
                </div>
                <h4 class="pbi-footer-widget__title" style="margin-top: 10px;"><?php echo esc_html(get_theme_mod('pbi_footer_about_title', 'Tentang PBI')); ?></h4>
                <p><?php echo esc_html(get_theme_mod('pbi_footer_about_text', 'Pesantren Bisnis Indonesia (PBI) adalah wadah perjuangan dakwah ekonomi umat dalam melahirkan wirausahawan Muslim mandiri yang tangguh, mulia, dan gemar berbagi.')); ?></p>
            </div>

            <!-- Column 2: Navigasi Footer -->
            <div class="pbi-footer__col">
                <h4 class="pbi-footer-widget__title">Navigasi Footer</h4>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'pbi-footer__menu',
                    'fallback_cb'    => false,
                ));
                ?>
            </div>

            <!-- Column 3: Hubungi Kami -->
            <div class="pbi-footer__col">
                <h4 class="pbi-footer-widget__title">Hubungi Kami</h4>
                <ul class="pbi-footer__contact-info">
                    <li><i class="fa-solid fa-location-dot"></i> <?php echo esc_html(get_theme_mod('pbi_footer_address', 'Kantor Pusat PBI, Banjarnegara, Jawa Tengah, Indonesia')); ?></li>
                    <li><i class="fa-solid fa-envelope"></i> <?php echo esc_html(get_theme_mod('pbi_footer_email', 'admin@pesantrenbisnisindonesia.org')); ?></li>
                    <li><i class="fa-solid fa-phone"></i> <?php echo esc_html(get_theme_mod('pbi_footer_phone', '+62 813-3453-7381')); ?></li>
                </ul>
                <div class="pbi-footer__socials">
                    <?php 
                    $fb_url = get_theme_mod('pbi_social_facebook', 'https://facebook.com/pesantrenbisnisindonesia');
                    $ig_url = get_theme_mod('pbi_social_instagram', 'https://instagram.com/official.pbi');
                    $yt_url = get_theme_mod('pbi_social_youtube', 'https://youtube.com/pesantrenbisnisindonesia');
                    ?>
                    <?php if ($fb_url) : ?>
                        <a href="<?php echo esc_url($fb_url); ?>" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
                    <?php endif; ?>
                    <?php if ($ig_url) : ?>
                        <a href="<?php echo esc_url($ig_url); ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if ($yt_url) : ?>
                        <a href="<?php echo esc_url($yt_url); ?>" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <!-- Copyright & Credits Footer Bottom -->
        <div class="pbi-footer__bottom">
            <div class="pbi-container pbi-footer__bottom-wrapper">
                <p class="pbi-copyright">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Hak Cipta Dilindungi.</p>
                <p class="pbi-credits">Dibuat oleh <a href="https://pesantrenbisnisindonesia.org" target="_blank" rel="noopener">Official PBI</a></p>
            </div>
        </div>
    </footer>

</div> <!-- #pbi-page-wrapper -->

<!-- Floating WhatsApp Button -->
<?php
$wa_number = get_theme_mod('pbi_social_whatsapp', '6281334537381');
$wa_url = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $wa_number) . '?text=' . rawurlencode('Assalamualaikum PBI Admin, saya ingin bertanya tentang program pelatihan dan keanggotaan.');
?>
<a href="<?php echo esc_url($wa_url); ?>" class="pbi-float-wa" target="_blank" rel="noopener" aria-label="Hubungi kami di WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
</a>

<?php wp_footer(); ?>
</body>
</html>
