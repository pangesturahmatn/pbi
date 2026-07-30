<?php
/**
 * Template Name: PBI Homepage (Beranda Interaktif)
 * Description: Template khusus halaman utama Pesantren Bisnis Indonesia.
 * Author: Pangestu Rahmat N (arumsaricorporation.co.id)
 */

defined('ABSPATH') || exit;

get_header();

// Fetch customizer options
$hero_title    = get_theme_mod('pbi_hero_title', 'Membangun Pengusaha Tangguh, Mulia, & Gemar Berbagi');
$hero_subtitle = get_theme_mod('pbi_hero_subtitle', 'Lembaga pelatihan bisnis non-profit untuk melahirkan pengusaha Muslim yang mengutamakan keberkahan dunia dan akhirat.');
$hero_cta_text = get_theme_mod('pbi_hero_cta_text', 'Ikuti Pelatihan Gratis');
$hero_cta_url  = get_theme_mod('pbi_hero_cta_url', '#program-terdekat');

$stat_alumni  = get_theme_mod('pbi_stat_alumni_count', 55000);
$stat_events  = get_theme_mod('pbi_stat_event_count', 450);
$stat_regions = get_theme_mod('pbi_stat_region_count', 34);
?>

<!-- 1. HERO BANNER SECTION -->
<section class="pbi-hero" style="position: relative; overflow: hidden;">
    <div class="pbi-container pbi-hero__wrapper">
        <div class="pbi-hero__content" style="z-index: 2;">
            <h1 class="pbi-hero__title"><?php echo esc_html($hero_title); ?></h1>
            <p class="pbi-hero__subtitle"><?php echo esc_html($hero_subtitle); ?></p>
            <div class="pbi-hero__actions">
                <a href="<?php echo esc_url($hero_cta_url); ?>" class="pbi-btn pbi-btn--accent pbi-btn--large pbi-btn--pulse">
                    <i class="fa-solid fa-graduation-cap"></i> <?php echo esc_html($hero_cta_text); ?>
                </a>
                <a href="#pilar-pbi" class="pbi-btn pbi-btn--outline pbi-btn--large" style="margin-left: 15px;">
                    Pelajari Pilar Kami
                </a>
            </div>
        </div>
        
        <!-- Right Column: Hero Image or Video Embed -->
        <div class="pbi-hero__image-box" style="z-index: 2; position: relative; width: 100%;">
            <?php
            $hero_video_url = get_theme_mod('pbi_hero_video_url', 'https://youtu.be/6Hjynif85ds');
            $video_id = '';
            if (!empty($hero_video_url)) {
                if (preg_match('/embed\/([a-zA-Z0-9_-]+)/', $hero_video_url, $matches)) {
                    $video_id = $matches[1];
                } elseif (preg_match('/v=([a-zA-Z0-9_-]+)/', $hero_video_url, $matches)) {
                    $video_id = $matches[1];
                } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $hero_video_url, $matches)) {
                    $video_id = $matches[1];
                }
            }

            if (!empty($video_id)) : ?>
                <div class="pbi-hero__video-wrapper" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.3); border: 4px solid rgba(255,255,255,0.15);">
                    <iframe src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>?rel=0" title="Pesantren Bisnis Indonesia Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"></iframe>
                </div>
            <?php else : ?>
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero-illustration.png'); ?>" alt="PBI Hero Illustration" style="max-width: 100%; height: auto; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.25); border: 4px solid rgba(255,255,255,0.08); transition: transform 0.3s ease;">
            <?php endif; ?>
            <!-- Glow effect behind image -->
            <div style="position: absolute; top: 10%; left: 10%; width: 80%; height: 80%; background: radial-gradient(circle, rgba(212,175,55,0.2) 0%, transparent 70%); z-index: -1; pointer-events: none;"></div>
        </div>
        
        <!-- Decorative glowing sphere -->
        <div class="pbi-hero__glow"></div>
    </div>
</section>

<!-- Custom Styling for 2-Column Hero layout -->
<style>
.pbi-hero__wrapper {
    display: grid;
    grid-template-columns: 1fr;
    gap: 40px;
    align-items: center;
    padding-top: 60px;
    padding-bottom: 80px;
}
.pbi-hero__image-box {
    display: none;
    text-align: center;
}
.pbi-hero__image-box img:hover {
    transform: translateY(-5px);
}
@media (min-width: 992px) {
    .pbi-hero__wrapper {
        grid-template-columns: 1.2fr 1fr !important;
        text-align: left;
    }
    .pbi-hero__content {
        max-width: 100% !important;
        padding-right: 20px;
    }
    .pbi-hero__image-box {
        display: block !important;
    }
}
</style>

