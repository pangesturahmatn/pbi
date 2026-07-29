<?php
/**
 * Main Index Template (Fallback & Blog Feed)
 * Author: Pangestu Rahmat N (arumsaricorporation.co.id)
 */
defined('ABSPATH') || exit;

get_header();
?>

<div class="pbi-page-header" style="background: linear-gradient(135deg, var(--pbi-primary), var(--pbi-charcoal)); padding: 60px 0; color: #fff; text-align: center; position: relative; overflow: hidden;">
    <div class="pbi-container" style="position: relative; z-index: 2;">
        <h1 class="pbi-page-header__title" style="color: #ffffff; margin: 0 0 10px 0; font-size: 36px; font-weight: 700;"><?php single_post_title(); ?></h1>
        <p class="pbi-page-header__desc" style="color: rgba(255,255,255,0.85); font-size: 16px; margin: 0;">Kabar, Berita Terbaru & Artikel Bermanfaat Dari PBI</p>
    </div>
    <div style="position: absolute; top: -50%; left: -20%; width: 60%; height: 200%; background: radial-gradient(circle, rgba(212,175,55,0.15) 0%, rgba(0,0,0,0) 70%); z-index: 1;"></div>
</div>

<div class="pbi-container pbi-content-area" style="padding: 60px 15px; max-width: 1200px; margin: 0 auto;">
    
    <!-- Responsive 2-Column Grid Layout -->
    <div class="pbi-blog-layout">
        
        <!-- Left: Blog Posts Area -->
        <div class="pbi-blog-main">
            <div class="pbi-blog-posts" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 28px;">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('pbi-blog-card'); ?> style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; overflow: hidden; display: flex; flex-direction: column; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                        
                        <!-- Featured Image / Placeholder Cover -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="pbi-blog-card__thumbnail" style="height: 200px; overflow: hidden; position: relative;">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large', array('style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;')); ?>
                                </a>
                            </div>
                        <?php else : ?>
                            <div class="pbi-blog-card__thumbnail" style="height: 200px; overflow: hidden; background: linear-gradient(135deg, var(--pbi-primary), var(--pbi-charcoal)); display: flex; align-items: center; justify-content: center; position: relative;">
                                <div style="position: absolute; width: 100%; height: 100%; background: radial-gradient(circle, rgba(212,175,55,0.18) 0%, transparent 70%);"></div>
                                <i class="fa-solid fa-file-invoice" style="font-size: 52px; color: rgba(255,255,255,0.25); z-index: 2;"></i>
                                <span style="position: absolute; bottom: 12px; right: 12px; font-size: 10px; color: rgba(255,255,255,0.5); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; z-index: 2;">PBI Kabar</span>
                            </div>
                        <?php endif; ?>

                        <!-- Card Body -->
                        <div class="pbi-blog-card__body" style="padding: 24px; display: flex; flex-direction: column; flex-grow: 1; gap: 12px;">
                            
                            <!-- Categories Badge -->
                            <div class="pbi-blog-card__categories" style="display: flex; gap: 6px; flex-wrap: wrap;">
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    foreach ($categories as $category) {
                                        echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" style="background: rgba(11, 70, 40, 0.08); color: var(--pbi-primary); font-size: 10px; font-weight: 700; text-transform: uppercase; padding: 4px 10px; border-radius: 12px; text-decoration: none; letter-spacing: 0.5px;">' . esc_html($category->name) . '</a>';
                                    }
                                }
                                ?>
                            </div>

                            <!-- Title (Upper) -->
                            <h3 class="pbi-blog-card__title" style="margin: 0; font-size: 19px; font-weight: 700; line-height: 1.45;">
                                <a href="<?php the_permalink(); ?>" style="color: #1e293b; text-decoration: none; transition: color 0.2s;"><?php the_title(); ?></a>
                            </h3>

                            <!-- Meta Info (Tanggal, Author, Comment Count - Lower) -->
                            <div class="pbi-blog-card__meta" style="display: flex; align-items: center; gap: 12px; font-size: 12.5px; color: #64748b; flex-wrap: wrap; margin-top: -4px;">
                                <span><i class="fa-regular fa-calendar-days" style="color: var(--pbi-accent); margin-right: 3px;"></i> <?php echo get_the_date(); ?></span>
                                <span><i class="fa-regular fa-user" style="color: var(--pbi-accent); margin-right: 3px;"></i> <?php echo get_the_author(); ?></span>
                            </div>

                            <!-- Excerpt -->
                            <p class="pbi-blog-card__excerpt" style="font-size: 14.5px; color: #64748b; line-height: 1.65; margin: 4px 0 0 0; flex-grow: 1;">
                                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                            </p>

                            <!-- Read More Link -->
                            <a href="<?php the_permalink(); ?>" class="pbi-blog-card__link" style="color: var(--pbi-primary); font-weight: 700; font-size: 14px; text-decoration: none; display: flex; align-items: center; gap: 6px; margin-top: 10px; transition: color 0.2s;">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right-long" style="transition: transform 0.2s;"></i>
                            </a>

                            <!-- Card Footer: Likes & Comments Bar -->
                            <div class="pbi-blog-card__footer" style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 14px; margin-top: 10px;">
                                <!-- LocalStorage Like button -->
                                <button class="pbi-like-btn" data-post-id="<?php the_ID(); ?>" style="background: none; border: none; color: #64748b; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; padding: 0; transition: color 0.2s; font-family: inherit;">
                                    <i class="fa-regular fa-heart"></i> <span class="pbi-like-count">0</span> Suka
                                </button>
                                
                                <a href="<?php the_permalink(); ?>#comments" style="color: #64748b; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                                    <i class="fa-regular fa-comments"></i> <?php echo get_comments_number(); ?> Komentar
                                </a>
                            </div>

                        </div>

                    </article>
                <?php endwhile; ?>
                <?php else : ?>
                    <p style="grid-column: 1/-1; text-align: center; padding: 50px 0; color: #64748b; font-size: 16px;"><?php esc_html_e('Maaf, tidak ada artikel berita ditemukan.', 'pbi-theme'); ?></p>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <div class="pbi-pagination" style="margin-top: 50px; text-align: center;">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
                    'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
                ));
                ?>
            </div>
        </div>

        <!-- Right: Modern Sidebar Area -->
        <aside class="pbi-blog-sidebar">
            
            <!-- Widget 1: Search Form -->
            <div class="pbi-sidebar-widget">
                <h4 class="pbi-widget-title">Cari Artikel</h4>
                <div style="margin-top: 10px;">
                    <?php get_search_form(); ?>
                </div>
            </div>

            <!-- Widget 2: Categories List -->
            <div class="pbi-sidebar-widget">
                <h4 class="pbi-widget-title">Kategori</h4>
                <ul class="pbi-widget-list">
                    <?php
                    $categories = get_categories();
                    if (!empty($categories)) :
                        foreach ($categories as $cat) : ?>
                            <li>
                                <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
                                <span><?php echo $cat->count; ?></span>
                            </li>
                        <?php endforeach;
                    else : ?>
                        <li style="color: #64748b; font-size: 14px;">Belum ada kategori.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Widget 3: Popular Tags -->
            <div class="pbi-sidebar-widget">
                <h4 class="pbi-widget-title">Tags Populer</h4>
                <div class="pbi-widget-tags">
                    <?php
                    $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 12));
                    if (!empty($tags)) :
                        foreach ($tags as $tag) : ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">#<?php echo esc_html($tag->name); ?></a>
                        <?php endforeach;
                    else : ?>
                        <span style="color: #64748b; font-size: 14px;">Belum ada tags.</span>
                    <?php endif; ?>
                </div>
            </div>

        </aside>

    </div>
