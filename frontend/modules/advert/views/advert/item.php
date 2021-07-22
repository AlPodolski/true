<?php
/* @var $advert Advert */
/* @var $isCabinet Advert */

use frontend\modules\advert\models\Advert;
use frontend\widgets\PhotoWidget;

?>

<?php if (isset($isCabinet) and $isCabinet) : ?>

    <?php $url = '/cabinet/advert/'.$advert['id'] ?>

<?php else : ?>

    <?php $url = '/forum/'.$advert['id'] ?>

<?php endif; ?>

<div class="row advert-item">

        <?php if ($advert['userRelations']) : ?>

            <div class="col-12">
                <div class="row user-info">
                    <div class="col-3 col-sm-2 col-md-1 ">
                        <div class="dialog-photo">
                            <a class="name">
                                <?php echo PhotoWidget::widget([
                                    'path' => $advert['userRelations']['avatar']['file'],
                                    'size' => '59',
                                    'options' => [
                                        'class' => 'img',
                                        'loading' => 'lazy',
                                        'alt' => $advert['userRelations']['username'],
                                    ],
                                ]); ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-9 col-sm-10 col-md-11">
                        <div class="name">
                            <a class="name red-text">
                                <?php echo  $advert['userRelations']['username'] ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <div class="col-12 advert-item-text">
            <div >

                <a class="name" href="<?php echo $url ?>">
                    <?php echo $advert->title; ?>
                </a>
            </div>
            <div class="text-ab">

                <a href="<?php echo $url ?>">
                    <?php echo $advert->text; ?>
                </a>

                <div class="comments-btn" >
                    <a href="<?php echo $url ?>">
                        Комментарии
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.7875 1.3477H3.19302C1.77166 1.3477 0.615234 2.5039 0.615234 3.92548V12.245C0.615234 13.6634 1.76662 14.8177 3.18386 14.8228V18.5981L8.60939 14.8228H16.7875C18.2088 14.8228 19.3652 13.6663 19.3652 12.245V3.92548C19.3652 2.5039 18.2088 1.3477 16.7875 1.3477ZM18.2666 12.245C18.2666 13.0605 17.6031 13.7241 16.7875 13.7241H8.26469L4.28249 16.4952V13.7241H3.19302C2.3774 13.7241 1.71387 13.0605 1.71387 12.245V3.92548C1.71387 3.10975 2.3774 2.44633 3.19302 2.44633H16.7875C17.6031 2.44633 18.2666 3.10975 18.2666 3.92548V12.245Z" fill="#F74952"/>
                            <path d="M5.63281 5.22964H14.3461V6.32828H5.63281V5.22964Z" fill="#F74952"/>
                            <path d="M5.63281 7.57339H14.3461V8.67203H5.63281V7.57339Z" fill="#F74952"/>
                            <path d="M5.63281 9.91714H14.3461V11.0158H5.63281V9.91714Z" fill="#F74952"/>
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </div>

