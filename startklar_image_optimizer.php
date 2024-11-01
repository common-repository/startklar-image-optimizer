<?php

namespace StartklarImageOptimizer;
/*
Plugin Name: Startklar Image Optimizer
Plugin URI: https://startklar.app/
Description: Plugin  is designed for batch optimization of images that are in the WordPress media library.
Version: 1.0
Author:  Startklar
Author URI: https://startklar.app/
Requires at least: 5.6
Requires PHP: 5.6.20
Text Domain: startklar-image-optimizer
Domain Path: /languages
*/
require __DIR__ . '/lib/image-optimizer/vendor/autoload.php';
require_once __DIR__ . "/StartklarPluginAdminPage.class.php";
$temp = new \StartklarImageOptimizer\StartklarPluginAdminPage;
require_once __DIR__ . "/StartklarImageOptimizerProcessor.class.php";
add_action('startklar_image_optimizer_process', array("StartklarImageOptimizer\StartklarImageOptimizerProcessor", 'mediaImagesOptimization'));
