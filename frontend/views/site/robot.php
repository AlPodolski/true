<?php
/* @var $host string */
/* @var $city string */

header('Content-Type: text/plain; charset=UTF-8');

if (strstr(Yii::$app->request->serverName, 'sex-key') or !$city) : ?>
    User-agent: *
    Disallow: /
    <?php exit() ?>
<?php else : ?>
    User-agent: *
    Disallow: *request-password-reset*
    Disallow: *signup*
    Disallow: *resend-verification-email*
    Disallow: /rost-hudye*
    Disallow: /rost-tolstye*
    Disallow: /find*
    Disallow: /ehlitnye-prostitutki
    Disallow: /favorite/list
    <?php echo 'Disallow: /forum' .PHP_EOL ?>
    Allow: /forum/*
    <?php if ($city != 'moskva') echo 'Disallow: /forum/*' .PHP_EOL ?>
    Host: https://<?php echo $host.PHP_EOL ?>
    Sitemap: https://<?php echo $host ?>/sitemap.xml
    <?php exit() ?>

<?php endif;
