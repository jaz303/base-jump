base-jump is a simple PHP framework extracted from priceyourmeal.com and built
on the BasePHP library (also hosted on github).

Trying it out:
--------------

You need to set up an Apache vhost and do some configuration. A quick example
(substitute {$DOC_ROOT} as appropriate):

  &lt;VirtualHost *:4014&gt;
    
      DocumentRoot {$DOC_ROOT}/
    
      Options +FollowSymLinks
    
      php_value     auto_prepend_file   "{$DOC_ROOT}/_offsite/include/prepend.php"
      php_value     auto_append_file    "{$DOC_ROOT}/_offsite/include/append.php"
    
      &lt;Directory {$DOC_ROOT}/&gt;
          Options +Indexes
          Allow from all
      &lt;/Directory&gt;
    
      &lt;Directory {$DOC_ROOT}/_offsite/&gt;
          Order deny,allow
          Deny from all
      &lt;/Directory&gt;
    
  &lt;/VirtualHost&gt;

