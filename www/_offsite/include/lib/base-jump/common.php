<?php
function posted() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function static_url($resource, $prefix = null) {
    if ($prefix) $resource = "$prefix/$resource";
    return STATIC_URL . $resource;
}

function javascript_include_tag($script) {
    return H::tag('script', '', array('src' => static_url($script, 'javascripts'))) . "\n";
}

function stylesheet_link_tag($stylesheet) {
    return H::empty_tag('link', array('rel' => 'stylesheet', 'href' => static_url($stylesheet, 'stylesheets'))) . "\n";
}
?>