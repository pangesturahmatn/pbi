<?php
/**
 * Archive Template for Mentor PBI (pbi_mentor)
 * Author: Official PBI (pesantrenbisnisindonesia.org)
 */
defined('ABSPATH') || exit;

get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$mentor_args = array(
    'post_type'      => 'pbi_mentor',
    'posts_per_page' => 12,
    'paged'          => $paged,
    'orderby'        => 'title',
    'order'          => 'ASC'
);

$mentor_query = new WP_Query($mentor_args);
?>

<!-- === HERO BANNER === -->
<div class="pbi-mentor-hero" style="background: linear-gradient(135deg, var(--pbi-primary) 0%, #07301b 100%); padding: 130px 0 50px; color: #fff; text-align: center; position: relative; overflow: hidden;">
    <!-- Decorative bg shapes -->
    <div style="position: absolute; top: -80px; right: -80px; width: 350px; height: 350px; background: radial-gradient(circle, rgba(212,175,55,0.18) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    <div style="position: absolute; bottom: 0; left: -60px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(212,175,55,0.12) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="pbi-container" style="position: relative; z-index: 2; max-width: 820px; margin: 0 auto; padding: 0 15px;">
        <span style="background: var(--pbi-accent); color: #fff; padding: 5px 18px; font-size: 11px; font-weight: 700; border-radius: 20px; text-transform: uppercase; letter-spacing: 1.5px; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(212,175,55,0.3);">
            <i class="fa-solid fa-graduation-cap"></i> Dewan Mentor PBI
        </span>
        <h1 style="color: #ffffff; margin: 0 0 18px; font-size: 42px; font-weight: 800; line-height: 1.2; letter-spacing: -0.5px;">
            Para Pembicara &amp; <br><span style="color: var(--pbi-accent);">Pengisi Keilmuan PBI</span>
        </h1>
        <p style="margin: 0 auto 20px; color: rgba(255,255,255,0.85); font-size: 17px; line-height: 1.7; max-width: 640px;">
            Mengenal lebih dekat para guru, praktisi, dan pengusaha yang mendedikasikan ilmu serta waktunya untuk membimbing alumni Pesantren Bisnis Indonesia.
        </p>
    </div>
</div>

<!-- === MAIN CONTENT: MENTOR LIST === -->
<div class="pbi-container" style="padding: 60px 15px; max-width: 1150px; margin: 0 auto;">
    
    <?php if ($mentor_query->have_posts()) : ?>
        <!-- Mentor Grid -->
        <div class="pbi-mentor-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 30px;">
            <?php while ($mentor_query->have_posts()) : $mentor_query->the_post(); 
                $specialty = get_post_meta(get_the_ID(), '_pbi_mentor_specialty', true);
                $facebook  = get_post_meta(get_the_ID(), '_pbi_mentor_facebook', true);
                $instagram = get_post_meta(get_the_ID(), '_pbi_mentor_instagram', true);
                $linkedin  = get_post_meta(get_the_ID(), '_pbi_mentor_linkedin', true);
                $youtube   = get_post_meta(get_the_ID(), '_pbi_mentor_youtube', true);
                $image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') : get_template_directory_uri() . '/assets/images/default-avatar.png';
            ?>
                <div class="pbi-mentor-card" style="background: #ffffff; border: 1px solid #e8edf5; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.02); text-align: center;">
                    <!-- Mentor Avatar & Hover Zoom -->
                    <div class="pbi-mentor-card__img-wrapper" style="position: relative; padding-top: 100%; overflow: hidden; background: #f8fafc;">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" class="pbi-mentor-img" />
                    </div>

                    <!-- Card Body -->
                    <div style="padding: 24px 20px; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between;">
                        <div>
                            <!-- Specialty / Badge -->
                            <?php if (!empty($specialty)) : ?>
                                <span style="display: inline-block; background: rgba(7, 48, 27, 0.06); color: var(--pbi-primary); font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
                                    <?php echo esc_html($specialty); ?>
                                </span>
                            <?php endif; ?>

                            <!-- Name -->
                            <h3 style="margin: 0 0 10px; font-size: 18px; font-weight: 700; color: #1e293b; line-height: 1.3;">
                                <?php the_title(); ?>
                            </h3>

                            <!-- Short Bio -->
                            <div style="font-size: 13.5px; color: #64748b; line-height: 1.6; margin-bottom: 20px;">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <!-- Social Media Icon Links -->
                        <div style="display: flex; justify-content: center; gap: 12px; border-top: 1px solid #f1f5f9; padding-top: 16px; margin-top: auto;">
                            <?php if (!empty($facebook)) : ?>
                                <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener" aria-label="Facebook" style="width: 36px; height: 36px; border-radius: 50%; background: #3b5998; color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.2s;" class="pbi-mentor-social-btn">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($instagram)) : ?>
                                <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener" aria-label="Instagram" style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.2s;" class="pbi-mentor-social-btn">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($linkedin)) : ?>
                                <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener" aria-label="LinkedIn" style="width: 36px; height: 36px; border-radius: 50%; background: #0077b5; color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.2s;" class="pbi-mentor-social-btn">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($youtube)) : ?>
                                <a href="<?php echo esc_url($youtube); ?>" target="_blank" rel="noopener" aria-label="YouTube" style="width: 36px; height: 36px; border-radius: 50%; background: #ff0000; color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.2s;" class="pbi-mentor-social-btn">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (empty($facebook) && empty($instagram) && empty($linkedin) && empty($youtube)) : ?>
                                <span style="font-size: 12px; color: #94a3b8; font-style: italic;"><i class="fa-solid fa-link-slash"></i> Sosial media belum diset</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <!-- Custom styling for hover and animations -->
        <style>
            .pbi-mentor-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 12px 30px rgba(0,0,0,0.08) !important;
                border-color: rgba(7, 48, 27, 0.15) !important;
            }
            .pbi-mentor-card:hover .pbi-mentor-img {
                transform: scale(1.06);
            }
            .pbi-mentor-social-btn:hover {
                transform: translateY(-3px) scale(1.05);
                opacity: 0.9;
            }
        </style>

        <!-- Pagination -->
        <div class="pbi-pagination" style="margin-top: 50px; text-align: center;">
            <?php
            echo paginate_links(array(
                'total'     => $mentor_query->max_num_pages,
                'current'   => $paged,
                'format'    => '?paged=%#%',
                'prev_text' => '<i class="fa-solid fa-chevron-left"></i> Sebelumnya',
                'next_text' => 'Selanjutnya <i class="fa-solid fa-chevron-right"></i>',
            ));
            ?>
        </div>

    <?php else : ?>
        <div style="text-align: center; padding: 60px 20px; background: #f8fafc; border-radius: 16px; border: 1px dashed #cbd5e1; max-width: 600px; margin: 0 auto;">
            <i class="fa-solid fa-users" style="font-size: 48px; color: #94a3b8; margin-bottom: 15px;"></i>
            <h2 style="font-size: 20px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">Mentor Belum Tersedia</h2>
            <p style="color: #64748b; font-size: 14px; margin: 0;">Saat ini pengelola sedang memproses pengisian data mentor Pesantren Bisnis Indonesia.</p>
        </div>
    <?php endif; ?>

</div>

<?php
get_footer();
