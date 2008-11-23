<?php
namespace BaseJump;

class Template extends ::Template
{
    public function __construct() {
        $this->layout(':default');
    }

    protected function before_filter() {
        
        $dir = dirname($this->page());
        
        $css = "$dir/section.css";
        if (is_file($css)) $this->append('style', "\n" . file_get_contents($css));
        
        $css = "$dir/index.css";
        if (is_file($css)) $this->append('style', "\n" . file_get_contents($css) . "\n");
        
    }

    protected function resolve_template_path($template) {
        
        if ($template === null) {
            $template = basename($_SERVER['PHP_SELF'], '.php');
        }
        
        if ($template[0] == ':') {
            return TPL_ROOT . '/' . substr($template, 1) . '.php';
        } else {
            return TPL_DIR . '/' . $template . '.php';
        }
        
    }
    
    protected function resolve_layout_path($layout) {
        if ($layout === true) {
            return $this->resolve_template_path('layout');
        } elseif ($layout[0] == ':') {
            return $this->resolve_template_path(':layout/' . substr($layout, 1));
        } else {
            throw new Error_IllegalArgument;
        }
    }
}
?>