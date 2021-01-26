<?php
/* @var $host string */
header('Content-Type: text/plain; charset=UTF-8');
?>
    User-agent: *
    Disallow: /find*
    Host: https://<?php echo $host ?>
<?php exit() ?>