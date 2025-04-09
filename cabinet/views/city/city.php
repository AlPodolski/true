<?php
/* @var $citys array */
/* @var $domain string */
/* @var $protocol string */

echo '<ul class="city-list">';

foreach ($citys as $city){

    $cityUrl = $city['url'];

    if ($city['actual_city']) $cityUrl = $city['actual_city'];

    echo '<li> <a class="red-link" href="'.$protocol.'://'.$cityUrl.'.'.$domain.'">'.$city['city'].'</a> </li>';

}

echo '</ul>';