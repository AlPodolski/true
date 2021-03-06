<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%metro}}`.
 */
class m201103_114410_create_metro_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%metro}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(50),
            'value' => $this->string(50),
            'value2' => $this->string(50),
            'value3' => $this->string(50),
            'city_id' => $this->smallInteger(2),
        ]);

        $this->execute(
            "
INSERT INTO `metro` ( `url`, `value`, `city_id`, `value2`, `value3`) VALUES
( 'akademicheskaya', 'Академическая', 1, 'Академической', NULL),
( 'alekseevskaya', 'Алексеевская', 1, 'Алексеевской', NULL),
( 'aleksandrovskiy-sad', 'Александровский сад', 1, 'Александровском саду', NULL),
( 'arbatskaya', 'Арбатская', 1, 'Арбатской', NULL),
( 'borovickaya', 'Боровицкая', 1, 'Боровицкой', NULL),
( 'smolenskaya', 'Смоленская', 1, 'Смоленской', NULL),
( 'aeroport', 'Аэропорт', 1, 'Аэропорте', NULL),
( 'dinamo', 'Динамо', 1, 'Динамо', NULL),
( 'petrovskiy-park', 'Петровский парк', 1, 'Петровском парке', NULL),
( 'sokol', 'Сокол', 1, 'Сокол', NULL),
( 'babushkinskaya', 'Бабушкинская', 1, 'Бабушкинской', NULL),
( 'baumanskaya', 'Бауманская', 1, 'Бауманской', NULL),
( 'kurskaya', 'Курская', 1, 'Курской', NULL),
( 'chistye-prudy', 'Чистые пруды', 1, 'Чистых прудах', NULL),
( 'chkalovskaya', 'Чкаловская', 1, 'Чкаловской', NULL),
( 'verhnie-lihobory', 'Верхние Лихоборы', 1, 'Верхних Лихоборах', NULL),
( 'okrughnaya', 'Окружная', 1, 'Окружной', NULL),
( 'seligerskaya', 'Селигерская', 1, 'Селигерской', NULL),
( 'altufyevo', 'Алтуфьево', 1, 'Алтуфьево', NULL),
( 'bibirevo', 'Бибирево', 1, 'Бибирево', NULL),
( 'belokamennaya', 'Белокаменная', 1, 'Белокаменной', NULL),
( 'bulyvar-rokossovskogo', 'Бульвар Рокоссовского', 1, 'Бульваре Рокоссовского', NULL),
( 'alma', 'Алма', 1, 'Алме', NULL),
( 'borisovo', 'Борисово', 1, 'Борисово', NULL),
( 'bulyvar-dmitriya-donskogo', 'Бульвар Дмитрия Донского', 1, 'Бульваре Дмитрия Донского', NULL),
( 'ulica-starokachalovskaya', 'Улица Старокачаловская', 1, 'Улице Старокачаловская', NULL),
( 'bulyvar-admirala-ushakova', 'Бульвар адмирала Ушакова', 1, 'Бульваре адмирала Ушакова', NULL),
( 'buninskaya-alleya', 'Бунинская Аллея', 1, 'Бунинской Аллее', NULL),
( 'ulica-gorchakova', 'Улица Горчакова', 1, 'Улице Горчакова', NULL),
( 'ulica-skobelevskaya', 'Улица Скобелевская', 1, 'Улице Скобелевская', NULL),
( 'butyrskaya', 'Бутырская', 1, 'Бутырской', NULL),
( 'savelovskaya', 'Савеловская', 1, 'Савеловской', NULL),
( 'ulica-milashenkova', 'Улица Милашенкова', 1, 'Улице Милашенкова', NULL),
( 'fonvizinskaya', 'Фонвизинская', 1, 'Фонвизинской', NULL),
( 'baltiyskaya', 'Балтийская', 1, 'Балтийской', NULL),
( 'voykovskaya', 'Войковская', 1, 'Войковской', NULL),
( 'vyhino', 'Выхино', 1, 'Выхино', NULL),
( 'ghulebino', 'Жулебино', 1, 'Жулебино', NULL),
( 'kotelyniki', 'Котельники', 1, 'Котельниках', NULL),
( 'lermontovskiy-prospekt', 'Лермонтовский проспект', 1, 'Лермонтовском проспекте', NULL),
( 'ploschady-gagarina', 'Площадь Гагарина', 1, 'Площади Гагарина', NULL),
( 'universitet', 'Университет', 1, 'Университете', NULL),
( 'vodnyy-stadion', 'Водный стадион', 1, 'Водном стадионе', NULL),
( 'lokomotiv', 'Локомотив', 1, 'Локомотиве', NULL),
( 'avtozavodskaya', 'Автозаводская', 1, 'Автозаводской', NULL),
( 'tehnopark', 'Технопарк', 1, 'Технопарке', NULL),
( 'tulyskaya', 'Тульская', 1, 'Тульской', NULL),
( 'krymskaya', 'Крымская', 1, 'Крымской', NULL),
( 'leninskiy-prospekt', 'Ленинский проспект', 1, 'Ленинском проспекте', NULL),
( 'shabolovskaya', 'Шаболовская', 1, 'Шаболовской', NULL),
( 'kievskaya', 'Киевская', 1, 'Киевской', NULL),
( 'kutuzovskaya', 'Кутузовская', 1, 'Кутузовской', NULL),
( 'minskaya', 'Минская', 1, 'Минской', NULL),
( 'park-pobedy', 'Парк Победы', 1, 'Парке Победы', NULL),
( 'studencheskaya', 'Студенческая', 1, 'Студенческой', NULL),
( 'dobryninskaya', 'Добрынинская', 1, 'Добрынинской', NULL),
( 'novokuzneckaya', 'Новокузнецкая', 1, 'Новокузнецкой', NULL),
( 'paveleckaya', 'Павелецкая', 1, 'Павелецкой', NULL),
( 'serpuhovskaya', 'Серпуховская', 1, 'Серпуховской', NULL),
( 'tretyyakovskaya', 'Третьяковская', 1, 'Третьяковской', NULL),
( 'kahovskaya', 'Каховская', 1, 'Каховской', NULL),
( 'nahimovskiy-prospekt', 'Нахимовский Проспект', 1, 'Нахимовском Проспекте', NULL),
( 'sevastopolyskaya', 'Севастопольская', 1, 'Севастопольской', NULL),
( 'zyablikovo', 'Зябликово', 1, 'Зябликово', NULL),
( 'krasnogvardeyskaya', 'Красногвардейская', 1, 'Красногвардейской', NULL),
( 'shipilovskaya', 'Шипиловская', 1, 'Шипиловской', NULL),
( 'izmaylovo', 'Измайлово', 1, 'Измайлово', NULL),
( 'izmaylovskaya', 'Измайловская', 1, 'Измайловской', NULL),
( 'partizanskaya', 'Партизанская', 1, 'Партизанской', NULL),
( 'pervomayskaya', 'Первомайская', 1, 'Первомайской', NULL),
( 'sokolinaya-gora', 'Соколиная Гора', 1, 'Соколиной Горе', NULL),
( 'schelkovskaya', 'Щелковская', 1, 'Щелковской', NULL),
( 'belyaevo', 'Беляево', 1, 'Беляево', NULL),
( 'konykovo', 'Коньково', 1, 'Коньково', NULL),
( 'koptevo', 'Коптево', 1, 'Коптево', NULL),
( 'lihobory', 'Лихоборы', 1, 'Лихоборах', NULL),
( 'myakinino', 'Мякинино', 1, 'Мякинино', NULL),
( 'komsomolyskaya', 'Комсомольская', 1, 'Комсомольской', NULL),
( 'krasnoselyskaya', 'Красносельская', 1, 'Красносельской', NULL),
( 'krasnye-vorota', 'Красные ворота', 1, 'Красных воротах', NULL),
( 'sretenskiy-bulyvar', 'Сретенский бульвар', 1, 'Сретенском бульваре', NULL),
( 'turgenevskaya', 'Тургеневская', 1, 'Тургеневской', NULL),
( 'krylatskoe', 'Крылатское', 1, 'Крылатской', NULL),
( 'kuzyminki', 'Кузьминки', 1, 'Кузьминках', NULL),
( 'kropotkinskaya', 'Кропоткинская', 1, 'Кропоткинской', NULL),
( 'kuncevskaya', 'Кунцевская', 1, 'Кунцевской', NULL),
( 'molodeghnaya', 'Молодежная', 1, 'Молодежной', NULL),
( 'rechnoy-vokzal', 'Речной вокзал', 1, 'Речном вокзале', NULL),
( 'aviamotornaya', 'Авиамоторная', 1, 'Авиамоторной', NULL),
( 'lyublino', 'Люблино', 1, 'Люблино', NULL),
( 'maryina-roscha', 'Марьина роща', 1, 'Марьиной роще', NULL),
( 'bratislavskaya', 'Братиславская', 1, 'Братиславской', NULL),
( 'maryino', 'Марьино', 1, 'Марьино', NULL),
( 'medvedkovo', 'Медведково', 1, 'Медведково', NULL),
( 'kuzneckiy-most', 'Кузнецкий мост', 1, 'Кузнецком мосту', NULL),
( 'prospekt-mira', 'Проспект Мира', 1, 'Проспекте Мира', NULL),
( 'righskaya', 'Рижская', 1, 'Рижской', NULL),
( 'suharevskaya', 'Сухаревская', 1, 'Сухаревской', NULL),
( 'trubnaya', 'Трубная', 1, 'Трубной', NULL),
( 'volokolamskaya', 'Волоколамская', 1, 'Волоколамской', NULL),
( 'mitino', 'Митино', 1, 'Митино', NULL),
( 'pyatnickoe-shosse', 'Пятницкое шоссе', 1, 'Пятницком шоссе', NULL),
( 'rumyancevo', 'Румянцево', 1, 'Румянцево', NULL),
( 'salaryevo', 'Саларьево', 1, 'Саларьево', NULL),
( 'kashirskaya', 'Каширская', 1, 'Каширской', NULL),
( 'kolomenskaya', 'Коломенская', 1, 'Коломенской', NULL),
( 'varshavskaya', 'Варшавская', 1, 'Варшавской', NULL),
( 'verhnie-kotly', 'Верхние Котлы', 1, 'Верхних Котлах', NULL),
( 'nagatinskaya', 'Нагатинская', 1, 'Нагатинской', NULL),
( 'nagornaya', 'Нагорная', 1, 'Нагорной', NULL),
( 'nighegorodskaya', 'Нижегородская', 1, 'Нижегородской', NULL),
( 'novohohlovskaya', 'Новохохловская', 1, 'Новохохловской', NULL),
( 'novogireevo', 'Новогиреево', 1, 'Новогиреево', NULL),
( 'novokosino', 'Новокосино', 1, 'Новокосино', NULL),
( 'novye-cheremushki', 'Новые Черёмушки', 1, 'Новых Черёмушках', NULL),
( 'orehovo', 'Орехово', 1, 'Орехово', NULL),
( 'domodedovskaya', 'Домодедовская', 1, 'Домодедовской', NULL),
( 'vdnh', 'ВДНХ', 1, 'ВДНХ', NULL),
( 'vystavochnyy-centr', 'Выставочный центр', 1, 'Выставочном центре', NULL),
( 'telecentr', 'Телецентр', 1, 'Телецентре', NULL),
( 'ulica-akademika-koroleva', 'Улица Академика Королёва', 1, 'Улице Академика Королёва', NULL),
( 'ulica-sergeya-eyzenshteyna', 'Улица Сергея Эйзенштейна', 1, 'Улице Сергея Эйзенштейна', NULL),
( 'vladykino', 'Владыкино', 1, 'Владыкино', NULL),
( 'otradnoe', 'Отрадное', 1, 'Отрадном', NULL),
( 'andronovka', 'Андроновка', 1, 'Андроновке', NULL),
( 'perovo', 'Перово', 1, 'Перово', NULL),
( 'shosse-entuziastov', 'Шоссе Энтузиастов', 1, 'Шоссе Энтузиастов', NULL),
( 'pechatniki', 'Печатники', 1, 'Печатниках', NULL),
( 'ugreshskaya', 'Угрешская', 1, 'Угрешской', NULL),
( 'spartak', 'Спартак', 1, 'Спартаке', NULL),
( 'tushinskaya', 'Тушинская', 1, 'Тушинской', NULL),
( 'preobraghenskaya-ploschady', 'Преображенская площадь', 1, 'Преображенской площади', NULL),
( 'cherkizovskaya', 'Черкизовская', 1, 'Черкизовской', NULL),
( 'barrikadnaya', 'Баррикадная', 1, 'Баррикадной', NULL),
( 'vystavochnaya', 'Выставочная', 1, 'Выставочной', NULL),
( 'delovoy-centr', 'Деловой центр', 1, 'Деловом центре', NULL),
( 'krasnopresnenskaya', 'Краснопресненская', 1, 'Краснопресненской', NULL),
( 'meghdunarodnaya', 'Международная', 1, 'Международной', NULL),
( 'ulica-1905-goda', 'Улица 1905 года', 1, 'Улице 1905 года', NULL),
( 'shelepiha', 'Шелепиха', 1, 'Шелепихе', NULL),
( 'prospekt-vernadskogo', 'Проспект Вернадского', 1, 'Проспекте Вернадского', NULL),
( 'lomonosovskiy-prospekt', 'Ломоносовский проспект', 1, 'Ломоносовском проспекте', NULL),
( 'ramenki', 'Раменки', 1, 'Раменках', NULL),
( 'botanicheskiy-sad', 'Ботанический сад', 1, 'Ботаническом саду', NULL),
( 'rostokino', 'Ростокино', 1, 'Ростокино', NULL),
( 'ryazanskiy-prospekt', 'Рязанский проспект', 1, 'Рязанском проспект', NULL),
( 'dmitrovskaya', 'Дмитровская', 1, 'Дмитровской', NULL),
( 'sviblovo', 'Свиблово', 1, 'Свиблово', NULL),
( 'panfilovskaya', 'Панфиловская', 1, 'Панфиловской', NULL),
( 'streshnevo', 'Стрешнево', 1, 'Стрешнево', NULL),
( 'semenovskaya', 'Семеновская', 1, 'Семеновской', NULL),
( 'elektrozavodskaya', 'Электрозаводская', 1, 'Электрозаводской', NULL),
( 'sokolyniki', 'Сокольники', 1, 'Сокольниках', NULL),
( 'strogino', 'Строгино', 1, 'Строгино', NULL),
( 'krestyyanskaya-zastava', 'Крестьянская застава', 1, 'Крестьянской заставе', NULL),
( 'marksistskaya', 'Марксистская', 1, 'Марксистской', NULL),
( 'ploschady-ilyicha', 'Площадь Ильича', 1, 'Площади Ильича', NULL),
( 'proletarskaya', 'Пролетарская', 1, 'Пролетарской', NULL),
( 'rimskaya', 'Римская', 1, 'Римской', NULL),
( 'taganskaya', 'Таганская', 1, 'Таганской', NULL),
( 'belorusskaya', 'Белорусская', 1, 'Белорусской', NULL),
( 'biblioteka-imeni-lenina', 'Библиотека имени Ленина', 1, 'Библиотеке имени Ленина', NULL),
( 'dostoevskaya', 'Достоевская', 1, 'Достоевской', NULL),
( 'kitay', 'Китай', 1, 'Китае', NULL),
( 'lubyanka', 'Лубянка', 1, 'Лубянке', NULL),
( 'mayakovskaya', 'Маяковская', 1, 'Маяковской', NULL),
( 'mendeleevskaya', 'Менделеевская', 1, 'Менделеевской', NULL),
( 'novoslobodskaya', 'Новослободская', 1, 'Новослободской', NULL),
( 'ohotnyy-ryad', 'Охотный ряд', 1, 'Охотный ряд', NULL),
( 'ploschady-revolyucii', 'Площадь Революции', 1, 'Площади Революции', NULL),
( 'pushkinskaya', 'Пушкинская', 1, 'Пушкинской', NULL),
( 'tverskaya', 'Тверская', 1, 'Тверской', NULL),
( 'teatralynaya', 'Театральная', 1, 'Театральной', NULL),
( 'cvetnoy-bulyvar', 'Цветной бульвар', 1, 'Цветном бульваре', NULL),
( 'chehovskaya', 'Чеховская', 1, 'Чеховской', NULL),
( 'volghskaya', 'Волжская', 1, 'Волжской', NULL),
( 'tekstilyschiki', 'Текстильщики', 1, 'Текстильщиках', NULL),
( 'petrovsko', 'Петровско', 1, 'Петровской', NULL),
( 'timiryazevskaya', 'Тимирязевская', 1, 'Тимирязевской', NULL),
( 'troparevo', 'Тропарёво', 1, 'Тропарёво', NULL),
( 'yugo-zapadnaya', 'Юго-западная', 1, 'Юго-западной', NULL),
( 'planernaya', 'Планерная', 1, 'Планерной', NULL),
( 'shodnenskaya', 'Сходненская', 1, 'Сходненской', NULL),
( 'bagrationovskaya', 'Багратионовская', 1, 'Багратионовской', NULL),
( 'filevskiy-park', 'Филевский парк', 1, 'Филевском парке', NULL),
( 'fili', 'Фили', 1, 'Фили', NULL),
( 'pionerskaya', 'Пионерская', 1, 'Пионерской', NULL),
( 'slavyanskiy-bulyvar', 'Славянский бульвар', 1, 'Славянском бульваре', NULL),
( 'vorobyevy-gory', 'Воробьевы горы', 1, 'Воробьевых горах', NULL),
( 'lughniki', 'Лужники', 1, 'Лужниках', NULL),
( 'park-kulytury', 'Парк Культуры', 1, 'Парке Культуры', NULL),
( 'sportivnaya', 'Спортивная', 1, 'Спортивной', NULL),
( 'frunzenskaya', 'Фрунзенская', 1, 'Фрунзенской', NULL),
( 'hovrino', 'Ховрино', 1, 'Ховрино', NULL),
( 'begovaya', 'Беговая', 1, 'Беговой', NULL),
( 'zorge', 'Зорге', 1, 'Зорге', NULL),
( 'poleghaevskaya', 'Полежаевская', 1, 'Полежаевской', NULL),
( 'horoshevo', 'Хорошёво', 1, 'Хорошёво', NULL),
( 'horoshevskaya', 'Хорошёвская', 1, 'Хорошёвской', NULL),
( 'cska', 'ЦСКА', 1, 'ЦСКА', NULL),
( 'kantemirovskaya', 'Кантемировская', 1, 'Кантемировской', NULL),
( 'caricyno', 'Царицыно', 1, 'Царицыно', NULL),
( 'kalughskaya', 'Калужская', 1, 'Калужской', NULL),
( 'profsoyuznaya', 'Профсоюзная', 1, 'Профсоюзной', NULL),
( 'chertanovskaya', 'Чертановская', 1, 'Чертановской', NULL),
( 'yughnaya', 'Южная', 1, 'Южной', NULL),
( 'praghskaya', 'Пражская', 1, 'Пражской', NULL),
( 'annino', 'Аннино', 1, 'Аннино', NULL),
( 'lesoparkovaya', 'Лесопарковая', 1, 'Лесопарковой', NULL),
( 'ulica-akademika-yangelya', 'Улица академика Янгеля', 1, 'Улице академика Янгеля', NULL),
( 'oktyabryskoe-pole', 'Октябрьское поле', 1, 'Октябрьском поле', NULL),
( 'schukinskaya', 'Щукинская', 1, 'Щукинской', NULL),
( 'volgogradskiy-prospekt', 'Волгоградский проспект', 1, 'Волгоградском проспекте', NULL),
( 'dubrovka', 'Дубровка', 1, 'Дубровке', NULL),
( 'koghuhovskaya', 'Кожуховская', 1, 'Кожуховской', NULL),
( 'oktyabryskaya', 'Октябрьская', 1, 'Октябрьской', NULL),
( 'polyanka', 'Полянка', 1, 'Полянке', NULL),
( 'bitcevskiy-park', 'Битцевский парк', 1, 'Битцевском парке', NULL),
( 'novoyasenevskaya', 'Новоясеневская', 1, 'Новоясеневской', NULL),
( 'teplyy-stan', 'Теплый стан', 1, 'Теплом стане', NULL),
( 'yasenevo', 'Ясенево', 1, 'Ясенево', NULL);
"
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%metro}}');
    }
}
