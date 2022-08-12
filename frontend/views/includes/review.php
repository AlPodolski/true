<?php
/* @var $item \frontend\modules\user\models\Review */

use frontend\widgets\PhotoWidget;

?>

<div class="review-block">

    <div class="author-img">

        <?php if (isset($item['author']['avatar']['file']) and $item['author']['avatar']['file']) : ?>
            <?php echo PhotoWidget::widget([
                'path' => $item['author']['avatar']['file'],
                'size' => '59',
                'options' => [
                    'class' => 'img user-img',
                    'loading' => 'lazy',
                    'alt' => $item['author']['username'],
                ],
            ]); ?>
        <?php else : ?>

            <div class="no-photo">
                <?php

                echo $item['name'][0] . $item['name'][1] ?? $item['author']['username'][0] . $item['author']['username'][1];

                ?>
            </div>

        <?php endif; ?>

    </div>

    <div class="author-name-wrap">
        <div class="author-name">
            <?php echo $item['name'] ?? $item['author']['username'] ?>

            <?php if (isset($item['author']['id'])) : ?>

                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.0943 4.77885C10.308 4.99248 10.308 5.33876 10.0943 5.55228L6.42557 9.22115C6.21194 9.43466 5.86577 9.43466 5.65215 9.22115L3.90567 7.47456C3.69205 7.26105 3.69205 6.91476 3.90567 6.70125C4.11919 6.48763 4.46547 6.48763 4.67899 6.70125L6.0388 8.06107L9.32091 4.77885C9.53453 4.56534 9.88081 4.56534 10.0943 4.77885ZM14 7C14 10.8692 10.8687 14 7 14C3.13075 14 0 10.8687 0 7C0 3.13075 3.13129 0 7 0C10.8692 0 14 3.13129 14 7ZM12.9062 7C12.9062 3.73531 10.2643 1.09375 7 1.09375C3.73531 1.09375 1.09375 3.73573 1.09375 7C1.09375 10.2647 3.73573 12.9062 7 12.9062C10.2647 12.9062 12.9062 10.2643 12.9062 7Z"
                          fill="#31DA92"/>
                </svg>

            <?php endif; ?>
        </div>

        <?php if (isset($item['author']['id'])) : ?>

            <div class="profile-link">
                <a href="/user/<?php echo $item['author']['id'] ?>">Посмотреть профиль</a>
            </div>

        <?php endif; ?>
    </div>


    <div class="review-text">
        <?php echo $item['text'] ?>
    </div>

</div>