<?php
define('APP_ROOT',              realpath(dirname(__FILE__) . '/../..'));
define('OFFSITE_ROOT',          APP_ROOT . '/_offsite');
define('INCLUDE_ROOT',          OFFSITE_ROOT . '/include');
define('LIB_ROOT',              INCLUDE_ROOT . '/lib');

set_include_path('.:' . LIB_ROOT);
?>