<?php
/**
 * Single Template for Program Detail (pbi_program)
 * Author: Official PBI (pesantrenbisnisindonesia.org)
 */
defined('ABSPATH') || exit;

get_header();

$whatsapp = get_theme_mod('pbi_social_whatsapp', '6281334537381');
?>

<?php while (have_posts()) : the_post(); 
    $date      = get_post_meta(get_the_ID(), '_pbi_program_date', true);
    $time      = get_post_meta(get_the_ID(), '_pbi_program_time', true);
    $location  = get_post_meta(get_the_ID(), '_pbi_program_location', true);
    $wa_panitia = get_post_meta(get_the_ID(), '_pbi_program_wa', true);
    $countdown = get_post_meta(get_the_ID(), '_pbi_program_countdown_target', true);

    if (empty($wa_panitia)) {
        $wa_panitia = $whatsapp;
    }
?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
        <!-- Page Title Banner -->
        <div class="pbi-page-header" style="background: linear-gradient(135deg, var(--pbi-primary), var(--pbi-charcoal)); padding: 130px 0 80px; color: #ffffff; text-align: center; position: relative;">
            <div class="pbi-container" style="max-width: 800px; position: relative; z-index: 2;">
                <!-- Category badge -->
                <?php
                $terms = get_the_terms(get_the_ID(), 'program_cat');
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
            
            <div class="pbi-program-content-grid" style="display: grid; grid-template-columns: 2.2fr 1fr; gap: 40px; align-items: start;">
                
                <!-- Main Content Column -->
                <div class="pbi-program-main-content">
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
                <aside class="pbi-program-sidebar" style="position: sticky; top: 100px;">
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; box-shadow: 0 8px 25px rgba(0,0,0,0.02); display: flex; flex-direction: column; gap: 20px;">
                        
                        <!-- Event Meta Details Card -->
                        <div>
                            <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 17px; font-weight: 700; color: #1e293b; border-bottom: 2px solid var(--pbi-accent); padding-bottom: 8px;"><i class="fa-regular fa-calendar-check" style="color: var(--pbi-primary); margin-right: 8px;"></i>Detail Pelaksanaan</h3>
                            
                            <?php if ($date) : ?>
                                <div style="margin-bottom: 12px; display: flex; gap: 10px; align-items: flex-start;">
                                    <i class="fa-solid fa-calendar-day" style="color: var(--pbi-accent); font-size: 15px; margin-top: 3px; width: 16px; text-align: center;"></i>
                                    <div>
                                        <span style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: 600; display: block;">Tanggal</span>
                                        <span style="font-size: 14.5px; color: #475569; font-weight: 500;"><?php echo esc_html($date); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($time) : ?>
                                <div style="margin-bottom: 12px; display: flex; gap: 10px; align-items: flex-start;">
                                    <i class="fa-regular fa-clock" style="color: var(--pbi-accent); font-size: 15px; margin-top: 3px; width: 16px; text-align: center;"></i>
                                    <div>
                                        <span style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: 600; display: block;">Waktu</span>
                                        <span style="font-size: 14.5px; color: #475569; font-weight: 500;"><?php echo esc_html($time); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($location) : ?>
                                <div style="margin-bottom: 12px; display: flex; gap: 10px; align-items: flex-start;">
                                    <i class="fa-solid fa-map-location-dot" style="color: var(--pbi-accent); font-size: 15px; margin-top: 3px; width: 16px; text-align: center;"></i>
                                    <div>
                                        <span style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: 600; display: block;">Lokasi / Tempat</span>
                                        <span style="font-size: 14.5px; color: #475569; font-weight: 500;"><?php echo esc_html($location); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Dynamic Countdown Box (Show only if countdown date is populated) -->
                        <?php if (!empty($countdown)) : ?>
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; text-align: center;">
                                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; display: block; margin-bottom: 12px;"><i class="fa-solid fa-hourglass-start" style="color: var(--pbi-primary); margin-right: 5px;"></i> Hitung Mundur Acara</span>
                                <div class="pbi-countdown" data-countdown-date="<?php echo esc_attr($countdown); ?>" style="align-items: center; text-align: center; display: flex; flex-direction: column; gap: 0;">
                                    <div class="pbi-countdown__timer" style="display: flex; gap: 8px; justify-content: center; width: 100%;">
                                        <div class="pbi-countdown-box" style="background: var(--pbi-primary); min-width: 50px; padding: 8px 6px;">
                                            <span class="pbi-countdown-box__num" id="pbi-cd-days" style="font-size: 18px; color: #fff;">00</span>
                                            <span class="pbi-countdown-box__label" style="font-size: 8px; opacity: 0.8; color: #fff;">Hari</span>
                                        </div>
                                        <div class="pbi-countdown-box" style="background: var(--pbi-primary); min-width: 50px; padding: 8px 6px;">
                                            <span class="pbi-countdown-box__num" id="pbi-cd-hours" style="font-size: 18px; color: #fff;">00</span>
                                            <span class="pbi-countdown-box__label" style="font-size: 8px; opacity: 0.8; color: #fff;">Jam</span>
                                        </div>
                                        <div class="pbi-countdown-box" style="background: var(--pbi-primary); min-width: 50px; padding: 8px 6px;">
                                            <span class="pbi-countdown-box__num" id="pbi-cd-mins" style="font-size: 18px; color: #fff;">00</span>
                                            <span class="pbi-countdown-box__label" style="font-size: 8px; opacity: 0.8; color: #fff;">Menit</span>
                                        </div>
                                        <div class="pbi-countdown-box" style="background: var(--pbi-primary); min-width: 50px; padding: 8px 6px;">
                                            <span class="pbi-countdown-box__num" id="pbi-cd-secs" style="font-size: 18px; color: #fff;">00</span>
                                            <span class="pbi-countdown-box__label" style="font-size: 8px; opacity: 0.8; color: #fff;">Detik</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Dynamic Registration Button -->
                        <div>
                            <?php 
                            $p_status  = get_post_meta(get_the_ID(), '_pbi_program_status', true);
                            $p_reg_url = get_post_meta(get_the_ID(), '_pbi_program_reg_url', true);
                            
                            if ($p_status === 'tutup') : ?>
                                <button disabled style="background: #cbd5e1; color: #94a3b8; text-align: center; border: none; padding: 12px 20px; border-radius: 30px; font-weight: 700; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; cursor: not-allowed;">
                                    <i class="fa-solid fa-lock"></i> Pendaftaran Ditutup
                                </button>
                            <?php elseif (!empty($p_reg_url)) : ?>
                                <a href="<?php echo esc_url($p_reg_url); ?>" target="_blank" rel="noopener" style="background: var(--pbi-accent); color: #fff; text-align: center; text-decoration: none; padding: 12px 20px; border-radius: 30px; font-weight: 700; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 15px rgba(212,175,55,0.25); transition: all 0.3s ease; width: 100%;">
                                    <i class="fa-solid fa-graduation-cap" style="font-size: 16px;"></i> Daftar Sekarang (Online)
                                </a>
                            <?php else : ?>
                                <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa_panitia)); ?>?text=<?php echo rawurlencode('Assalamualaikum Admin PBI, saya berminat mendaftar Program: ' . get_the_title()); ?>" target="_blank" rel="noopener" style="background: #25d366; color: #fff; text-align: center; text-decoration: none; padding: 12px 20px; border-radius: 30px; font-weight: 700; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 15px rgba(37,211,102,0.25); transition: all 0.3s ease; width: 100%;">
                                    <i class="fa-brands fa-whatsapp" style="font-size: 18px;"></i> Daftar via WhatsApp
                                </a>
                            <?php endif; ?>
                        </div>

                        <a href="<?php echo esc_url(get_post_type_archive_link('pbi_program')); ?>" style="color: var(--pbi-primary); font-weight: 600; font-size: 13px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: 10px; border-top: 1px solid #f1f5f9; padding-top: 15px;">
                            <i class="fa-solid fa-arrow-left-long"></i> Lihat Semua Program
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
    .pbi-program-content-grid {
        grid-template-columns: 1fr !important;
        gap: 30px !important;
    }
    .pbi-program-sidebar {
        position: static !important;
    }
}
</style>

<?php
get_footer();
