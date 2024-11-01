<?php

namespace StartklarImageOptimizer;
class StartklarImageOptimizerProcessor
{

    public static function mediaImagesOptimization($limit = 1)
    {
        $debug_log = __DIR__ . "/debug.log";
        global $wpdb, $table_prefix;
        if (!empty(get_option('optimizer_limit_option'))) {
            $limit = get_option('optimizer_limit_option');
        }
        if (!$limit) {
            $limit = 1;
        }
        self::writeToDebugLog("====START OPTIMIZATION " . date("d.m.Y H:i:s"), $debug_log);
        $uploads_dir_info = wp_upload_dir();
        $sql = $wpdb->prepare("SELECT m.*
                    FROM {$table_prefix}postmeta as m
                    WHERE  (m.meta_key = %s OR m.meta_key = %s) AND NOT EXISTS (
                        SELECT * FROM  {$table_prefix}postmeta as m2
                        WHERE m2.meta_key = %s AND m2.meta_value = %d  AND m2.post_id = m.post_id)
                    ORDER BY m.meta_id DESC
                    LIMIT " . $limit,'_wp_attached_file','_wp_attachment_metadata','_startklar_optimazed_flag','1');

        $results = $wpdb->get_results($sql, ARRAY_A);
        foreach ($results as $post_meta) {
            if (isset($post_meta) && is_array($post_meta) && isset($post_meta["meta_value"]) && !empty($post_meta["meta_value"])) {

                if ($post_meta["meta_key"] == '_wp_attached_file') {
                    $img_files[] = $uploads_dir_info['basedir'] . "/" . $post_meta["meta_value"];
                    self::writeToDebugLog("_wp_attached_file id=" . $post_meta["meta_id"], $debug_log);
                } elseif ($post_meta["meta_key"] == '_wp_attachment_metadata') {
                    self::writeToDebugLog("_wp_attachment_metadata id=" . $post_meta["meta_id"], $debug_log);
                    $extra_res_imgs = unserialize($post_meta["meta_value"]);
                    $subfolder = dirname($extra_res_imgs["file"]);
                    $subfolder = trim($subfolder, "/");
                    foreach ($extra_res_imgs["sizes"] as $img_arr) {
                        $img_files[] = $uploads_dir_info['basedir'] . "/" . $subfolder . "/" . $img_arr["file"];
                    }
                }
                foreach ($img_files as $img_file) {
                    if (file_exists($img_file) && is_file($img_file) && is_readable($img_file)) {
                        $img_file_info = pathinfo($img_file);
                        $file_ext = strtolower($img_file_info["extension"]);
                        if ($file_ext == "jpg" || $file_ext == "jpeg") {
                            $factory = new \ImageOptimizer\OptimizerFactory(array('jpegoptim_options' => array('--strip-all', '--all-progressive', '-m85')));
                            $optimizer = $factory->get('jpegoptim');
                            $optimizer->optimize($img_file);
                            self::writeToDebugLog("PROCESS FILE" . $img_file . "  BY jpegoptim", $debug_log);
                        }
                        if ($file_ext == "png") {
                            $factory = new \ImageOptimizer\OptimizerFactory(array('pngquant_options' => array('--quality=60-80', '--verbose', '--skip-if-larger', '--force', '--ext=.png')));
                            $optimizer = $factory->get('pngquant');
                            $optimizer->optimize($img_file);
                            self::writeToDebugLog("PROCESS FILE" . $img_file . "  BY pngquant", $debug_log);


                        }
                    } else {
                        self::writeToDebugLog("File not found:       " . $img_file, $debug_log);
                    }
                }
            }
            update_post_meta($post_meta["post_id"], '_startklar_optimazed_flag', '1');
        }
        self::writeToDebugLog("====END", $debug_log);


    }
    
    public static function writeToDebugLog($text, $debug_log){
            if (WP_DEBUG == true) {
                file_put_contents($debug_log, "\n".$text, FILE_APPEND);
            }
    }


}