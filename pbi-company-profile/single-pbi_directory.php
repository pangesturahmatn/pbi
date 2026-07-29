<?php
/**
 * Single Template for Business Directory Item (pbi_directory)
 * Author: Official PBI (pesantrenbisnisindonesia.org)
 */
defined('ABSPATH') || exit;

get_header();

// Fetch specific meta details
$business_owner   = get_post_meta(get_the_ID(), '_pbi_business_owner', true);
$business_address = get_post_meta(get_the_ID(), '_pbi_business_address', true);
$business_wa      = get_post_meta(get_the_ID(), '_pbi_business_wa', true);
$business_email   = get_post_meta(get_the_ID(), '_pbi_business_email', true);
$business_web     = get_post_meta(get_the_ID(), '_pbi_business_website', true);
?>

<?php while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <!-- Page Title Banner -->
        <div class="pbi-page-header" style="background: linear-gradient(135deg, var(--pbi-primary), var(--pbi-charcoal)); padding: 80px 0; color: #ffffff; text-align: center; position: relative;">
            <div class="pbi-container" style="max-width: 800px; position: relative; z-index: 2;">
                <!-- Category badge -->
                <?php
                $terms = get_the_terms(get_the_ID(), 'business_cat');
                if (!empty($terms) && !is_wp_error($terms)) :
                    $term = array_shift($terms);
                ?>
                    <span style="background: var(--pbi-accent); color: #fff; padding: 4px 12px; font-size: 11px; font-weight: 700; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; margin-bottom: 15px;">
                        <?php echo esc_html($term->name); ?>
                    </span>
                <?php endif; ?>

                <h1 class="pbi-page-header__title" style="margin: 0; font-size: 38px; font-weight: 700; color: #ffffff; line-height: 1.3; text-shadow: 0 2px 10px rgba(0,0,0,0.1);"><?php the_title(); ?></h1>
            </div>
            <div style="position: absolute; top: -50%; left: -20%; width: 60%; height: 200%; background: radial-gradient(circle, rgba(212,175,55,0.12) 0%, rgba(0,0,0,0) 70%); z-index: 1;"></div>
        </div>

        <!-- Page Content Body -->
        <div class="pbi-container" style="padding: 60px 15px; max-width: 1100px; margin: 0 auto;">
            
            <div class="pbi-directory-content-grid" style="display: grid; grid-template-columns: 2.2fr 1fr; gap: 40px; align-items: start;">
                
                <!-- Main Content Column -->
                <div class="pbi-directory-main-content">
                    <?php if (has_post_thumbnail()) : ?>
                        <div style="margin-bottom: 40px; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 24px rgba(0,0,0,0.03);">
                            <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: auto; display: block;')); ?>
                        </div>
                    <?php endif; ?>

                    <div class="pbi-entry-content" style="font-size: 16.5px; line-height: 1.8; color: var(--pbi-charcoal);">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Sidebar Box -->
                <aside class="pbi-directory-sidebar" style="position: sticky; top: 100px;">
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; box-shadow: 0 8px 25px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 20px;">
                        
                        <h3 style="margin-top: 0; margin-bottom: 5px; font-size: 18px; font-weight: 700; color: #1e293b; border-bottom: 2px solid var(--pbi-accent); padding-bottom: 8px;">Informasi Vendor</h3>
                        
                        <?php if ($business_owner) : ?>
                            <div>
                                <span style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: 600; display: block; letter-spacing: 0.5px;">Pemilik Usaha</span>
                                <strong style="font-size: 15px; color: #334155;"><i class="fa-solid fa-user-tie" style="color: var(--pbi-primary); margin-right: 5px;"></i> <?php echo esc_html($business_owner); ?></strong>
                            </div>
                        <?php endif; ?>

                        <?php if ($business_address) : ?>
                            <div>
                                <span style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: 600; display: block; letter-spacing: 0.5px;">Alamat Usaha</span>
                                <span style="font-size: 14.5px; color: #475569; display: block; line-height: 1.5; margin-top: 2px;"><i class="fa-solid fa-location-dot" style="color: var(--pbi-accent); margin-right: 5px;"></i> <?php echo esc_html($business_address); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($business_email) : ?>
                            <div>
                                <span style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: 600; display: block; letter-spacing: 0.5px;">Email Usaha</span>
                                <a href="mailto:<?php echo esc_attr($business_email); ?>" style="font-size: 14.5px; color: var(--pbi-primary); text-decoration: none; font-weight: 600;"><i class="fa-solid fa-envelope" style="margin-right: 5px;"></i> <?php echo esc_html($business_email); ?></a>
                            </div>
                        <?php endif; ?>

                        <?php if ($business_web) : ?>
                            <div>
                                <span style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: 600; display: block; letter-spacing: 0.5px;">Website Resmi</span>
                                <a href="<?php echo esc_url($business_web); ?>" target="_blank" rel="noopener" style="font-size: 14.5px; color: var(--pbi-primary); text-decoration: none; font-weight: 600;"><i class="fa-solid fa-globe" style="margin-right: 5px;"></i> Kunjungi Website</a>
                            </div>
                        <?php endif; ?>

                        <?php if ($business_wa) : ?>
                            <div style="margin-top: 10px;">
                                <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $business_wa)); ?>?text=<?php echo rawurlencode('Assalamualaikum wr. wb., saya ingin bertanya mengenai produk/jasa dari Usaha Anda di Direktori UMKM PBI: ' . get_the_title()); ?>" target="_blank" rel="noopener" style="background: #25d366; color: #fff; text-align: center; text-decoration: none; padding: 12px 20px; border-radius: 30px; font-weight: 700; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 15px rgba(37,211,102,0.25); transition: all 0.3s ease;">
                                    <i class="fa-brands fa-whatsapp" style="font-size: 18px;"></i> Hubungi via WhatsApp
                                </a>
                            </div>
                        <?php endif; ?>

                        <a href="<?php echo esc_url(get_post_type_archive_link('pbi_directory')); ?>" style="color: var(--pbi-primary); font-weight: 600; font-size: 13px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: 10px; border-top: 1px solid #f1f5f9; padding-top: 15px;">
                            <i class="fa-solid fa-arrow-left-long"></i> Kembali ke Direktori
                        </a>
                    </div>
                </aside>

            </div>

        </div>

    </article>
<?php endwhile; ?>

<!-- Responsive support -->
<style>
@media (max-width: 768px) {
    .pbi-directory-content-grid {
        grid-template-columns: 1fr !important;
        gap: 30px !important;
    }
    .pbi-directory-sidebar {
        position: static !important;
    }
}
</style>

<?php
get_footer();
