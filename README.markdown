base-jump
=========

(c) 2008 Jason Frame [jason@onehackoranother.com]

base-jump is a simple PHP framework in the early stages of development.
It was extracted from [priceyourmeal.com](http://www.priceyourmeal.com)
and is built on the [BasePHP](http://github.com/jaz303/base-php/tree/master)
library. PHP 5.3 is required.

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

If you've got access to lighttpd via the CLI this is also an option - edit the paths
to lighty and PHP in `www/_offsite/shell/server` and `www/_offsite/config/lighty.conf`
respectively then run `_offsite/shell/server` from within the `www` directory.

Quickstart Guide:
-----------------

Open `www/index.php` for editing and enter:

    <?php
    $TPL->name = "enter your name here";
    ?>
    
Now open `www/tpl/index.php` and enter:

    <h1>Hello, <?= $name ?></h1>

Hit your web root with your browser and you should be greeted.

Things to note:

  * The template object, $TPL, was automatically instantiated by PHP's auto prepend file
    (located at www/_offsite/include/prepend.php)
  * Fields assigned to the template object are extracted to regular variables in the
    template file
  * We didn't have to explicitly tell the template to render - this was handled by PHP's
    auto append file (located at www/_offsite/include/append.php)
  * The whole template is wrapped in a _layout_, found at www/_offsite/tpl/layout/default.php
  
Next, edit `www/tpl/index.css` and add:

    h1 { color: red }

Refresh your web-browser and the greeting becomes red. Note that the layout mentioned above
contains no reference to this stylesheet - the template object noticed there existed a
stylesheet with basename matching that of the template file and injected it automatically.
You can also use `section.css` to inject styles into all templates in a given directory.

Last thing. Create a file, `www/_offsite/tpl/common.php`, and write some HTML into it.
Edit `www/tpl/index.php` again and append:

    <?= $this->render_template(':common') ?>
    
Refresh and the content you entered into `common.php` will appear at the bottom of the
page, demonstrating that we can prefix template references with `:` to indicate that
they should be sourced from the _template root_ (`www/_offsite/tpl`). Notice also that
templates are rendered in the context of the template object so we were able to access
template methods via `$this`.

That ends our quick tour. As you can see, base-jump is a lightweight framework that strives
to keep out of your way as much as possible, allowing the use of PHP as normal while employing
a few simple conventions to make your life easier. Strictly speaking it's not an MVC
framework, but the following parallels could be drawn:

  * __Model:__ all your application libraries and classes. These will typically
    live somewhere inside `_offsite/include/lib`.
  * __View:__ the contents of all the `**/tpl` directories.
  * __Controller:__ the scripts a user accesses directly via the browser (such as
    `www/index.php` from the quickstart) correspond to single controller actions.
    There is currently no equivalent of controller classes such as those found in
    Rails.
