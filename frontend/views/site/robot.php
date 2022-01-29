<?php
/* @var $host string */
/* @var $city string */

header('Content-Type: text/plain; charset=UTF-8');
?>
    User-agent: *
    Disallow: *request-password-reset*
    Disallow: *signup*
    Disallow: *resend-verification-email*
    Disallow: /rost-hudye*
    Disallow: /rost-tolstye*
    Disallow: /find*
    <?php if ($city != 'moskva') echo 'Disallow: /forum' .PHP_EOL ?>
    <?php if ($city != 'moskva') echo 'Disallow: /forum/*' .PHP_EOL ?>
    Host: https://<?php echo $host.PHP_EOL ?>
    Sitemap: https://<?php echo $host ?>/sitemap.xml
<?php exit() ?>