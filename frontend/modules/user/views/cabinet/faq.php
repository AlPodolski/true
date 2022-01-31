<?php

/* @var $this \yii\web\View */

$this->title = 'Вопросы и ответы';

$this->params['breadcrumbs'][] = ['label' => 'Кабинет', 'url' => '/cabinet'];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="container">
    <div class="row">
        <div class="col-12 margin-top-20">
            <h1><?php echo $this->title ?></h1>

            <div class="accordion accordion-custom" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left" type="button" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="open-plus">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.10714 4.10714H6.07143C5.97281 4.10714 5.89286 4.02719 5.89286 3.92857V0.892857C5.89286 0.39978 5.49308 0 5 0C4.50692 0 4.10714 0.39978 4.10714 0.892857V3.92857C4.10714 4.02719 4.02719 4.10714 3.92857 4.10714H0.892857C0.39978 4.10714 0 4.50692 0 5C0 5.49308 0.39978 5.89286 0.892857 5.89286H3.92857C4.02719 5.89286 4.10714 5.97281 4.10714 6.07143V9.10714C4.10714 9.60022 4.50692 10 5 10C5.49308 10 5.89286 9.60022 5.89286 9.10714V6.07143C5.89286 5.97281 5.97281 5.89286 6.07143 5.89286H9.10714C9.60022 5.89286 10 5.49308 10 5C10 4.50692 9.60022 4.10714 9.10714 4.10714Z"
                                              fill="#F74952"/>
                                        </svg>
                                    </span>
                                    <span class="close-minus">
                                       <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.31815 4.09814H0.681818C0.305453 4.09814 0 4.4036 0 4.77996V5.23448C0 5.61085 0.305453 5.9163 0.681818 5.9163H9.31815C9.69452 5.9163 9.99997 5.61085 9.99997 5.23448V4.77996C9.99997 4.4036 9.69452 4.09814 9.31815 4.09814Z" fill="#F74952"/>
</svg>

                                    </span>
                                Почему на сайте  опубликована моя  анкета?
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                         data-parent="#accordionExample">
                        <div class="card-body">
                            Данные  анкеты были взяты  из топовых сайтов данной тематики.
                            И недостающие данные  объединены и дополнены.
                            Это  помогает  пользователям понять,
                            где и по какой цене публикуется девушка.
                        </div>
                    </div>

                </div>
            </div>

            <div class="accordion accordion-custom margin-top-20" id="accordionExample1">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="open-plus">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.10714 4.10714H6.07143C5.97281 4.10714 5.89286 4.02719 5.89286 3.92857V0.892857C5.89286 0.39978 5.49308 0 5 0C4.50692 0 4.10714 0.39978 4.10714 0.892857V3.92857C4.10714 4.02719 4.02719 4.10714 3.92857 4.10714H0.892857C0.39978 4.10714 0 4.50692 0 5C0 5.49308 0.39978 5.89286 0.892857 5.89286H3.92857C4.02719 5.89286 4.10714 5.97281 4.10714 6.07143V9.10714C4.10714 9.60022 4.50692 10 5 10C5.49308 10 5.89286 9.60022 5.89286 9.10714V6.07143C5.89286 5.97281 5.97281 5.89286 6.07143 5.89286H9.10714C9.60022 5.89286 10 5.49308 10 5C10 4.50692 9.60022 4.10714 9.10714 4.10714Z"
                                              fill="#F74952"/>
                                        </svg>
                                    </span>
                                    <span class="close-minus">
                                       <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.31815 4.09814H0.681818C0.305453 4.09814 0 4.4036 0 4.77996V5.23448C0 5.61085 0.305453 5.9163 0.681818 5.9163H9.31815C9.69452 5.9163 9.99997 5.61085 9.99997 5.23448V4.77996C9.99997 4.4036 9.69452 4.09814 9.31815 4.09814Z" fill="#F74952"/>
