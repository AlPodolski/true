<?php
/* @var $host string */
header('Content-Type: text/plain; charset=UTF-8');
?>
    User-agent: *
    Disallow: *request-password-reset*
    Disallow: *signup*
    Disallow: *resend-verification-email*
    Disallow: /find*
    Host: https://<?php echo $host.PHP_EOL ?>
    Sitemap: https://<?php echo $host ?>/sitemap.xml
<?php exit() ?>