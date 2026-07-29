<?php
/**
 * Default Page Template (Statis)
 * Author: Pangestu Rahmat N (arumsaricorporation.co.id)
 */
defined('ABSPATH') || exit;

get_header();
?>

<?php while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <!-- Page Title Banner -->
        <div class="pbi-page-header" style="background: linear-gradient(135deg, var(--pbi-primary), var(--pbi-charcoal)); padding: 60px 0; color: #fff; text-align: center;">
            <div class="pbi-container">
                <h1 class="pbi-page-header__title" style="margin: 0; font-size: 32px; font-weight: 700; color: #ffffff;"><?php the_title(); ?></h1>
            </div>
        </div>

        <!-- Page Content Body -->
        <div class="pbi-container" style="padding: 60px 0; max-width: 800px;">
            <div class="pbi-entry-content" style="font-size: 16px; line-height: 1.8; color: var(--pbi-charcoal);">
                <?php the_content(); ?>
            </div>
        </div>

    </article>
<?php endwhile; ?>

<?php
get_footer();
