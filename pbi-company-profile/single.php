<?php
/**
 * Single Post Template (Membaca Artikel)
 * Author: Official PBI (pesantrenbisnisindonesia.org)
 */
defined('ABSPATH') || exit;

get_header();
?>

<?php while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <!-- Page Title Banner -->
        <div class="pbi-page-header" style="background: linear-gradient(135deg, var(--pbi-primary), var(--pbi-charcoal)); padding: 80px 0; color: #ffffff; text-align: center;">
            <div class="pbi-container" style="max-width: 800px;">
                <span class="pbi-post-meta" style="font-size: 14px; opacity: 0.8; display: block; margin-bottom: 12px; font-weight: 500;">
                    <i class="fa-regular fa-calendar"></i> <?php echo get_the_date(); ?> &nbsp;&bull;&nbsp; oleh <?php the_author(); ?>
                </span>
                <h1 class="pbi-page-header__title" style="margin: 0; font-size: 36px; font-weight: 700; color: #ffffff; line-height: 1.3; text-shadow: 0 2px 10px rgba(0,0,0,0.1);"><?php the_title(); ?></h1>
            </div>
        </div>

        <!-- Page Content Body -->
        <div class="pbi-container" style="padding: 60px 0; max-width: 800px;">
            <?php if (has_post_thumbnail()) : ?>
                <div class="pbi-post-featured-image" style="margin-bottom: 40px; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                    <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: auto; display: block;')); ?>
                </div>
            <?php endif; ?>

            <div class="pbi-entry-content" style="font-size: 17px; line-height: 1.8; color: var(--pbi-charcoal);">
                <?php the_content(); ?>
            </div>
            
            <!-- Back to Blog Link -->
            <div class="pbi-post-footer" style="margin-top: 50px; padding-top: 30px; border-top: 1px solid var(--pbi-border); display: flex; justify-content: space-between; align-items: center;">
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="pbi-btn pbi-btn--outline" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-weight: 600;">
                    <i class="fa-solid fa-arrow-left-long"></i> Kembali ke Blog
                </a>
            </div>
        </div>

    </article>
<?php endwhile; ?>

<?php
get_footer();
