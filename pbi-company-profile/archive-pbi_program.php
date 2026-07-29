<?php
/**
 * Archive Template for Program & Kegiatan (pbi_program)
 * Author: Official PBI (pesantrenbisnisindonesia.org)
 */
defined('ABSPATH') || exit;

get_header();

// Setup Query for Upcoming/Active Programs (excluding "Riwayat" category)
$riwayat_term = get_term_by('slug', 'riwayat', 'program_cat');
$riwayat_id = $riwayat_term ? $riwayat_term->term_id : 0;

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$upcoming_args = array(
    'post_type'      => 'pbi_program',
    'posts_per_page' => 6,
    'paged'          => $paged,
);
if ($riwayat_id) {
    $upcoming_args['tax_query'] = array(
        array(
            'taxonomy' => 'program_cat',
            'field'    => 'term_id',
            'terms'    => $riwayat_id,
            'operator' => 'NOT IN',
        ),
    );
}

$upcoming_query = new WP_Query($upcoming_args);
?>

<!-- === HERO BANNER === -->
<div class="pbi-prog-hero" style="background: linear-gradient(135deg, var(--pbi-primary) 0%, #07301b 100%); padding: 80px 0 0; color: #fff; text-align: center; position: relative; overflow: hidden;">
    <!-- Decorative bg shapes -->
    <div style="position: absolute; top: -80px; right: -80px; width: 350px; height: 350px; background: radial-gradient(circle, rgba(212,175,55,0.18) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    <div style="position: absolute; bottom: 0; left: -60px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(212,175,55,0.12) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="pbi-container" style="position: relative; z-index: 2; max-width: 820px; margin: 0 auto; padding: 0 15px;">
        <span style="background: var(--pbi-accent); color: #fff; padding: 5px 18px; font-size: 11px; font-weight: 700; border-radius: 20px; text-transform: uppercase; letter-spacing: 1.5px; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(212,175,55,0.3);">
            <i class="fa-solid fa-star"></i> Program Resmi PBI
        </span>
        <h1 style="color: #ffffff; margin: 0 0 18px; font-size: 42px; font-weight: 800; line-height: 1.2; letter-spacing: -0.5px;">
            Program &amp; Pelatihan<br><span style="color: var(--pbi-accent);">Bisnis Islami PBI</span>
        </h1>
        <p style="margin: 0 auto 40px; color: rgba(255,255,255,0.85); font-size: 17px; line-height: 1.7; max-width: 640px;">
            Ikuti berbagai program pelatihan bisnis untuk melahirkan generasi pengusaha Muslim yang mandiri, berakhlak, dan berdaya saing tinggi.
        </p>

        <!-- Stats strip -->
        <div style="display: flex; justify-content: center; max-width: 600px; margin: 0 auto; background: rgba(255,255,255,0.08); border-radius: 16px 16px 0 0; border: 1px solid rgba(255,255,255,0.12); border-bottom: none; backdrop-filter: blur(10px);">
            <?php
            $total_prog = wp_count_posts('pbi_program')->publish;
            $stats = [
                ['icon' => 'fa-solid fa-graduation-cap', 'val' => ($total_prog ?: '0') . '+', 'label' => 'Total Program'],
                ['icon' => 'fa-solid fa-users',          'val' => '10K+',                      'label' => 'Alumni Terlatih'],
                ['icon' => 'fa-solid fa-certificate',    'val' => '100%',                      'label' => 'Bersertifikat'],
            ];
            foreach ($stats as $s) : ?>
                <div style="flex: 1; padding: 22px 15px; text-align: center; border-right: 1px solid rgba(255,255,255,0.1);">
                    <i class="<?php echo $s['icon']; ?>" style="font-size: 22px; color: var(--pbi-accent); display: block; margin-bottom: 6px;"></i>
                    <div style="font-size: 26px; font-weight: 800; line-height: 1; margin-bottom: 5px;"><?php echo $s['val']; ?></div>
                    <div style="font-size: 11px; color: rgba(255,255,255,0.7); text-transform: uppercase; letter-spacing: 0.5px;"><?php echo $s['label']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- === MAIN CONTENT: ACTIVE PROGRAMS === -->