</div>

<!-- Dynamic Layout Styles & Likes Handler -->
<style>
/* Blog Layout Grid 2 Columns */
.pbi-blog-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: 40px;
    align-items: start;
}
@media (min-width: 992px) {
    .pbi-blog-layout {
        grid-template-columns: 2.7fr 1fr;
    }
}

/* Card Hover effect */
.pbi-blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.06) !important;
    border-color: var(--pbi-primary) !important;
}
.pbi-blog-card:hover img {
    transform: scale(1.05);
}
.pbi-blog-card:hover .pbi-blog-card__link {
    color: var(--pbi-accent) !important;
}
.pbi-blog-card:hover .pbi-blog-card__link i {
    transform: translateX(4px);
}

/* Sidebar Widgets Styles */
.pbi-sidebar-widget {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 30px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}
.pbi-widget-title {
    margin: 0 0 15px 0;
    font-size: 16px;
    font-weight: 700;
    color: var(--pbi-primary);
    border-bottom: 2px solid var(--pbi-accent);
    padding-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.pbi-widget-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.pbi-widget-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
}
.pbi-widget-list li a {
    color: #334155;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}
.pbi-widget-list li a:hover {
    color: var(--pbi-primary);
}
.pbi-widget-list li span {
    background: #f1f5f9;
    color: #64748b;
    font-size: 11.5px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 20px;
}
.pbi-widget-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
}
.pbi-widget-tags a {
    background: #f8fafc;
    color: #475569;
    font-size: 12px;
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 20px;
    text-decoration: none;
    border: 1px solid #cbd5e1;
    transition: all 0.2s ease;
}
.pbi-widget-tags a:hover {
    background: var(--pbi-primary);
    color: #ffffff;
    border-color: var(--pbi-primary);
    transform: translateY(-1px);
}

