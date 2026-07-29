<?php
/**
 * Archive Template for Business Directory (pbi_directory)
 * Author: Official PBI (pesantrenbisnisindonesia.org)
 */
defined('ABSPATH') || exit;

get_header();
?>

<!-- === HERO BANNER === -->
<div class="pbi-dir-hero" style="background: linear-gradient(135deg, var(--pbi-primary) 0%, #07301b 100%); padding: 80px 0 0; color: #fff; text-align: center; position: relative; overflow: hidden;">
    <!-- Decorative circles -->
    <div style="position: absolute; top: -80px; right: -80px; width: 350px; height: 350px; background: radial-gradient(circle, rgba(212,175,55,0.18) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    <div style="position: absolute; bottom: 0; left: -60px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(212,175,55,0.12) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="pbi-container" style="position: relative; z-index: 2; max-width: 860px; margin: 0 auto; padding: 0 15px;">
        <span style="background: var(--pbi-accent); color: #fff; padding: 5px 18px; font-size: 11px; font-weight: 700; border-radius: 20px; text-transform: uppercase; letter-spacing: 1.5px; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(212,175,55,0.3);">
            <i class="fa-solid fa-network-wired"></i> Jaringan Perdagangan Nasional PBI
        </span>
        <h1 style="color: #ffffff; margin: 0 0 18px; font-size: 42px; font-weight: 800; line-height: 1.2; letter-spacing: -0.5px;">
            Direktori Bisnis<br><span style="color: var(--pbi-accent);">UMKM Muslim Indonesia</span>
        </h1>
        <p style="margin: 0 auto 40px; color: rgba(255,255,255,0.85); font-size: 17px; line-height: 1.7; max-width: 680px;">
            Menghubungkan puluhan ribu wirausahawan Muslim &amp; UMKM alumni PBI di seluruh Indonesia menuju kekuatan ekonomi umat yang mandiri dan berdaulat.
        </p>

        <!-- Stats Bar -->
        <div style="display: flex; justify-content: center; gap: 0; margin: 0 auto 0; flex-wrap: wrap; background: rgba(255,255,255,0.08); border-radius: 16px 16px 0 0; border: 1px solid rgba(255,255,255,0.12); border-bottom: none; max-width: 700px; backdrop-filter: blur(10px);">
            <?php
            $total_dir  = wp_count_posts('pbi_directory')->publish;
            $total_prog = wp_count_posts('pbi_program')->publish;
            $stats = [
                ['icon' => 'fa-solid fa-store',       'val' => ($total_dir ?: '0') . '+',   'label' => 'Mitra Bisnis Terdaftar'],
                ['icon' => 'fa-solid fa-map-location-dot', 'val' => '34',                   'label' => 'Provinsi Terjangkau'],
                ['icon' => 'fa-solid fa-graduation-cap',   'val' => ($total_prog ?: '0') . '+', 'label' => 'Program Pelatihan'],
                ['icon' => 'fa-solid fa-handshake',        'val' => '10K+',                  'label' => 'Alumni Berdaya'],
            ];
            foreach ($stats as $s) : ?>
                <div style="flex: 1; min-width: 140px; padding: 22px 15px; text-align: center; border-right: 1px solid rgba(255,255,255,0.1);">
                    <i class="<?php echo $s['icon']; ?>" style="font-size: 22px; color: var(--pbi-accent); display: block; margin-bottom: 6px;"></i>
                    <div style="font-size: 26px; font-weight: 800; line-height: 1; margin-bottom: 5px;"><?php echo $s['val']; ?></div>
                    <div style="font-size: 11px; color: rgba(255,255,255,0.7); text-transform: uppercase; letter-spacing: 0.5px;"><?php echo $s['label']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- === MAIN CONTENT === -->