<div class="pbi-container" style="padding: 60px 15px; max-width: 1150px; margin: 0 auto;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; gap: 20px; flex-wrap: wrap;">
        <div>
            <h2 style="margin: 0; font-size: 24px; font-weight: 700; color: #1e293b;">Program &amp; Pendaftaran Aktif</h2>
            <p style="margin: 4px 0 0; font-size: 14px; color: #64748b;">
                <i class="fa-solid fa-bullhorn" style="color: var(--pbi-accent); margin-right: 4px;"></i>
                Menampilkan pendaftaran program pelatihan PBI terdekat yang sedang dibuka
            </p>
        </div>
    </div>

    <!-- Program Grid -->
    <div class="pbi-program-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(330px, 1fr)); gap: 28px;">
        <?php if ($upcoming_query->have_posts()) : while ($upcoming_query->have_posts()) : $upcoming_query->the_post();
            $prog_date     = get_post_meta(get_the_ID(), '_pbi_program_date', true);
            $prog_time     = get_post_meta(get_the_ID(), '_pbi_program_time', true);
            $prog_location = get_post_meta(get_the_ID(), '_pbi_program_location', true);
            $prog_cd_date  = get_post_meta(get_the_ID(), '_pbi_countdown_target', true);
            $wa_panitia    = get_post_meta(get_the_ID(), '_pbi_program_wa', true);
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="background: #ffffff; border: 1px solid #e8edf5; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; transition: all 0.3s ease; box-shadow: 0 2px 12px rgba(0,0,0,0.03);">

                <!-- Thumbnail -->
                <div style="height: 210px; overflow: hidden; position: relative; background: #f1f5f9;">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium_large', ['style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;']); ?>
                    <?php else : ?>
                        <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(11,70,40,0.08) 0%, rgba(212,175,55,0.12) 100%); gap: 10px;">
                            <i class="fa-solid fa-graduation-cap" style="font-size: 52px; color: var(--pbi-primary); opacity: 0.45;"></i>
                            <span style="font-size: 12px; color: var(--pbi-primary); font-weight: 600; opacity: 0.6; text-transform: uppercase; letter-spacing: 0.5px;">Program PBI</span>
                        </div>
                    <?php endif; ?>

                    <!-- Category Badge -->
                    <?php
                    $terms = get_the_terms(get_the_ID(), 'program_cat');
                    if (!empty($terms) && !is_wp_error($terms)) :
                        $term = array_shift($terms);
                    ?>
                        <span style="position: absolute; top: 12px; left: 12px; background: var(--pbi-accent); color: #fff; padding: 4px 12px; font-size: 10.5px; font-weight: 700; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 3px 8px rgba(0,0,0,0.15);">
                            <?php echo esc_html($term->name); ?>
                        </span>
                    <?php endif; ?>

                    <!-- Countdown badge on card if date is set -->
                    <?php if ($prog_cd_date) :
                        $ts = strtotime($prog_cd_date);
                        if ($ts && $ts > time()) : ?>
                            <div class="pbi-mini-cd" data-target="<?php echo esc_attr($prog_cd_date); ?>"
                                 style="position: absolute; bottom: 0; left: 0; right: 0; background: rgba(11,70,40,0.88); color: #fff; padding: 8px 14px; display: flex; align-items: center; justify-content: center; gap: 6px; backdrop-filter: blur(4px); font-size: 12.5px; font-weight: 700;">
                                <i class="fa-solid fa-clock" style="color: var(--pbi-accent);"></i>
                                <span class="pbi-mini-cd-text">Menghitung...</span>
                            </div>
                        <?php endif;
                    endif; ?>
                </div>

                <!-- Body -->
                <div style="padding: 22px; display: flex; flex-direction: column; flex-grow: 1; gap: 10px;">
                    <h3 style="margin: 0; font-size: 19px; font-weight: 700; line-height: 1.35;">
                        <a href="<?php the_permalink(); ?>" style="color: #1e293b; text-decoration: none;"><?php the_title(); ?></a>
                    </h3>

                    <!-- Meta info -->
                    <?php if ($prog_date || $prog_location) : ?>
                        <div style="display: flex; flex-wrap: wrap; gap: 10px; font-size: 12.5px; color: #64748b;">
                            <?php if ($prog_date) : ?>
                                <span><i class="fa-solid fa-calendar-day" style="color: var(--pbi-accent); margin-right: 3px;"></i> <?php echo esc_html($prog_date); ?><?php if ($prog_time) echo ' · ' . esc_html($prog_time); ?></span>
                            <?php endif; ?>
                            <?php if ($prog_location) : ?>
                                <span><i class="fa-solid fa-location-dot" style="color: var(--pbi-accent); margin-right: 3px;"></i> <?php echo esc_html(wp_trim_words($prog_location, 4)); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <p style="font-size: 13.5px; color: #64748b; line-height: 1.65; margin: 4px 0; flex-grow: 1;">
                        <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                    </p>

                    <!-- Actions -->
                    <div style="display: grid; grid-template-columns: 1fr <?php echo $wa_panitia ? 'auto' : ''; ?>; gap: 10px; margin-top: 10px; padding-top: 14px; border-top: 1px solid #f1f5f9; align-items: center;">
                        <a href="<?php the_permalink(); ?>" class="pbi-btn pbi-btn--primary" style="text-align: center; text-decoration: none; padding: 10px 18px; border-radius: 30px; font-size: 13px; font-weight: 700; display: block;">
                            Lihat Detail <i class="fa-solid fa-arrow-right" style="margin-left: 4px;"></i>
                        </a>
                        <?php if ($wa_panitia) : ?>
                            <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa_panitia)); ?>?text=<?php echo rawurlencode('Assalamualaikum, saya ingin mendaftar program: ' . get_the_title()); ?>"
                               target="_blank" rel="noopener"
                               style="background: #25d366; color: #fff; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; text-decoration: none; box-shadow: 0 4px 12px rgba(37,211,102,0.3); flex-shrink: 0;"
                               aria-label="Daftar via WhatsApp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

            </article>
        <?php endwhile; else : ?>
            <!-- Empty State -->
            <div style="grid-column: 1 / -1; text-align: center; padding: 50px 30px;">
                <h3 style="color: #334155; font-size: 18px; margin: 0 0 10px;">Program Aktif Segera Hadir</h3>
                <p style="color: #64748b; font-size: 14px; max-width: 420px; margin: 0 auto;">Belum ada pendaftaran program aktif yang dibuka saat ini.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination for Active Programs -->
    <?php if ($upcoming_query->max_num_pages > 1) : ?>
        <div style="margin-top: 50px; text-align: center;">
            <?php 
            echo paginate_links([
                'total'     => $upcoming_query->max_num_pages,
                'current'   => $paged,
                'prev_text' => '<i class="fa-solid fa-arrow-left-long"></i> Sebelumnya', 
                'next_text' => 'Selanjutnya <i class="fa-solid fa-arrow-right-long"></i>'
            ]); 
            ?>
        </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>

    <!-- === TABLE SECTION: PAST PROGRAMS / RIWAYAT KEGIATAN === -->
    <?php
    $past_args = array(
        'post_type'      => 'pbi_program',
        'posts_per_page' => -1, // Ambil semua data histori
        'tax_query'      => array(
            array(
                'taxonomy' => 'program_cat',
                'field'    => 'slug',
                'terms'    => 'riwayat',
                'operator' => 'IN',
            ),
        ),
        'meta_key'       => '_pbi_program_date',
        'orderby'        => 'meta_value',
        'order'          => 'DESC', // Terbaru di atas
    );
    $past_query = new WP_Query($past_args);
    ?>

    <div class="pbi-past-programs-section" style="margin-top: 80px; padding: 50px 30px; background: #f8fafc; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: inset 0 2px 8px rgba(0,0,0,0.01);">
        
        <div style="text-align: center; margin-bottom: 40px;">
            <span style="background: rgba(11,70,40,0.08); color: var(--pbi-primary); padding: 5px 18px; font-size: 11px; font-weight: 700; border-radius: 20px; text-transform: uppercase; letter-spacing: 1.5px;">Riwayat Perjalanan</span>
            <h2 style="font-size: 32px; font-weight: 800; color: #1e293b; margin: 10px 0 5px;">Program yang Pernah Dilaksanakan</h2>
            <p style="color: #64748b; font-size: 16px; max-width: 600px; margin: 0 auto;">Daftar lengkap program pelatihan akbar PBI yang telah sukses diselenggarakan sejak tahun 2016 secara dinamis.</p>
        </div>

        <!-- Filter & Search Bar -->
        <div class="pbi-table-toolbar" style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 25px; align-items: stretch; justify-content: space-between; flex-wrap: wrap;">
            <!-- Search Input -->
            <div style="position: relative; flex-grow: 1; max-width: 400px;">
                <input type="text" id="pbi-history-search" placeholder="Cari berdasarkan nama kegiatan, kota, lokasi..." style="width: 100%; padding: 12px 16px 12px 40px; border: 1px solid #cbd5e1; border-radius: 30px; font-size: 14.5px; outline: none; transition: all 0.2s;">
                <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 15px;"></i>
            </div>
            
            <!-- Filter Buttons -->
            <div class="pbi-history-filters" style="display: flex; flex-wrap: wrap; gap: 8px;">
                <button class="pbi-filter-btn active" data-filter="all">Semua</button>
                <button class="pbi-filter-btn" data-filter="PB">Pesantren Bisnis (PB)</button>
                <button class="pbi-filter-btn" data-filter="BT">Basic Training (BT)</button>
                <button class="pbi-filter-btn" data-filter="BBT">Business Basic Training (BBT)</button>
                <button class="pbi-filter-btn" data-filter="BOT">Business Owner (BOT)</button>
                <button class="pbi-filter-btn" data-filter="SPC">Spiritual Preneur (SPC)</button>
            </div>
        </div>

        <!-- Interactive Table Container -->
        <div class="pbi-table-responsive" style="overflow-x: auto; background: #ffffff; border-radius: 12px; border: 1px solid #cbd5e1; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <table id="pbi-history-table" style="width: 100%; border-collapse: collapse; min-width: 700px; font-size: 14.5px; text-align: left;">
                <thead>
                    <tr style="background: var(--pbi-primary); color: #ffffff;">
                        <th style="padding: 16px 20px; font-weight: 700; border-bottom: 2px solid rgba(0,0,0,0.1); width: 60px;">No</th>
                        <th style="padding: 16px 20px; font-weight: 700; border-bottom: 2px solid rgba(0,0,0,0.1); width: 100px;">Tahun</th>
                        <th style="padding: 16px 20px; font-weight: 700; border-bottom: 2px solid rgba(0,0,0,0.1);">Nama Kegiatan</th>
                        <th style="padding: 16px 20px; font-weight: 700; border-bottom: 2px solid rgba(0,0,0,0.1);">Lokasi & Wilayah</th>
                        <th style="padding: 16px 20px; font-weight: 700; border-bottom: 2px solid rgba(0,0,0,0.1); width: 140px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($past_query->have_posts()) : 
                        $no = 1;
                        while ($past_query->have_posts()) : $past_query->the_post(); 
                            $raw_date = get_post_meta(get_the_ID(), '_pbi_program_date', true);
                            
                            // Safe year extraction
                            $year = '2026';
                            if ($raw_date) {
                                if (preg_match('/\b(20\d{2})\b/', $raw_date, $matches)) {
                                    $year = $matches[1];
                                } elseif (strtotime($raw_date)) {
                                    $year = date('Y', strtotime($raw_date));
                                }
                            }
                            
                            // Safe display date format
                            $display_date = $raw_date;
                            if ($raw_date && strtotime($raw_date)) {
                                $months_id = array(
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                );
                                $m_num = intval(date('n', strtotime($raw_date)));
                                $display_date = (isset($months_id[$m_num]) ? $months_id[$m_num] : '') . ' ' . date('Y', strtotime($raw_date));
                            }
                            
                            $loc = get_post_meta(get_the_ID(), '_pbi_program_location', true);
                            
                            // Categories identifier for dynamic JS filter
                            $title = get_the_title();
                            $type = 'other';
                            if (stripos($title, 'PB ') !== false || $title === 'Pesantren Bisnis') $type = 'PB';
                            elseif (stripos($title, 'BBT ') !== false) $type = 'BBT';
                            elseif (stripos($title, 'BT ') !== false) $type = 'BT';
                            elseif (stripos($title, 'BOT ') !== false) $type = 'BOT';
                            elseif (stripos($title, 'SPC ') !== false) $type = 'SPC';
                            
                            $status_label = '<span class="badge-selesai">Selesai</span>';
                            if (stripos($loc, 'sedang berlangsung') !== false) {
                                $status_label = '<span class="badge-berlangsung">Berlangsung</span>';
                            }
                    ?>
                        <tr class="pbi-history-row" data-type="<?php echo esc_attr($type); ?>" style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;">
                            <td style="padding: 14px 20px; font-weight: 600; color: #64748b;"><?php echo $no++; ?></td>
                            <td style="padding: 14px 20px; font-weight: 700; color: var(--pbi-primary);"><?php echo esc_html($year); ?></td>
                            <td style="padding: 14px 20px;">
                                <div style="font-weight: 700; color: #1e293b;"><?php the_title(); ?></div>
                                <div style="font-size: 12px; color: #94a3b8; margin-top: 2px;"><i class="fa-solid fa-clock-rotate-left"></i> <?php echo esc_html($display_date); ?></div>
                            </td>
                            <td style="padding: 14px 20px; color: #475569; font-weight: 500;">
                                <i class="fa-solid fa-map-location-dot" style="color: var(--pbi-accent); margin-right: 4px; font-size: 13.5px;"></i> <?php echo esc_html($loc); ?>
                            </td>
                            <td style="padding: 14px 20px;"><?php echo $status_label; ?></td>
                        </tr>
                    <?php 
                        endwhile; 
                        wp_reset_postdata();
                    else : ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #64748b;">Belum ada riwayat kegiatan terdaftar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- Mini Countdown Script for Active Programs -->
