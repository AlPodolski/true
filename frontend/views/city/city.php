<?php
/* @var $citys array */
/* @var $domain string */
/* @var $protocol string */

echo '<ul class="city-list">';

foreach ($citys as $city){

    echo '<li> <a class="red-link" href="'.$protocol.'://'.$city['url'].'.'.$domain.'">'.$city['city'].'</a> </li>';

}

echo '</ul>';