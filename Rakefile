PREPEND_FILE = 'www/_offsite/include/prepend.php'

namespace :autoload do
  task :sync do
    
    autoload_map = `vendor/base-php/util/generate_autoload_map www/_offsite/include/lib`
    code = "static $map = #{autoload_map};".split("\n").map { |l| "    #{l}" }.join("\n")
    
    src = File.read(PREPEND_FILE)
    out = src.gsub(/\/\/\s+START-MAP(.*?)\/\/\s+END-MAP/m, "// START-MAP\n#{code}\n    // END-MAP")
    
    File.open(PREPEND_FILE, 'w') { |f| f.write(out) }
    
  end
end