/* Customizer Search Form Override style */
.pbi-sidebar-widget form {
    display: flex;
    gap: 8px;
}
.pbi-sidebar-widget form label {
    flex-grow: 1;
}
.pbi-sidebar-widget form input[type="search"] {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    outline: none;
}
.pbi-sidebar-widget form input[type="search"]:focus {
    border-color: var(--pbi-primary);
}
.pbi-sidebar-widget form input[type="submit"] {
    background: var(--pbi-primary);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 18px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
}
.pbi-sidebar-widget form input[type="submit"]:hover {
    background: var(--pbi-primary-hover);
}
</style>

<!-- JS for Interactive Mockup Likes -->
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.pbi-like-btn').forEach(function(btn) {
        var postId = btn.getAttribute('data-post-id');
        var countEl = btn.querySelector('.pbi-like-count');
        var iconEl = btn.querySelector('i');
        
        // Generate a stable initial like count based on post ID
        var seedLikes = (parseInt(postId) * 7) % 43 + 6; // Stable mockup seed
        var likes = localStorage.getItem('pbi_likes_' + postId) || seedLikes;
        
        // Load like state
        if (localStorage.getItem('pbi_liked_' + postId) === 'true') {
            iconEl.classList.remove('fa-regular');
            iconEl.classList.add('fa-solid');
            iconEl.style.color = '#f43f5e';
            btn.style.color = '#f43f5e';
        }
        countEl.textContent = likes;
        localStorage.setItem('pbi_likes_' + postId, likes);
        
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var liked = localStorage.getItem('pbi_liked_' + postId) === 'true';
            var currentLikes = parseInt(likes);
            if (liked) {
                // Unlike
                localStorage.setItem('pbi_liked_' + postId, 'false');
                currentLikes--;
                iconEl.classList.remove('fa-solid');
                iconEl.classList.add('fa-regular');
                iconEl.style.color = '';
                btn.style.color = '';
            } else {
                // Like
                localStorage.setItem('pbi_liked_' + postId, 'true');
                currentLikes++;
                iconEl.classList.remove('fa-regular');
                iconEl.classList.add('fa-solid');
                iconEl.style.color = '#f43f5e';
                btn.style.color = '#f43f5e';
            }
            likes = currentLikes;
            localStorage.setItem('pbi_likes_' + postId, likes);
            countEl.textContent = likes;
        });
    });
});
</script>

<?php
get_footer();