</svg>

                                    </span>
                                Как получить доступ к администрированию анкеты или   удалить ее?
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne1" class="collapse " aria-labelledby="headingOne"
                         data-parent="#accordionExample1">
                        <div class="card-body">
                            Для этого нужно зарегистрироваться подтвердить свой номер и карточки с
                            данным номером автоматически привяжутся к вашему аккаунту.
                            Если  этого не произошло автоматически, напишите  Администрации
                        </div>
                    </div>

                </div>
            </div>

            <div class="accordion accordion-custom margin-top-20" id="accordionExample2">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="open-plus">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.10714 4.10714H6.07143C5.97281 4.10714 5.89286 4.02719 5.89286 3.92857V0.892857C5.89286 0.39978 5.49308 0 5 0C4.50692 0 4.10714 0.39978 4.10714 0.892857V3.92857C4.10714 4.02719 4.02719 4.10714 3.92857 4.10714H0.892857C0.39978 4.10714 0 4.50692 0 5C0 5.49308 0.39978 5.89286 0.892857 5.89286H3.92857C4.02719 5.89286 4.10714 5.97281 4.10714 6.07143V9.10714C4.10714 9.60022 4.50692 10 5 10C5.49308 10 5.89286 9.60022 5.89286 9.10714V6.07143C5.89286 5.97281 5.97281 5.89286 6.07143 5.89286H9.10714C9.60022 5.89286 10 5.49308 10 5C10 4.50692 9.60022 4.10714 9.10714 4.10714Z"
                                              fill="#F74952"/>
                                        </svg>
                                    </span>
                                    <span class="close-minus">
                                       <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.31815 4.09814H0.681818C0.305453 4.09814 0 4.4036 0 4.77996V5.23448C0 5.61085 0.305453 5.9163 0.681818 5.9163H9.31815C9.69452 5.9163 9.99997 5.61085 9.99997 5.23448V4.77996C9.99997 4.4036 9.69452 4.09814 9.31815 4.09814Z" fill="#F74952"/>
</svg>
                                    </span>
                                Сколько стоит публикация на сайте ?
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne2" class="collapse " aria-labelledby="headingOne"
                         data-parent="#accordionExample2">
                        <div class="card-body">
                            В зависимости от выбранного тарифа, от 1 рубля в час. Чем дороже тариф тем ваше анкете. Так же есть бесплатный тариф
                        </div>
                    </div>

                </div>
            </div>

            <div class="accordion accordion-custom margin-top-20" id="accordionExample3">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="open-plus">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.10714 4.10714H6.07143C5.97281 4.10714 5.89286 4.02719 5.89286 3.92857V0.892857C5.89286 0.39978 5.49308 0 5 0C4.50692 0 4.10714 0.39978 4.10714 0.892857V3.92857C4.10714 4.02719 4.02719 4.10714 3.92857 4.10714H0.892857C0.39978 4.10714 0 4.50692 0 5C0 5.49308 0.39978 5.89286 0.892857 5.89286H3.92857C4.02719 5.89286 4.10714 5.97281 4.10714 6.07143V9.10714C4.10714 9.60022 4.50692 10 5 10C5.49308 10 5.89286 9.60022 5.89286 9.10714V6.07143C5.89286 5.97281 5.97281 5.89286 6.07143 5.89286H9.10714C9.60022 5.89286 10 5.49308 10 5C10 4.50692 9.60022 4.10714 9.10714 4.10714Z"
                                              fill="#F74952"/>
                                        </svg>
                                    </span>
                                    <span class="close-minus">
                                       <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.31815 4.09814H0.681818C0.305453 4.09814 0 4.4036 0 4.77996V5.23448C0 5.61085 0.305453 5.9163 0.681818 5.9163H9.31815C9.69452 5.9163 9.99997 5.61085 9.99997 5.23448V4.77996C9.99997 4.4036 9.69452 4.09814 9.31815 4.09814Z" fill="#F74952"/>
</svg>
                                    </span>
                                Могу ли я опубликовать еще  анкеты? И какой их лимит?
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne3" class="collapse " aria-labelledby="headingOne"
                         data-parent="#accordionExample3">
                        <div class="card-body">
                            Да можете,  но публикация   второй  и последующих платна.  Лимита на  количество анкет нет.
                        </div>
                    </div>

                </div>
            </div>

            <div class="accordion accordion-custom margin-top-20" id="accordionExample4">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="open-plus">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.10714 4.10714H6.07143C5.97281 4.10714 5.89286 4.02719 5.89286 3.92857V0.892857C5.89286 0.39978 5.49308 0 5 0C4.50692 0 4.10714 0.39978 4.10714 0.892857V3.92857C4.10714 4.02719 4.02719 4.10714 3.92857 4.10714H0.892857C0.39978 4.10714 0 4.50692 0 5C0 5.49308 0.39978 5.89286 0.892857 5.89286H3.92857C4.02719 5.89286 4.10714 5.97281 4.10714 6.07143V9.10714C4.10714 9.60022 4.50692 10 5 10C5.49308 10 5.89286 9.60022 5.89286 9.10714V6.07143C5.89286 5.97281 5.97281 5.89286 6.07143 5.89286H9.10714C9.60022 5.89286 10 5.49308 10 5C10 4.50692 9.60022 4.10714 9.10714 4.10714Z"
                                              fill="#F74952"/>
                                        </svg>
                                    </span>
                                    <span class="close-minus">
                                       <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.31815 4.09814H0.681818C0.305453 4.09814 0 4.4036 0 4.77996V5.23448C0 5.61085 0.305453 5.9163 0.681818 5.9163H9.31815C9.69452 5.9163 9.99997 5.61085 9.99997 5.23448V4.77996C9.99997 4.4036 9.69452 4.09814 9.31815 4.09814Z" fill="#F74952"/>