<!-- EXTRA: EVENT COUNTDOWN BAR -->
<div class="pbi-container">
    <div class="pbi-widget-bar" style="max-width: 600px; margin: -60px auto 40px auto; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);">
        <?php
        // Find next event date
        $next_event_date = '';
        $next_event_title = 'Pelatihan Terdekat PBI';
        
        $next_event_query = new WP_Query(array(
            'post_type'      => 'pbi_program',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'meta_key'       => '_pbi_program_date',
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
            'meta_query'     => array(
                array(
                    'key'     => '_pbi_program_date',
                    'value'   => date('Y-m-d'),
                    'compare' => '>=',
                    'type'    => 'DATE'
                )
            )
        ));

        if ($next_event_query->have_posts()) {
            while ($next_event_query->have_posts()) {
                $next_event_query->the_post();
                $next_event_date = get_post_meta(get_the_ID(), '_pbi_program_date', true);
                $next_event_title = get_the_title();
            }
            wp_reset_postdata();
        }

        // Check if we have an upcoming event
        $has_upcoming_event = !empty($next_event_date);
        ?>
        <?php if ($has_upcoming_event) : ?>
            <div class="pbi-countdown" data-countdown-date="<?php echo esc_attr($next_event_date); ?>" style="align-items: center; text-align: center; display: flex; flex-direction: column; gap: 15px;">
                <h4 class="pbi-countdown__title" style="font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--pbi-text-muted); margin: 0;">
                    <i class="fa-regular fa-hourglass-half"></i> <?php echo esc_html($next_event_title); ?>
                </h4>
                <div class="pbi-countdown__timer" style="display: flex; gap: 12px; justify-content: center;">
                    <div class="pbi-countdown-box">
                        <span class="pbi-countdown-box__num" id="pbi-cd-days">00</span>
                        <span class="pbi-countdown-box__label">Hari</span>
                    </div>
                    <div class="pbi-countdown-box">
                        <span class="pbi-countdown-box__num" id="pbi-cd-hours">00</span>
                        <span class="pbi-countdown-box__label">Jam</span>
                    </div>
                    <div class="pbi-countdown-box">
                        <span class="pbi-countdown-box__num" id="pbi-cd-mins">00</span>
                        <span class="pbi-countdown-box__label">Menit</span>
                    </div>
                    <div class="pbi-countdown-box">
                        <span class="pbi-countdown-box__num" id="pbi-cd-secs">00</span>
                        <span class="pbi-countdown-box__label">Detik</span>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <!-- Fallback Widget: Jadwal Baru Segera Hadir -->
            <div style="text-align: center; display: flex; flex-direction: column; align-items: center; gap: 10px; padding: 5px 15px;">
                <h4 style="font-size: 13.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--pbi-primary); margin: 0; display: inline-flex; align-items: center; gap: 6px;">
                    <span style="display: inline-block; width: 8px; height: 8px; background: #e2b808; border-radius: 50%; animation: pbi_cd_pulse 1.5s infinite;"></span>
                    Pendaftaran Batch Baru Segera Hadir
                </h4>
                <p style="font-size: 12.5px; color: #475569; margin: 0 0 5px; max-width: 480px; line-height: 1.5; font-weight: 500;">
                    Belum ada program pelatihan aktif terdekat yang dibuka saat ini. Ingin mendapat info jadwal terupdate saat batch baru resmi dibuka?
                </p>
                <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                    <a href="<?php echo esc_url(home_url('/program/')); ?>" class="pbi-btn pbi-btn--primary pbi-btn--small" style="font-size: 11px; font-weight: 700; padding: 8px 18px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; box-shadow: 0 4px 10px rgba(11,70,40,0.15);">
                        <i class="fa-solid fa-list-ul"></i> Lihat Program
                    </a>
                    <a href="<?php echo esc_url(home_url('/hubungi-kami/')); ?>" class="pbi-btn pbi-btn--outline pbi-btn--small" style="font-size: 11px; font-weight: 700; padding: 8px 18px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; text-decoration: none; border-color: #cbd5e1; color: #475569; display: inline-flex; align-items: center; gap: 4px; background: transparent;">
                        <i class="fa-regular fa-envelope"></i> Hubungi Kami
                    </a>
                </div>
            </div>
            
            <style>
            @keyframes pbi_cd_pulse {
                0% { transform: scale(0.95); opacity: 0.8; }
                50% { transform: scale(1.15); opacity: 1; }
                100% { transform: scale(0.95); opacity: 0.8; }
            }
            </style>
        <?php endif; ?>
    </div>
