<?php
return [
    'adminEmail' => 'info@sex-true.com',
    'supportEmail' => 'info@sex-true.com',
    'senderEmail' => 'info@sex-true.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'photo_path' => '/uploads/',
    'review_cache_key' => 'review',
    'redis_view_phone_count_key' => 'view_phone_count',//Счетчик кликов по телефону
    'redis_post_listing_view_count_key' => 'view_post_listing_count', //Счетчик показов анкеты на листинге
    'redis_post_single_view_count_key' => 'view_post_single_count', //Счетчик просмотров детальной страницы анкеты
    'telegram_url' => 'https://web.telegram.org/#/im?p=@', // ссылка на телегу
    'returned_for_revision_text' => 'Анкету :name вернули на доработку ',
    'anket_check_text' => 'Анкета :name одобрена и поставлена на публикацию',
    'obm-id-pref' => 'true', //префикс для ид платежа в обменке ,
    'fast_link_key_cache_pref' => 'fast_link',
    'user_first_post_cache_key' => 'user_first_post',
    'hour_pay_sum' => 3,
];
