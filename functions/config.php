<?php

define('ORIGINAL_IMAGE_DIR', dirname($_SERVER['SCRIPT_FILENAME']).'/uploads/original_image/');
define('BIG_THUMBNAIL_DIR', dirname($_SERVER['SCRIPT_FILENAME']).'/uploads/big_thumbnail/');
define('MIDDLE_THUMBNAIL_DIR', dirname($_SERVER['SCRIPT_FILENAME']).'/uploads//middle_thumbnail/');
define('SMALL_THUMBNAIL_DIR', dirname($_SERVER['SCRIPT_FILENAME']).'/uploads//small_thumbnail/');

define('BIG_THUMBNAIL_WIDTH', 480); // 480px
define('MIDDLE_THUMBNAIL_WIDTH', 240); // 240px
define('SMALL_THUMBNAIL_WIDTH', 220); // 220px

define('MAX_FILE_SIZE', 307200); // 300KB = 1KB/1024bytes * 300

error_reporting(E_ALL & E_NOTICE);

// GD
if (!function_exists('imagecreatetruecolor')){
  echo "GDがインストールされていません";
  exit;
}
