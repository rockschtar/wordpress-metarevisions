<?php

/*
Plugin Name:  WordPress MetaRevisions
Plugin URI:   https://validio.de
Description:  Enables meta-data revisions via simplified hooks/filters for usage with roots/bedrock based WordPress projects.
Version:      1.0.0
Author:       Stefan Helmer
Author URI:   https://eracer.de
License:      MIT License
*/

use Rockschtar\WordPress\MetaRevisions\MetaRevisions;

define('RSWPMR_PLUGIN_DIR', plugin_dir_path(__FILE__));

MetaRevisions::init();