<div class="pbi-container" style="padding: 60px 15px; max-width: 1150px; margin: 0 auto;">

    <!-- Section Title + Search Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; gap: 20px; flex-wrap: wrap;">
        <div>
            <h2 style="margin: 0; font-size: 24px; font-weight: 700; color: #1e293b;">Semua Mitra Bisnis</h2>
            <p style="margin: 4px 0 0; font-size: 14px; color: #64748b;">
                <i class="fa-solid fa-list-check" style="color: var(--pbi-accent); margin-right: 4px;"></i>
                Menampilkan <strong><?php echo $GLOBALS['wp_query']->found_posts; ?></strong> Bisnis Member
            </p>
        </div>

        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" style="display: flex; gap: 10px; align-items: center;">
            <input type="text" placeholder="Cari bisnis member..." name="s" value="<?php echo get_search_query(); ?>"
                style="padding: 11px 18px; border-radius: 30px; border: 1.5px solid #e2e8f0; font-size: 14px; min-width: 230px; outline: none; transition: border-color 0.2s ease;"
                onfocus="this.style.borderColor='var(--pbi-primary)'" onblur="this.style.borderColor='#e2e8f0'">
            <input type="hidden" name="post_type" value="pbi_directory" />
            <button type="submit" class="pbi-btn pbi-btn--primary" style="border-radius: 30px; padding: 11px 24px; font-size: 14px; font-weight: 600;">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>
        </form>
    </div>

    <!-- Directory Grid -->
    <div class="pbi-directory-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 28px;">
        <?php if (have_posts()) : while (have_posts()) : the_post();
            $business_wa      = get_post_meta(get_the_ID(), '_pbi_business_wa', true);
            $business_address = get_post_meta(get_the_ID(), '_pbi_business_address', true);
            $business_owner   = get_post_meta(get_the_ID(), '_pbi_business_owner', true);
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="background: #ffffff; border: 1px solid #e8edf5; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; transition: all 0.3s ease; box-shadow: 0 2px 12px rgba(0,0,0,0.03);">
                
                <!-- Card Image -->
                <div style="height: 195px; overflow: hidden; position: relative; background: #f1f5f9;">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium_large', ['style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;']); ?>
                    <?php else : ?>
                        <!-- Premium Placeholder -->
                        <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(11,70,40,0.06) 0%, rgba(212,175,55,0.10) 100%); gap: 10px;">
                            <i class="fa-solid fa-store" style="font-size: 48px; color: var(--pbi-primary); opacity: 0.5;"></i>
                            <span style="font-size: 12px; color: var(--pbi-primary); font-weight: 600; opacity: 0.6; text-transform: uppercase; letter-spacing: 0.5px;">Member PBI</span>
                        </div>
                    <?php endif; ?>

                    <!-- Category Badge -->
                    <?php
                    $terms = get_the_terms(get_the_ID(), 'business_cat');
                    if (!empty($terms) && !is_wp_error($terms)) :
                        $term = array_shift($terms);
                    ?>
                        <span style="position: absolute; bottom: 12px; left: 12px; background: var(--pbi-primary); color: #fff; padding: 4px 12px; font-size: 10.5px; font-weight: 700; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 3px 8px rgba(0,0,0,0.2);">
                            <?php echo esc_html($term->name); ?>
                        </span>
                    <?php endif; ?>

                    <!-- Member badge -->
                    <span style="position: absolute; top: 12px; right: 12px; background: rgba(212,175,55,0.9); color: #fff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; backdrop-filter: blur(4px);" title="Member PBI Terverifikasi">
                        <i class="fa-solid fa-award"></i>
                    </span>
                </div>

                <!-- Card Body -->
                <div style="padding: 22px; display: flex; flex-direction: column; flex-grow: 1; gap: 8px;">
                    <?php if ($business_owner) : ?>
                        <span style="font-size: 11.5px; color: #94a3b8; display: flex; align-items: center; gap: 4px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">
                            <i class="fa-solid fa-user-tie" style="color: var(--pbi-primary);"></i> <?php echo esc_html($business_owner); ?>
                        </span>
                    <?php endif; ?>

                    <h3 style="margin: 0; font-size: 19px; font-weight: 700; line-height: 1.35;">
                        <a href="<?php the_permalink(); ?>" style="color: #1e293b; text-decoration: none;"><?php the_title(); ?></a>
                    </h3>
                    
                    <?php if ($business_address) : ?>
                        <span style="font-size: 13px; color: #64748b; display: flex; align-items: center; gap: 5px;">
                            <i class="fa-solid fa-location-dot" style="color: var(--pbi-accent);"></i>
                            <?php echo esc_html(wp_trim_words($business_address, 6)); ?>
                        </span>
                    <?php endif; ?>

                    <p style="font-size: 13.5px; color: #64748b; line-height: 1.65; margin: 6px 0; flex-grow: 1;">
                        <?php echo wp_trim_words(get_the_excerpt(), 16); ?>
                    </p>

                    <!-- Footer Actions -->
                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 10px; margin-top: 14px; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                        <a href="<?php the_permalink(); ?>" class="pbi-btn pbi-btn--outline" style="text-align: center; text-decoration: none; padding: 9px 15px; border-radius: 30px; font-size: 13px; font-weight: 600; display: block;">
                            Lihat Profil Usaha
                        </a>
                        <?php if ($business_wa) : ?>
                            <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $business_wa)); ?>?text=<?php echo rawurlencode('Assalamualaikum wr. wb., saya melihat Profil Usaha Anda di Direktori UMKM PBI: ' . get_the_title()); ?>"
                               target="_blank" rel="noopener"
                               style="background: #25d366; color: #fff; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; text-decoration: none; box-shadow: 0 4px 12px rgba(37,211,102,0.3); flex-shrink: 0;"
                               aria-label="Hubungi via WhatsApp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
        <?php endwhile; else : ?>
            <!-- Empty State -->
            <div style="grid-column: 1 / -1; text-align: center; padding: 80px 30px;">
                <div style="background: linear-gradient(135deg, rgba(11,70,40,0.05), rgba(212,175,55,0.08)); width: 110px; height: 110px; border-radius: 50%; margin: 0 auto 25px; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-store" style="font-size: 50px; color: var(--pbi-primary); opacity: 0.4;"></i>
                </div>
                <h3 style="color: #334155; font-size: 20px; margin: 0 0 10px;">Direktori Bisnis Segera Hadir</h3>
                <p style="color: #64748b; font-size: 15px; max-width: 400px; margin: 0 auto 25px;">Belum ada bisnis member yang terdaftar. Jadilah yang pertama bergabung dalam jaringan perdagangan nasional PBI.</p>
                <a href="<?php echo esc_url(get_page_link(get_page_by_path('hubungi-kami'))); ?>" class="pbi-btn pbi-btn--primary" style="text-decoration: none; padding: 12px 30px; border-radius: 30px; font-weight: 700; display: inline-block;">
                    <i class="fa-solid fa-handshake" style="margin-right: 6px;"></i> Daftarkan Bisnis Anda
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 50px; text-align: center;">
        <?php
        echo paginate_links([
            'prev_text' => '<i class="fa-solid fa-arrow-left-long"></i> Sebelumnya',
            'next_text' => 'Selanjutnya <i class="fa-solid fa-arrow-right-long"></i>',
        ]);
        ?>
    </div>