</svg>
                                    </span>
                                Почему моя  анкета не попадает в топ?
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne4" class="collapse " aria-labelledby="headingOne"
                         data-parent="#accordionExample4">
                        <div class="card-body">
                            На нашем сайте уровень ротации анкеты  напрямую зависит от ее качества.
                            Если вы не видите свою анкету в топе,  начните
                            работать над повышением ее качества либо  поднимайте ее платно.
                        </div>
                    </div>

                </div>
            </div>

            <div class="accordion accordion-custom margin-top-20" id="accordionExample5">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseOne5" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="open-plus">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.10714 4.10714H6.07143C5.97281 4.10714 5.89286 4.02719 5.89286 3.92857V0.892857C5.89286 0.39978 5.49308 0 5 0C4.50692 0 4.10714 0.39978 4.10714 0.892857V3.92857C4.10714 4.02719 4.02719 4.10714 3.92857 4.10714H0.892857C0.39978 4.10714 0 4.50692 0 5C0 5.49308 0.39978 5.89286 0.892857 5.89286H3.92857C4.02719 5.89286 4.10714 5.97281 4.10714 6.07143V9.10714C4.10714 9.60022 4.50692 10 5 10C5.49308 10 5.89286 9.60022 5.89286 9.10714V6.07143C5.89286 5.97281 5.97281 5.89286 6.07143 5.89286H9.10714C9.60022 5.89286 10 5.49308 10 5C10 4.50692 9.60022 4.10714 9.10714 4.10714Z"
                                              fill="#F74952"/>
                                        </svg>
                                    </span>
                                    <span class="close-minus">
                                       <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.31815 4.09814H0.681818C0.305453 4.09814 0 4.4036 0 4.77996V5.23448C0 5.61085 0.305453 5.9163 0.681818 5.9163H9.31815C9.69452 5.9163 9.99997 5.61085 9.99997 5.23448V4.77996C9.99997 4.4036 9.69452 4.09814 9.31815 4.09814Z" fill="#F74952"/>
</svg>
                                    </span>
                                Как повысить  качество  анкеты?
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne5" class="collapse " aria-labelledby="headingOne"
                         data-parent="#accordionExample5">
                        <div class="card-body">
                            Качество  анкеты – это совокупность факторов важных для пользователя.
                            Советуем при заполнении анкеты обратить  внимание  на  следующие
                            параметры : Качество фото, Количество фото в галерее,
                            Загрузить проверочное фото, Добавить мини видео превью,
                            Максимально полно заполнить информацию (место встречи, услуги,  станции метро),
                            Просить  клиентов  оставлять отзывы (Отзывы уважаемых  клиентов  могут влиять
                            на ротацию анкеты  как в лучшую так и в худшую сторону ).
                        </div>
                    </div>

                </div>
            </div>

            <div class="accordion accordion-custom margin-top-20" id="accordionExample6">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseOne6" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="open-plus">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.10714 4.10714H6.07143C5.97281 4.10714 5.89286 4.02719 5.89286 3.92857V0.892857C5.89286 0.39978 5.49308 0 5 0C4.50692 0 4.10714 0.39978 4.10714 0.892857V3.92857C4.10714 4.02719 4.02719 4.10714 3.92857 4.10714H0.892857C0.39978 4.10714 0 4.50692 0 5C0 5.49308 0.39978 5.89286 0.892857 5.89286H3.92857C4.02719 5.89286 4.10714 5.97281 4.10714 6.07143V9.10714C4.10714 9.60022 4.50692 10 5 10C5.49308 10 5.89286 9.60022 5.89286 9.10714V6.07143C5.89286 5.97281 5.97281 5.89286 6.07143 5.89286H9.10714C9.60022 5.89286 10 5.49308 10 5C10 4.50692 9.60022 4.10714 9.10714 4.10714Z"
                                              fill="#F74952"/>
                                        </svg>
                                    </span>
                                    <span class="close-minus">
                                       <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.31815 4.09814H0.681818C0.305453 4.09814 0 4.4036 0 4.77996V5.23448C0 5.61085 0.305453 5.9163 0.681818 5.9163H9.31815C9.69452 5.9163 9.99997 5.61085 9.99997 5.23448V4.77996C9.99997 4.4036 9.69452 4.09814 9.31815 4.09814Z" fill="#F74952"/>
