base-jump is a simple PHP framework extracted from priceyourmeal.com and built
on the BasePHP library (also hosted on github).

Trying it out:
--------------

You need to set up an Apache vhost and do some configuration. A quick example
(substitute {$DOC_ROOT} as appropriate):

    <VirtualHost *:4014>
    
        DocumentRoot {$DOC_ROOT}/
    
        Options +FollowSymLinks
    
        php_value     auto_prepend_file   "{$DOC_ROOT}/_offsite/include/prepend.php"
        php_value     auto_append_file    "{$DOC_ROOT}/_offsite/include/append.php"
    
        <Directory {$DOC_ROOT}/>
            Options +Indexes
            Allow from all
        </Directory>
    
        <Directory {$DOC_ROOT}/_offsite/>
            Order deny,allow
            Deny from all
        </Directory>
    
    </VirtualHost>

