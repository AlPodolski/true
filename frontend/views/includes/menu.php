<div class="menu">
    <div class="icon-close">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(.clip0)">
                <path d="M32 3.77081L28.2292 0L16 12.2291L3.77081 0L0 3.77081L12.2291 16L0 28.2292L3.77081 32L16 19.7709L28.2291 32L31.9999 28.2292L19.7709 16L32 3.77081Z"
                      fill="#F74952"/>
            </g>
            <defs>
                <clipPath class="clip0">
                    <rect width="32" height="32" fill="white"/>
                </clipPath>
            </defs>
        </svg>
    </div>
    <ul class="nav">

        <?php if (Yii::$app->user->isGuest) : ?>
            <li onclick="get_user_menu()" class="nav-item small-red-text"><a class="small-red-text" >Войти</a></li>
        <?php else : ?>
            <li class="nav-item small-red-text"><a class="small-red-text" href="/cabinet">Кабинет</a></li>
        <?php endif; ?>

        <?php if (Yii::$app->requestedParams['city'] == 'moskva') : ?>

            <li class="nav-item" data-type="metro" onclick="get_data(this)">
                <a>
                    Выбрать метро
                </a>
            </li>
            <li class="nav-item" data-type="rayon" onclick="get_data(this)">
                <a>
                    Выбрать район
                </a>
            </li>

        <?php endif; ?>

        <li class="nav-item" data-type="cena" onclick="get_data(this)">
            <a>
                Выбрать цену
            </a>
        </li>
        <li class="nav-item" data-type="vremya" onclick="get_data(this)">
            <a>
                Выбрать время
            </a>
        </li>
        <li class="nav-item" data-type="rost" onclick="get_data(this)">
            <a>
                Выбрать рост
            </a>
        </li>
        <li class="nav-item" data-type="ves" onclick="get_data(this)">
            <a>
                Выбрать вес
            </a>
        </li>
        <li class="nav-item" data-type="vozrast" onclick="get_data(this)">
            <a>
                Выбрать возраст
            </a>
        </li>
        <li class="nav-item" data-type="nacionalnost" onclick="get_data(this)">
            <a>
                Выбрать национальность
            </a>
        </li>
        <li class="nav-item" data-type="mesto" onclick="get_data(this)">
            <a>
                Выбрать место встречи
            </a>
        </li>
        <li class="nav-item" data-type="usluga" onclick="get_data(this)">
            <a>
                Выбрать услугу
            </a>
        </li>
        <li class="nav-item"><a href="/proverennye">Проверенные</a></li>
        <li class="nav-item"><a href="/elitnye-prostitutki">Элитные</a></li>
        <li class="nav-item"><a href="/favorite/list">Избранное</a></li>
        <li class="nav-item"><a href="/video">С Видео</a></li>
        <li class="nav-item"><a href="/mesto-viezd">На выезд</a></li>
        <li class="nav-item"><a href="/favorite/list">Избранное</a></li>
        <li class="nav-item"><a class="small-red-text" href="/novie">Новые анкеты</a></li>
        <li class="nav-item"><a class="small-red-text" href="/prostitutki-s-selfi">Проститутки с селфи</a></li>
        <li class="nav-item"><a class="small-red-text" href="/photo-prostitutok">Фото проституток</a></li>
        <li class="nav-item"><a class="small-red-text" href="/prostitutki-s-otzyvami">Проститутки с отзывами</a></li>

        <?php if (Yii::$app->requestedParams['city'] == 'moskva') : ?>
            <li class="nav-item"><a href="/advert">Объявления</a></li>
            <li class="nav-item"><a href="/pol-muzhskoj">Жиголо</a></li>
            <li class="nav-item"><a href="/pol-trans">Трансы</a></li>
            <li class="nav-item"><a rel=”nofollow” href="https://t.me/indi_tut">Мы в телеграм</a></li>
            <li class="nav-item"><a class="small-red-text" href="/salon">Интим салоны</a></li>
            <li class="nav-item"><a class="small-red-text d-none" href="/map">Интим карта</a></li>
        <?php endif; ?>

        <li class="nav-item" onclick="get_claim_modal()"><a>Обратная связь</a></li>

    </ul>
</div>