</div>

<!-- === CALL TO ACTION STRIP === -->
<div style="background: linear-gradient(135deg, var(--pbi-accent), #b8941e); padding: 60px 20px; text-align: center;">
    <div style="max-width: 650px; margin: 0 auto;">
        <i class="fa-solid fa-handshake" style="font-size: 36px; color: rgba(255,255,255,0.9); margin-bottom: 15px; display: block;"></i>
        <h2 style="color: #fff; font-size: 26px; font-weight: 800; margin: 0 0 12px;">Ingin Bisnis Anda Masuk Direktori?</h2>
        <p style="color: rgba(255,255,255,0.9); font-size: 15.5px; margin: 0 auto 28px; line-height: 1.7; max-width: 500px;">Bergabunglah dengan jaringan pengusaha Muslim PBI dan raih peluang kolaborasi bisnis yang lebih luas di seluruh Indonesia.</p>
        <a href="<?php echo esc_url(home_url('/hubungi-kami/')); ?>" style="background: #fff; color: var(--pbi-accent); text-decoration: none; padding: 14px 35px; border-radius: 30px; font-weight: 800; font-size: 15px; display: inline-block; box-shadow: 0 8px 25px rgba(0,0,0,0.15); transition: all 0.3s ease;">
            <i class="fa-solid fa-paper-plane" style="margin-right: 6px;"></i> Hubungi Kami Sekarang
        </a>
    </div>
</div>

<style>
.pbi-directory-grid article:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 35px rgba(11,70,40,0.08) !important;
    border-color: var(--pbi-primary) !important;
}
.pbi-directory-grid article:hover img {
    transform: scale(1.06);
}
@media (max-width: 600px) {
    .pbi-dir-hero h1 { font-size: 28px !important; }
}
</style>

<?php
get_footer();
