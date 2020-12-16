<?php
/* @var $host string */
header('Content-Type: text/plain; charset=UTF-8');
?>
    User-agent: *
    Host: https://<?php echo $host ?>
<?php exit() ?>