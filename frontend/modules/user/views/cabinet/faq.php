<?php

/* @var $this \yii\web\View */

$this->title = 'Вопросы и ответы';

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
                                Как добавить в черный список?
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                         data-parent="#accordionExample">
                        <div class="card-body">
                            В меню «Электронные кошельки» выберите систему электронных денег,
                            кошелек которой вы хотите пополнить.
                            Введите запрашиваемые реквизиты электронного кошелька.
                            Выберите способ оплаты – наличными или по карте – и,
                            следуя подсказкам, завершите операцию.
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
                                Как добавить в черный список?
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne1" class="collapse " aria-labelledby="headingOne"
                         data-parent="#accordionExample1">
                        <div class="card-body">
                            В меню «Электронные кошельки» выберите систему электронных денег,
                            кошелек которой вы хотите пополнить.
                            Введите запрашиваемые реквизиты электронного кошелька.
                            Выберите способ оплаты – наличными или по карте – и,
                            следуя подсказкам, завершите операцию.
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>