</div>

<!-- 2. PILAR & VISI-MISI SECTION -->
<section id="pilar-pbi" class="pbi-section pbi-section--light">
    <div class="pbi-container">
        <div class="pbi-section-header">
            <span class="pbi-badge">3 Pilar PBI</span>
            <h2>Fokus Utama Gerakan Perjuangan</h2>
            <p>Membangun kekuatan ekonomi umat melalui tiga pilar sinergis yang seimbang.</p>
        </div>

        <div class="pbi-grid-3">
            <!-- Pilar 1: Spiritual -->
            <div class="pbi-card pbi-card--interactive">
                <div class="pbi-card__icon pbi-card__icon--green">
                    <i class="fa-solid fa-mosque"></i>
                </div>
                <h3>Pilar Spiritual</h3>
                <p>Mendahulukan hubungan dengan Sang Pencipta dalam setiap ikhtiar bisnis, menegakkan nilai syariah, kejujuran, dan keluhuran budi pekerti.</p>
            </div>

            <!-- Pilar 2: Bisnis -->
            <div class="pbi-card pbi-card--interactive">
                <div class="pbi-card__icon pbi-card__icon--gold">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h3>Pilar Bisnis</h3>
                <p>Mengajarkan ilmu bisnis terapan, strategi scaling-up, efisiensi operasional, dan manajemen modern yang dipraktikkan secara riil.</p>
            </div>

            <!-- Pilar 3: Filantropi -->
            <div class="pbi-card pbi-card--interactive">
                <div class="pbi-card__icon pbi-card__icon--blue">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <h3>Pilar Filantropi</h3>
                <p>Menggerakkan kepedulian sosial melalui zakat, infak, sedekah, dan wakaf produktif (ziswaf) sebagai penyucian harta dan pemberdayaan dhuafa.</p>
            </div>
        </div>
    </div>
</section>

<!-- 3. STATISTICS COUNTER SECTION -->
<section class="pbi-stats">
    <div class="pbi-container pbi-stats__wrapper">
        <div class="pbi-stats__grid">
            
            <!-- Stat Item 1: Alumni -->
            <div class="pbi-stat-item">
                <span class="pbi-stat-item__number" data-target="<?php echo esc_attr($stat_alumni); ?>">0</span>
                <span class="pbi-stat-item__label">Alumni Terlatih (Nasional)</span>
            </div>

            <!-- Stat Item 2: Events -->
            <div class="pbi-stat-item">
                <span class="pbi-stat-item__number" data-target="<?php echo esc_attr($stat_events); ?>">0</span>
                <span class="pbi-stat-item__label">Pelatihan & Aksi Sosial</span>
            </div>

            <!-- Stat Item 3: Regions -->
            <div class="pbi-stat-item">
                <span class="pbi-stat-item__number" data-target="<?php echo esc_attr($stat_regions); ?>">0</span>
                <span class="pbi-stat-item__label">Provinsi Terjangkau</span>
            </div>

        </div>
    </div>
</section>