<script>
document.querySelectorAll('.pbi-mini-cd').forEach(function(el) {
    var target = new Date(el.getAttribute('data-target')).getTime();
    var textEl = el.querySelector('.pbi-mini-cd-text');
    function tick() {
        var now = Date.now();
        var diff = target - now;
        if (diff <= 0) { textEl.textContent = 'Sedang Berlangsung!'; return; }
        var d = Math.floor(diff / 86400000);
        var h = Math.floor((diff % 86400000) / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);
        textEl.textContent = (d > 0 ? d + ' Hari ' : '') + pad(h) + ':' + pad(m) + ':' + pad(s) + ' lagi';
        setTimeout(tick, 1000);
    }
    function pad(n) { return n < 10 ? '0' + n : n; }
    tick();
});
</script>

<!-- Styles and scripts for interactive table -->
<style>
.pbi-program-grid article:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 35px rgba(11,70,40,0.08) !important;
    border-color: var(--pbi-primary) !important;
}
.pbi-program-grid article:hover img {
    transform: scale(1.06);
}
.pbi-filter-btn {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 8px 18px;
    font-size: 13px;
    font-weight: 700;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.pbi-filter-btn:hover {
    border-color: var(--pbi-primary);
    color: var(--pbi-primary);
    background: rgba(11,70,40,0.02);
}
.pbi-filter-btn.active {
    background: var(--pbi-primary);
    color: #ffffff;
    border-color: var(--pbi-primary);
    box-shadow: 0 4px 10px rgba(11,70,40,0.15);
}
.pbi-history-row:hover {
    background: #f8fafc;
}
.badge-selesai {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
    padding: 4px 12px;
    font-size: 12px;
    font-weight: 700;
    border-radius: 20px;
    border: 1px solid rgba(34, 197, 94, 0.2);
    display: inline-block;
}
.badge-berlangsung {
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
    padding: 4px 12px;
    font-size: 12px;
    font-weight: 700;
    border-radius: 20px;
    border: 1px solid rgba(59, 130, 246, 0.2);
    display: inline-block;
    animation: pulse-badge 2s infinite;
}
@keyframes pulse-badge {
    0% { opacity: 1; }
    50% { opacity: 0.6; }
    100% { opacity: 1; }
}

@media(min-width: 768px) {
    .pbi-table-toolbar {
        flex-direction: row !important;
    }
}
@media (max-width: 600px) {
    .pbi-prog-hero h1 { font-size: 28px !important; }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var searchInput = document.getElementById("pbi-history-search");
    var filterBtns = document.querySelectorAll(".pbi-filter-btn");
    var tableRows = document.querySelectorAll(".pbi-history-row");
    
    var currentFilter = "all";
    var currentQuery = "";
    
    function filterTable() {
        var visibleCount = 0;
        tableRows.forEach(function(row) {
            var type = row.getAttribute("data-type");
            var text = row.textContent.toLowerCase();
            
            var matchesFilter = (currentFilter === "all" || type === currentFilter);
            var matchesQuery = (currentQuery === "" || text.indexOf(currentQuery) > -1);
            
            if (matchesFilter && matchesQuery) {
                row.style.display = "";
                visibleCount++;
                // Re-stripe row numbering visually
                row.querySelector("td").textContent = visibleCount;
            } else {
                row.style.display = "none";
            }
        });
    }
    
    // Search input handler
    if(searchInput) {
        searchInput.addEventListener("input", function(e) {
            currentQuery = e.target.value.toLowerCase();
            filterTable();
        });
        // focus shadow effect
        searchInput.addEventListener("focus", function() {
            this.style.borderColor = "var(--pbi-primary)";
            this.style.boxShadow = "0 0 0 4px rgba(11,70,40,0.1)";
        });
        searchInput.addEventListener("blur", function() {
            this.style.borderColor = "#cbd5e1";
            this.style.boxShadow = "";
        });
    }
    
    // Filter buttons handler
    filterBtns.forEach(function(btn) {
        btn.addEventListener("click", function() {
            filterBtns.forEach(function(b) { b.classList.remove("active"); });
            this.classList.add("active");
            currentFilter = this.getAttribute("data-filter");
            filterTable();
        });
    });
});
</script>

<?php
get_footer();
