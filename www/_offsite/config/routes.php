<?php
$route->get('#^/(foo|bar)#', function() {
    throw new Exception;
});

$route->rescue('Exception', function() {
    echo "Caught it!";
});
?>