<!-- 4. PROGRAM TERDEKAT SECTION -->
<section id="program-terdekat" class="pbi-section">
    <div class="pbi-container">
        <div class="pbi-section-header">
            <span class="pbi-badge">Kegiatan Terdekat</span>
            <h2>Agenda & Pelatihan Terdekat</h2>
            <p>Ikuti pelatihan bisnis gratis dan kajian spiritual yang diselenggarakan secara berkala.</p>
        </div>

        <div class="pbi-grid-3">
            <?php
            $program_query = new WP_Query(array(
                'post_type'      => 'pbi_program',
                'posts_per_page' => 3,
                'post_status'    => 'publish'
            ));

            if ($program_query->have_posts()) : 
                while ($program_query->have_posts()) : $program_query->the_post();
                    // Get custom metadata
                    $p_date  = get_post_meta(get_the_ID(), '_pbi_program_date', true);
                    $p_loc   = get_post_meta(get_the_ID(), '_pbi_program_location', true);
                    $p_url   = get_post_meta(get_the_ID(), '_pbi_program_reg_url', true);
                    $p_status = get_post_meta(get_the_ID(), '_pbi_program_status', true);

                    $formatted_date = 'Segera Diumumkan';
                    if (!empty($p_date)) {
                        if (function_exists('pbi_format_indonesian_date')) {
                            $formatted_date = pbi_format_indonesian_date($p_date);
                        } else {
                            $formatted_date = $p_date;
                        }
                    }
                    $status_label = ($p_status === 'tutup') ? 'Pendaftaran Ditutup' : 'Daftar Sekarang';
                    $status_class = ($p_status === 'tutup') ? 'pbi-btn--disabled' : 'pbi-btn--accent';
                    $target_url = ($p_status === 'tutup') ? '#' : (!empty($p_url) ? $p_url : get_the_permalink());
            ?>
                    <div class="pbi-card pbi-card--program">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="pbi-card__media">
                                <?php the_post_thumbnail('medium_large'); ?>
                            </div>
                        <?php else : ?>
                            <div class="pbi-card__media" style="overflow: hidden; background: #FFFFFF;">
                                <?php 
                                $slug = get_post_field('post_name', get_the_ID());
                                if ($slug === 'quantum-spiritual-business') {
                                    $img_src = get_template_directory_uri() . '/assets/images/event-quantum.png';
                                    $padding = '0';
                                    $object_fit = 'contain';
                                } else {
                                    $img_src = get_template_directory_uri() . '/assets/images/logo.png';
                                    $padding = '30px';
                                    $object_fit = 'contain';
                                }
                                ?>
                                <img src="<?php echo esc_url($img_src); ?>" alt="<?php the_title_attribute(); ?>" style="width: 100%; height: 220px; object-fit: <?php echo $object_fit; ?>; display: block; padding: <?php echo $padding; ?>;">
                            </div>
                        <?php endif; ?>
                        
                        <div class="pbi-card__body">
                            <span class="pbi-card__meta-date"><i class="fa-regular fa-calendar-days"></i> <?php echo esc_html($formatted_date); ?></span>
                            <h3><?php the_title(); ?></h3>
                            <p class="pbi-card__location"><i class="fa-solid fa-map-location-dot"></i> <?php echo esc_html(!empty($p_loc) ? $p_loc : 'Online/TBA'); ?></p>
                            
                            <div class="pbi-card__actions" style="margin-top: 15px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px; width: 100%;">
                                <a href="<?php the_permalink(); ?>" class="pbi-btn--card-outline">
                                    <i class="fa-solid fa-circle-info" style="font-size: 11px;"></i> Info Acara
                                </a>
                                <?php if ($p_status === 'tutup') : ?>
                                    <span class="pbi-btn--card-disabled">
                                        Ditutup
                                    </span>
                                <?php else : ?>
                                    <a href="<?php echo esc_url(!empty($p_url) ? $p_url : get_the_permalink()); ?>" class="pbi-btn--card-accent">
                                        <i class="fa-solid fa-pen-to-square" style="font-size: 11px;"></i> Daftar
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
            <?php 
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <!-- Placeholder / Fallback cards if no programs are published yet -->
                <div class="pbi-card pbi-card--program">
                    <div class="pbi-card__body">
                        <span class="pbi-card__meta-date"><i class="fa-regular fa-calendar-days"></i> 10-12 September 2026</span>
                        <h3>PBI Business Bootcamp #1</h3>
                        <p class="pbi-card__location"><i class="fa-solid fa-map-location-dot"></i> Bandung, Jawa Barat</p>
                        <div class="pbi-card__actions" style="margin-top: 15px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px; width: 100%;">
                            <a href="#" class="pbi-btn--card-outline"><i class="fa-solid fa-circle-info" style="font-size: 11px;"></i> Info Acara</a>
                            <a href="#" class="pbi-btn--card-accent"><i class="fa-solid fa-pen-to-square" style="font-size: 11px;"></i> Daftar</a>
                        </div>
                    </div>
                </div>
                
                <div class="pbi-card pbi-card--program">
                    <div class="pbi-card__body">
                        <span class="pbi-card__meta-date"><i class="fa-regular fa-calendar-days"></i> 25 September 2026</span>
                        <h3>Kajian Pengusaha Rindu Syurga</h3>
                        <p class="pbi-card__location"><i class="fa-solid fa-map-location-dot"></i> Masjid Raya PBI, Bekasi</p>
                        <div class="pbi-card__actions" style="margin-top: 15px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px; width: 100%;">
                            <a href="#" class="pbi-btn--card-outline"><i class="fa-solid fa-circle-info" style="font-size: 11px;"></i> Info Acara</a>
                            <a href="#" class="pbi-btn--card-accent"><i class="fa-solid fa-pen-to-square" style="font-size: 11px;"></i> Daftar</a>
                        </div>
                    </div>
                </div>

                <div class="pbi-card pbi-card--program">
                    <div class="pbi-card__body">
                        <span class="pbi-card__meta-date"><i class="fa-regular fa-calendar-days"></i> Setiap Hari Ahad</span>
                        <h3>Majelis Ekonomi Umat</h3>
                        <p class="pbi-card__location"><i class="fa-solid fa-map-location-dot"></i> Aula PBI Tasikmalaya</p>
                        <div class="pbi-card__actions" style="margin-top: 15px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px; width: 100%;">
                            <a href="#" class="pbi-btn--card-outline"><i class="fa-solid fa-circle-info" style="font-size: 11px;"></i> Info Acara</a>
                            <a href="#" class="pbi-btn--card-accent"><i class="fa-solid fa-pen-to-square" style="font-size: 11px;"></i> Daftar</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- 5. TESTIMONIAL SECTION -->