</svg>
                                    </span>
                                Для  чего нужен рейтинг на сайте ?
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne6" class="collapse " aria-labelledby="headingOne"
                         data-parent="#accordionExample6">
                        <div class="card-body">
                            Рейтинг  пользователей на сайте можно разделить на  2 типа  рейтинг
                            анкеты индивидуалки и  рейтинг пользователей  (мужчин клиентов ).
                            Рейтинг карточки индивидуалки  это числовое значение отражающее
                            общее  качество анкеты,  оно округлено до десятых
                            и указывается непосредственно на  карточке.
                            Рейтинг пользователей  - отражает уровень доверия  нашего ресурса  к пользователям  сайта.
                            Чем выше уровень тем больше мы прислушиваемся у их комментариям отзывам и обзорам.
                        </div>
                    </div>

                </div>
            </div>

            <div class="accordion accordion-custom margin-top-20" id="accordionExample7">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseOne7" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="open-plus">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.10714 4.10714H6.07143C5.97281 4.10714 5.89286 4.02719 5.89286 3.92857V0.892857C5.89286 0.39978 5.49308 0 5 0C4.50692 0 4.10714 0.39978 4.10714 0.892857V3.92857C4.10714 4.02719 4.02719 4.10714 3.92857 4.10714H0.892857C0.39978 4.10714 0 4.50692 0 5C0 5.49308 0.39978 5.89286 0.892857 5.89286H3.92857C4.02719 5.89286 4.10714 5.97281 4.10714 6.07143V9.10714C4.10714 9.60022 4.50692 10 5 10C5.49308 10 5.89286 9.60022 5.89286 9.10714V6.07143C5.89286 5.97281 5.97281 5.89286 6.07143 5.89286H9.10714C9.60022 5.89286 10 5.49308 10 5C10 4.50692 9.60022 4.10714 9.10714 4.10714Z"
                                              fill="#F74952"/>
                                        </svg>
                                    </span>
                                    <span class="close-minus">
                                       <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.31815 4.09814H0.681818C0.305453 4.09814 0 4.4036 0 4.77996V5.23448C0 5.61085 0.305453 5.9163 0.681818 5.9163H9.31815C9.69452 5.9163 9.99997 5.61085 9.99997 5.23448V4.77996C9.99997 4.4036 9.69452 4.09814 9.31815 4.09814Z" fill="#F74952"/>
</svg>
                                    </span>
                               Публикация моей анкеты происходит только на sex-true.com  ?
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne7" class="collapse " aria-labelledby="headingOne"
                         data-parent="#accordionExample7">
                        <div class="card-body">
                            На данный момент да  но в  перспективе развития  наш телеграмм бот который позволит отойти
                            от практики  обычных сайтов (которые так часто попадают в блок лист РКН,
                            и турбулентность поисковых систем)
                        </div>
                    </div>

                </div>
            </div>

            <div class="accordion accordion-custom margin-top-20" id="accordionExample8">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseOne8" aria-expanded="true" aria-controls="collapseOne">
                                    <span class="open-plus">
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.10714 4.10714H6.07143C5.97281 4.10714 5.89286 4.02719 5.89286 3.92857V0.892857C5.89286 0.39978 5.49308 0 5 0C4.50692 0 4.10714 0.39978 4.10714 0.892857V3.92857C4.10714 4.02719 4.02719 4.10714 3.92857 4.10714H0.892857C0.39978 4.10714 0 4.50692 0 5C0 5.49308 0.39978 5.89286 0.892857 5.89286H3.92857C4.02719 5.89286 4.10714 5.97281 4.10714 6.07143V9.10714C4.10714 9.60022 4.50692 10 5 10C5.49308 10 5.89286 9.60022 5.89286 9.10714V6.07143C5.89286 5.97281 5.97281 5.89286 6.07143 5.89286H9.10714C9.60022 5.89286 10 5.49308 10 5C10 4.50692 9.60022 4.10714 9.10714 4.10714Z"
                                              fill="#F74952"/>
                                        </svg>
                                    </span>
                                    <span class="close-minus">
                                       <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9.31815 4.09814H0.681818C0.305453 4.09814 0 4.4036 0 4.77996V5.23448C0 5.61085 0.305453 5.9163 0.681818 5.9163H9.31815C9.69452 5.9163 9.99997 5.61085 9.99997 5.23448V4.77996C9.99997 4.4036 9.69452 4.09814 9.31815 4.09814Z" fill="#F74952"/>
</svg>
                                    </span>
                                Что такое Черный список для чего он нужен?
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne8" class="collapse " aria-labelledby="headingOne"
                         data-parent="#accordionExample8">
                        <div class="card-body">
                            Черный список это некая  система  обратного отзыва о  своих  клиентах.
                            Пополняя ее своими отзывами о клиентах которые вас посещали,
                            вы  даете  шанс не нарваться вашим  коллегам  на хамов,  разводил и прочих
                            нежелательных посетителей.  Данный функционал полностью  бесплатен и
                            пока находится в этапе  наполнения  и тестирования.
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>