<?php

/* @var $data object */

if ($data) : ?>



    <?php if ($data->review) : ?>

        <div class="big-red-text">Отзывы о номере <span class="small-text blue-text"><?php echo $data->phone?></span></div>

        <?php foreach ($data->review as $item) : ?>

            <div class="small-text">Оценка : <?php echo $item->clientCategoryId->parentCategory->value ?> (<?php echo $item->clientCategoryId->value ?>) </div>
            <?php if ($item->review) : ?>

                <div class="small-text">Комментарий к отзыву : <?php echo $item->review ?></div>

            <?php endif; ?>
            <div class="event-date">Создан : <?php echo date('Y-m-d H:i', $item->created_at) ?> </div>
            <hr>

        <?php endforeach; ?>

    <?php else : ?>

        <div class="big-red-text">Пока нет отзывов</div>

    <?php endif; ?>

<?php else : ?>

    <div class="big-red-text">Пока нет информации</div>

<?php endif; ?>