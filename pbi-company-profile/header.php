<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="pbi-page-wrapper" class="pbi-site">
    <!-- Header/Navigation Section -->
    <header id="pbi-masthead" class="pbi-header">
        <!-- Premium Top Utility Bar -->
        <div class="pbi-topbar" style="background-color: var(--pbi-charcoal); border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding: 8px 0; font-size: 12px; color: rgba(255, 255, 255, 0.75);">
            <div class="pbi-container" style="display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto; padding: 0 15px;">
                <div class="pbi-topbar__left" style="font-weight: 500; font-family: var(--pbi-font-headings);">
                    Pesantren Bisnis Indonesia (PBI)
                </div>
                <div class="pbi-topbar__right" style="display: flex; align-items: center; gap: 15px; font-family: var(--pbi-font-headings);">
                    <a href="<?php echo esc_url(home_url('/hubungi-kami/')); ?>" style="color: #ffffff; text-decoration: none; font-weight: 600; margin-right: 10px; transition: color 0.2s;">Laman Pendaftaran</a>
                    <span class="pbi-topbar__socials" style="display: flex; align-items: center; gap: 10px;">
                        <?php 
                        $fb_url = get_theme_mod('pbi_social_facebook', 'https://facebook.com/pesantrenbisnisindonesia');
                        $ig_url = get_theme_mod('pbi_social_instagram', 'https://instagram.com/official.pbi');
                        $yt_url = get_theme_mod('pbi_social_youtube', 'https://youtube.com/pesantrenbisnisindonesia');
                        ?>
                        <?php if ($fb_url) : ?>
                            <a href="<?php echo esc_url($fb_url); ?>" style="color: rgba(255, 255, 255, 0.7); text-decoration: none; transition: color 0.2s;" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
                        <?php endif; ?>
                        <?php if ($ig_url) : ?>
                            <a href="<?php echo esc_url($ig_url); ?>" style="color: rgba(255, 255, 255, 0.7); text-decoration: none; transition: color 0.2s;" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if ($yt_url) : ?>
                            <a href="<?php echo esc_url($yt_url); ?>" style="color: rgba(255, 255, 255, 0.7); text-decoration: none; transition: color 0.2s;" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="pbi-container pbi-header__wrapper">
            <!-- Brand Logo -->
            <div class="pbi-header__brand">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    $default_logo = get_template_directory_uri() . '/assets/images/logo.png';
                    echo '<a href="' . esc_url(home_url('/')) . '" class="pbi-header__logo-link" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">';
                    echo '<img src="' . esc_url($default_logo) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="pbi-header__logo-img" style="max-height: 50px; width: auto; display: block;">';
                    echo '<span class="pbi-header__site-title" style="font-family: var(--pbi-font-headings); font-weight: 700; font-size: 16px; color: var(--pbi-primary); line-height: 1.2; display: inline-block;">Pesantren Bisnis<br><span style="color: var(--pbi-accent); font-size: 12px; font-weight:600;">Indonesia</span></span>';
                    echo '</a>';
                }
                ?>
            </div>

            <!-- Navigation Links -->
            <nav id="pbi-site-nav" class="pbi-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'pbi-nav__menu',
                    'fallback_cb'    => false,
                ));
                ?>
                <!-- Quick Member CTA button -->
                <div class="pbi-nav__cta">
                    <?php echo do_shortcode('[pbi_login_btn]'); ?>
                </div>
            </nav>

            <!-- Mobile Hamburger Menu Toggle Button -->
            <button id="pbi-menu-toggle" class="pbi-menu-toggle" aria-label="<?php esc_attr_e('Buka Menu', 'pbi-theme'); ?>">
                <span class="pbi-menu-toggle__bar"></span>
                <span class="pbi-menu-toggle__bar"></span>
                <span class="pbi-menu-toggle__bar"></span>
            </button>
        </div>
    </header>

    <!-- Main Content Area Wrapper -->
    <main id="pbi-content-main" class="pbi-site-content">
