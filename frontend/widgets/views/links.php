<?php

/* @var $links array */

?>

<?php if ($links) : ?>

    <div class="row">
        <div class="filter__fast filter-fast" data-simplebar data-simplebar-auto-hide="false">
            <div class="filter-fast__title">
                Быстрый поиск:
            </div>
            <ul class="filter-fast__list">

                <?php foreach ($links as $link) { ?>

                    <?php echo '<li>'; ?>

                    <?php echo \yii\helpers\Html::a($link['text'], $link['link']) ?>

                    <?php echo '</li>' ?>

                <?php } ?>

            </ul>
        </div>
    </div>

<?php endif; ?>