<section class="pbi-section pbi-section--light">
    <div class="pbi-container">
        <div class="pbi-section-header">
            <span class="pbi-badge">Kisah Sukses</span>
            <h2>Apa Kata Alumni PBI?</h2>
            <p>Ratusan wirausahawan telah merasakan keberkahan bisnis setelah menyelaraskan usaha dengan nilai spiritual.</p>
        </div>

        <div class="pbi-grid-2">
            <!-- Testimonial 1 -->
            <div class="pbi-testimonial-card" style="background:#fff; padding:30px; border-radius:12px; border:1px solid var(--pbi-border); box-shadow:0 5px 15px rgba(0,0,0,0.02);">
                <p style="font-style:italic; color:var(--pbi-text-muted); line-height:1.6; font-size:15px; margin-bottom:20px;">"Sebelum bergabung dengan PBI, omset bisnis saya naik-turun dan selalu dikejar kecemasan. Setelah mengikuti pelatihan spiritual bisnis di PBI, saya belajar memprioritaskan shalat tepat waktu dan meluruskan niat. Alhamdulillah bisnis berjalan lebih berkah, karyawan sejahtera, dan hati menjadi tenang."</p>
                <div style="display:flex; align-items:center; gap:15px;">
                    <div style="width:50px; height:50px; border-radius:50%; background:#ccc; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; background: linear-gradient(135deg, var(--pbi-primary), var(--pbi-accent));">A</div>
                    <div>
                        <h4 style="margin:0; font-size:15px; font-weight:600;">H. Ahmad Subardjo</h4>
                        <span style="font-size:12px; color:var(--pbi-text-muted);">Alumni PBI Camp Tasikmalaya - Owner Subar Bakery</span>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="pbi-testimonial-card" style="background:#fff; padding:30px; border-radius:12px; border:1px solid var(--pbi-border); box-shadow:0 5px 15px rgba(0,0,0,0.02);">
                <p style="font-style:italic; color:var(--pbi-text-muted); line-height:1.6; font-size:15px; margin-bottom:20px;">"Alhamdulillah, melalui pilar filantropi PBI, kami diajarkan bahwa sejatinya harta yang kita miliki adalah apa yang kita sedekahkan. Dengan berkontribusi rutin, usaha saya di bidang garmen justru berkembang 3 kali lipat lebih cepat. Keberkahan berbagi itu nyata adanya!"</p>
                <div style="display:flex; align-items:center; gap:15px;">
                    <div style="width:50px; height:50px; border-radius:50%; background:#ccc; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; background: linear-gradient(135deg, var(--pbi-primary), var(--pbi-accent));">F</div>
                    <div>
                        <h4 style="margin:0; font-size:15px; font-weight:600;">Fatimah Azzahra</h4>
                        <span style="font-size:12px; color:var(--pbi-text-muted);">Alumni PBI Jabar - Founder Hijab Mulia</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 6. DYNAMIC DIRECTORY/UMKM PREVIEW SECTION -->
