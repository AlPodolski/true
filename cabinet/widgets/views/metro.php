<?php

/* @var $metro array */

?>

<div class="city-list">

<?php foreach ($metro as $item) : ?>
    <a class="red-link" href="/metro-<?php echo $item['url']?>"><?php echo $item['value']?></a>
<?php endforeach; ?>

</div>
