<?php

/* @var $comment array */

use frontend\widgets\PhotoWidget;

?>

<div class="comment-item">

    <div class="post_header">

        <div class="row">
            <div class="col-md-1">
                <a class="post_image dialog-photo" >

                    <?php echo PhotoWidget::widget([
                        'path' => $comment['author']['avatar']['file'],
                        'size' => '59',
                        'options' => [
                            'class' => 'img',
                            'loading' => 'lazy',
                            'alt' => $comment['author']['username'],
                        ],
                    ]); ?>

                </a>
            </div>
            <div class="col-md-11">
                <div class="post_header_info">

                    <a  class="author red-text">
                        <?php echo $comment['author']['username'] ?>

                    </a>

                    <span class="rel_date">
                                <?php

                                $day = time() - $comment['created_at'];

                                $day = (intdiv($day, 3600 * 24));

                                ?>

                        <?php echo $day ?> <?php echo getNumEnding($day, ['день','дня', 'дней']); ?>

                            назад

                            </span>

                    <div class="post-text post-text-related text-ab">
                        <?php echo $comment['text'] ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div style="clear: both">
    </div>


</div>

