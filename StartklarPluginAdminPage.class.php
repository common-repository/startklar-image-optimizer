<?php
namespace StartklarImageOptimizer;

class StartklarPluginAdminPage
{

    function startklarAdminMenu()
    {
        add_menu_page(
            __('Startklar Image Optimizer', "startklar-image-optimizer"),
            __('Startklar Image Optimizer', "startklar-image-optimizer"),
            'manage_options',
            'startklar-image-optimizer',
            array($this, 'StartklarImageOptimizerPluginAdminPage'),
            plugin_dir_url(__FILE__) . 'startklar_logo.png',
            100
        );
    }

    function __construct()
    {
        add_action('admin_menu', [$this, 'startklarAdminMenu']);
    }

    function StartklarImageOptimizerPluginAdminPage()
    {


        load_theme_textdomain('startklar-image-optimizer', __DIR__ . '/languages');
        wp_enqueue_style('startklar-image-optimizer_styles', plugins_url('/assets/Styles.css', __FILE__));
        ?>
        <!-- Our admin page content should all be inside .wrap -->
        <div class="wrap">
            <?php
            //Testing pngquant
            exec('pngquant -h', $output_exec_pngquant, $retval_pngquant);
            $output_exec_pngquant = implode($output_exec_pngquant);
            preg_match("/pngquant,?\s*\d{1,2}\.\d{1,2}\.\d{1,2}/ism", $output_exec_pngquant, $matches_pngquant);
            if (!empty($matches_pngquant)) { ?>
                <div class='notice notice-success'>
                    <p>
                        <?php echo __("The mandatory utility pngquant detect!", 'startklar-image-optimizer') ?>
                    </p>
                </div>
            <?php } else { ?>
                <div class="notice notice-error">
                    <p>
                        <?php echo __('The mandatory utility pngquant required for the plugin to work is missing!', 'startklar-image-optimizer') ?>
                    </p>
                </div>
            <?php }
            //Testing jpegoptim
            exec('jpegoptim -t', $output_exec_jpegoptim, $retval_jpegoptim);
            $output_exec_jpegoptim = implode($output_exec_jpegoptim);
            preg_match("/Average\s*compression\s*\(\d\s*files\)/ism", $output_exec_jpegoptim, $matches_jpegoptim);
            if (!empty($matches_jpegoptim)) { ?>
                <div class='notice notice-success'>
                    <p>
                        <?php echo __('The mandatory utility jpegoptim detect!', 'startklar-image-optimizer') ?>
                    </p>
                </div> <?php
            } else { ?>
                <div class="notice notice-error">
                    <p>
                        <?php echo __('The mandatory utility jpegoptim required for the plugin to work is missing!', 'startklar-image-optimizer') ?>
                    </p>
                </div>
            <?php }
            ?>  </div>

        <!-- Print the page title -->
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <br>
        <h2><?php echo __('Count image in base:','startklar-image-optimizer')?></h2>
        <?php
        $getCountAllImg = $this->getCountAllImg();
        $getCountOptimizeImg = $this->getCountOptimizeImg();
        $getNumberOfOptimizedImages = strval($this->getNumberOfOptimizedImages());
        ?>
        <p>
            <?php echo esc_textarea($getCountAllImg) ?><br>
            <?php echo esc_textarea($getCountOptimizeImg) ?>
        </p>
        <h2><?php echo __('Select the number of optimized images for one pass:','startklar-image-optimizer')?></h2>
        <form action="" method="post">
            <input type="text" id="limit" class="data-hj-whitelist" name="limit"
                   value="<?php echo esc_textarea($getNumberOfOptimizedImages) ?>"><br><br>
            <input type="submit" class="button button-primary" value="Ok">
        </form>
        <?php


    }

    public static function getNumberOfOptimizedImages()
    {
        if (!empty($_POST['limit'])) {
            $number = sanitize_text_field($_POST['limit']);
            if(!get_option('optimizer_limit_option')){
                add_option('optimizer_limit_option', $number);
            }
            if (preg_match('/[^\d]/', $number)) {
                return esc_textarea(__("Please, enter numbers or enter an integer!",'startklar-image-optimizer')) ;
            } else {
                update_option('optimizer_limit_option', $number);

            }


        }
        return get_option('optimizer_limit_option');
    }

    public static function getCountOptimizeImg()
    {

         global $wpdb, $table_prefix;
         $count_optimaze_img = "SELECT COUNT(*) as count
                     FROM `{$table_prefix}postmeta` as m
                     WHERE  (m.meta_key = %s OR m.meta_key = %s) AND EXISTS (
                     SELECT * FROM   `{$table_prefix}postmeta` as m2
                     WHERE m2.meta_key =%s AND m2.meta_value = 1  AND m2.post_id = m.post_id) ";
         $results_count_optimize_img = $wpdb->get_results($wpdb->prepare($count_optimaze_img,'_wp_attached_file','_wp_attachment_metadata','_startklar_optimazed_flag' ), ARRAY_A);

         if (!empty($results_count_optimize_img)) {
             foreach ($results_count_optimize_img["0"] as $res1) {
                 $countOptimizeImg = __("Optimized image: ",'startklar-image-optimizer') . esc_textarea($res1);
             }
         } else {
             $countOptimizeImg = __("Optimized image: 0",'startklar-image-optimizer');
         }
         return $countOptimizeImg;

     }

    public static function getCountAllImg()
    {
        global $wpdb, $table_prefix;
        $count_all_img = "SELECT COUNT(*) as count
					FROM `{$table_prefix}postmeta` as m
                    WHERE  (m.meta_key = '_wp_attached_file' OR m.meta_key = '_wp_attachment_metadata') AND  NOT EXISTS (
                    SELECT *
					FROM `{$table_prefix}postmeta` as m2
                    WHERE m2.meta_value LIKE ('%.svg') AND m2.post_id = m.post_id)";
        $results_count_all_img = $wpdb->get_results($wpdb->prepare($count_all_img), ARRAY_A);
        if (!empty($results_count_all_img)) {
            foreach ($results_count_all_img["0"] as $res) {
                $str = __("All image in your base: ",'startklar-image-optimizer') . esc_textarea($res);
            }
        } else {
            $str = __("All image in your base: 0",'startklar-image-optimizer');
        }
        return $str;
    }
}
