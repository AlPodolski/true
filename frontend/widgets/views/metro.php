<?php

/* @var $metro array */

?>

<ul class="city-list">

<?php foreach ($metro as $item) : ?>
    <li><a class="red-link" href="/metro-<?php echo $item['url']?>"><?php echo $item['value']?></a></li>
<?php endforeach; ?>

</ul>
