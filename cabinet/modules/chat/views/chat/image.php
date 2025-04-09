<div class="wall-tem right-message">

    <div class="post_header">

        <div class="post_header_info">

            <div class="post-text">

                <?php
                    if (strpos($img, '.pdf')) echo \yii\helpers\Html::a('Смотреть', $img);
                    else  echo \yii\helpers\Html::img( $img);
                ?>

            </div>

        </div>

    </div>

    <div style="clear: both">
    </div>

</div>
