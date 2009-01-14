<?php
namespace BaseJump;

class Template extends \Template
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

class Router
{
    private $request;
    private $routes     = array();
    private $catches    = array();
    
    public function __construct($request) {
        $this->request  = $request;
        $this->path     = $request->path();
        $this->method   = strtolower($request->method());
    }
    
    public function route($method, $pattern, $lambda) {
        $this->routes[] = array('method'    => $method,
                                'pattern'   => $pattern,
                                'lambda'    => $lambda);        
    }
    
    public function get($pattern, $lambda) {
        $this->route('get', $pattern, $lambda);
    }
    
    public function post($pattern, $lambda) {
        $this->route('post', $pattern, $lambda);
    }
    
    public function put($pattern, $lambda) {
        $this->route('put', $pattern, $lambda);
    }
    
    public function delete($pattern, $lambda) {
        $this->route('delete', $pattern, $lambda);
    }
    
    public function rescue($exception_class, $lambda) {
        $this->catches[$exception_class] = $lambda;
    }
    
    public function go() {
        foreach ($this->routes as $route) {
            if ($this->matches($route)) {
                try {
                    $this->invoke($route['lambda']);
                    return;
                } catch (\Exception $e) {
                    foreach ($this->catches as $class => $lambda) {
                        if (is_a($e, $class)) {
                            $this->invoke($lambda);
                            return;
                        }
                    }
                    throw $e;
                }
            }
        }
    }
    
    private function matches($route) {
        
        $methods = (array) $route['method'];
        if (!in_array($this->method, $methods)) {
            return false;
        }
        
        if ($route['pattern'][0] == '#') { // regex match
            $match = (bool) preg_match($route['pattern'], $this->path);
        } else { // string match
            $match = strpos($route['pattern'], $this->path) === 0;
        }
        
        return $match;

    }
    
    private function invoke($lambda) {
        $lambda();
    }
}
?>