<section class="pbi-section">
    <div class="pbi-container">
        <div class="pbi-section-header">
            <span class="pbi-badge">Ekonomi Umat</span>
            <h2>Produk UMKM Member PBI</h2>
            <p>Dukung usaha lokal alumni PBI dengan berbelanja produk-produk halal berkualitas berikut.</p>
        </div>

        <div class="pbi-grid-3">
            <?php
            $directory_query = new WP_Query(array(
                'post_type'      => 'pbi_directory',
                'posts_per_page' => 3,
                'post_status'    => 'publish'
            ));

            if ($directory_query->have_posts()) :
                while ($directory_query->have_posts()) : $directory_query->the_post();
                    $biz_owner = get_post_meta(get_the_ID(), '_pbi_business_owner', true);
                    $biz_phone = get_post_meta(get_the_ID(), '_pbi_business_wa', true);
                    $biz_website = get_post_meta(get_the_ID(), '_pbi_business_website', true);
            ?>
                    <div class="pbi-card pbi-card--interactive" style="padding: 24px; display:flex; flex-direction:column; gap:12px;">
                        <?php if (has_post_thumbnail()) : ?>
                            <div style="height:140px; overflow:hidden; border-radius:8px; margin-bottom:10px;">
                                <?php the_post_thumbnail('medium', array('style'=>'width:100%; height:100%; object-fit:cover;')); ?>
                            </div>
                        <?php endif; ?>
                        <h3 style="margin:0; font-size:18px;"><?php the_title(); ?></h3>
                        <p style="font-size:13px; color:var(--pbi-text-muted); margin:0;">Pemilik: <strong><?php echo esc_html(!empty($biz_owner) ? $biz_owner : 'Alumni PBI'); ?></strong></p>
                        
                        <div style="margin-top:auto; display:flex; gap:10px;">
                            <?php if (!empty($biz_phone)) : ?>
                                <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $biz_phone)); ?>" class="pbi-btn pbi-btn--primary pbi-btn--small" target="_blank" style="flex-grow:1; text-align:center;">
                                    <i class="fa-brands fa-whatsapp"></i> Hubungi
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($biz_website)) : ?>
                                <a href="<?php echo esc_url($biz_website); ?>" class="pbi-btn pbi-btn--outline pbi-btn--small" target="_blank" style="flex-grow:1; text-align:center;">
                                    <i class="fa-solid fa-globe"></i> Website
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <!-- Placeholder / Fallback items if directory is empty -->
                <div class="pbi-card pbi-card--interactive" style="padding: 24px;">
                    <h3 style="margin:0 0 10px 0; font-size:18px;">Kripik Singkong Berkah</h3>
                    <p style="font-size:13px; color:var(--pbi-text-muted); margin-bottom:15px;">Pemilik: <strong>Ibu Nani</strong></p>
                    <a href="#" class="pbi-btn pbi-btn--primary pbi-btn--small pbi-btn--full" style="text-align:center;"><i class="fa-brands fa-whatsapp"></i> Hubungi UMKM (Demo)</a>
                </div>
                
                <div class="pbi-card pbi-card--interactive" style="padding: 24px;">
                    <h3 style="margin:0 0 10px 0; font-size:18px;">Madu Murni Al-Amin</h3>
                    <p style="font-size:13px; color:var(--pbi-text-muted); margin-bottom:15px;">Pemilik: <strong>Pak Fulan</strong></p>
                    <a href="#" class="pbi-btn pbi-btn--primary pbi-btn--small pbi-btn--full" style="text-align:center;"><i class="fa-brands fa-whatsapp"></i> Hubungi UMKM (Demo)</a>
                </div>

                <div class="pbi-card pbi-card--interactive" style="padding: 24px;">
                    <h3 style="margin:0 0 10px 0; font-size:18px;">Busana Muslim Syari</h3>
                    <p style="font-size:13px; color:var(--pbi-text-muted); margin-bottom:15px;">Pemilik: <strong>Teh Maryam</strong></p>
                    <a href="#" class="pbi-btn pbi-btn--primary pbi-btn--small pbi-btn--full" style="text-align:center;"><i class="fa-brands fa-whatsapp"></i> Hubungi UMKM (Demo)</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
get_footer();
