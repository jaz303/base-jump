<?php
if ($_SERVER['SCRIPT_NAME'] != '/_dispatch.php' && !$tpl->performed()) {
    $tpl->display_page();
}
?>