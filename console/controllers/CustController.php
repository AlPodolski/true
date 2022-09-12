<?php


namespace console\controllers;

use common\models\City;
use common\models\Rayon;
use common\models\Redirect;
use frontend\models\Files;
use frontend\models\UserMetro;
use frontend\models\Webmaster;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\UserHairColor;
use frontend\modules\user\models\UserIntimHair;
use frontend\modules\user\models\UserNational;
use frontend\modules\user\models\UserPlace;
use frontend\modules\user\models\UserRayon;
use frontend\modules\user\models\UserService;
use League\Csv\Reader;
use League\Csv\Statement;
use Yii;
use yii\console\Controller;

class CustController extends Controller
{
    public function actionPrice()
    {
        $posts = Posts::find()
            ->where(['city_id' => '1'])
            ->andWhere(['fake' => Posts::POST_FAKE])
            ->limit(15000)
            ->all();

        foreach ($posts as $post){

            if ($postPhoto = Files::findAll(['related_id' => $post['id'], 'related_class' => Posts::class])){

                foreach ($postPhoto as $item){

                    $file = Yii::getAlias('@app/web'.$item->file);

                    if(\is_file($file)) \unlink($file);

                    $item->delete();

                }

            }

            UserRayon::deleteAll(['post_id' => $post['id']]);
            UserMetro::deleteAll(['post_id' => $post['id']]);
            UserHairColor::deleteAll(['post_id' => $post['id']]);
            UserIntimHair::deleteAll(['post_id' => $post['id']]);
            UserNational::deleteAll(['post_id' => $post['id']]);
            UserPLace::deleteAll(['post_id' => $post['id']]);
            UserService::deleteAll(['post_id' => $post['id']]);

            $post->delete();

        }

    }

    public function actionCust()
    {
        $arr = array('abinsk' => '1819bb54709f1043' ,  'achinsk' => 'f3011e73a150c518' ,  'achit' => 'b31c5a889a734689' ,  'ahtubinsk' => '32b9245bef11f002' ,  'akademgorodok' => '9d4663fa0732f085' ,  'aldan' => 'cface1ba2804aff8' ,  'aleksandrov' => '19abb51bbe54a5a0' ,  'aleksin' => 'ceb2e0bb978c0ed0' ,  'almetevsk1' => 'ff0bc73922ab367b' ,  'almetevsk' => 'e1aba8b689236d80' ,  'alyshta' => '26de0b1c72815769' ,  'amursk' => 'c021793b212dc500' ,  'amurzet' => '11bc45608ea82dce' ,  'anadyir1' => '6f2a9480205c70df' ,  'anadyir' => '33f08a4ac7e4b432' ,  'anapa' => '84c1010952422432' ,  'angarsk1' => '4050703a36fe87e6' ,  'angarsk' => '79b73a0bfcd03cb7' ,  'aniva' => 'c8534a8b4fe672d5' ,  'anopino' => '035efa3ac1d5cbcb' ,  'anzhero-sudzhensk' => 'fe2643d940844e19' ,  'apatityi' => 'd4ef4c85860c43b6' ,  'apsheronsk' => '7db146ba4a9d5893' ,  'aramil' => '2f94310ae8fe1921' ,  'arhangelsk' => '55706e54b4fe2a09' ,  'armavir' => 'ba41daeb4a82f414' ,  'armyansk' => 'acd90639395364d7' ,  'arsenev' => 'dfd7dd0cdfe7d0a2' ,  'artyom' => 'f4b7b93216d40187' ,  'arzamas' => '6992ce3de6a8bbbc' ,  'asbest' => 'a1616388aecb2791' ,  'ashitkovo' => '9bf54492081116e8' ,  'astana' => '586a1d1c8076f2f7' ,  'astrahan' => '789ad851e85bd062' ,  'atkarsk' => '361d8197aee34d54' ,  'aznakaevo' => '07af0c99cfb10451' ,  'azov' => '809425c0c3c823cc' ,  'balakovo' => '7e601fdc38f93082' ,  'balashixa' => 'c8f3f0a40a508d81' ,  'balaxna' => '6ada719d5d3b8f40' ,  'balesino' => '13a6d110b7e233e3' ,  'barabash' => 'da50b94fcb567b3a' ,  'barnaul' => 'e73ec73efa834ff8' ,  'bataisk' => 'f1f5e7e67e10adb7' ,  'belaya-kalitva' => '812668a37a43898c' ,  'belebei' => '01436440b5b50cf7' ,  'belgorod' => 'fd82bba82cb1398d' ,  'belogorsk' => 'f9d1fdb6b77ccfee' ,  'belokiryxa' => '5d8855c9f982565b' ,  'beloomyt' => '2acbb87a3fc8bebe' ,  'belorechensk' => '8ecb5ea6ffede6e3' ,  'beloreck' => 'b647cc76cebd91c2' ,  'belovo' => '4fc31251b7a0634e' ,  'beloyarskiy' => '2b60a635e582f6df' ,  'berdsk' => '891e23509978aa25' ,  'berezniki' => 'b459487d2c1ba185' ,  'beryozovskiy' => '2b425253c49d0079' ,  'beslan' => '852ba20457e0e98b' ,  'birobidzhan' => '17a5249430d1e07f' ,  'biysk' => '916706d2a1a8210a' ,  'blagodarnyiy' => 'c58f5f441b380491' ,  'blagoveschensk' => 'fc8e2d8dd34d3436' ,  'bobruysk' => '0e418d2df631431a' ,  'bodaybo' => '7143cfe91daff9b3' ,  'bogoroditsk' => '6cc04b4a6e3d4001' ,  'bogorodsk' => 'e4e4f492d823b365' ,  'boguchar' => '6a73e42f2b0dfd9b' ,  'bolshoy-kamen' => 'a498a50068a5405b' ,  'borisoglebsk' => 'da33d6435ef4d5bf' ,  'borovichi' => 'd3d8b8ef9a6860ac' ,  'borovsk' => '115d0d753a852cb3' ,  'bor' => 'ee6daa359deaf6df' ,  'borzya' => 'dc85cae5973e6408' ,  'bronnitsyi' => '0501b34e55434df5' ,  'bryansk' => 'd4f255513ef6c222' ,  'budyonnovsk' => '0465a0adfb31788f' ,  'buzuluk1' => '48e3ff4dc81f1386' ,  'buzuluk' => '32b26c830b8aa444' ,  'bygylma' => '3ba43c97880b88c6' ,  'celina' => '8579eb1696c1bd8a' ,  'chapaevsk' => '548e5b68a7e0ea2d' ,  'chebarkul' => 'fe8ad079fd091d5d' ,  'cheboksary' => 'd143fc79a7025e94' ,  'chehov' => '81520ab71090e765' ,  'chelyabinsk1' => '5e7bc1b6268cc3c9' ,  'chelyabinsk' => 'c1511500594c1d66' ,  'cheremhovo' => '8036e80fe2c95c77' ,  'cherepovec' => 'b10377ed7df46d71' ,  'cherkessk' => 'eea0c5cd3a094b93' ,  'chernogolovka' => 'f2df89423a3afb47' ,  'chernogorsk' => 'ca0f1f921ca1bc45' ,  'chernomorskoe' => 'c7540e9e4284fedc' ,  'chernuska' => '751d084ded2f2c73' ,  'chernyahovsk' => 'a09dd2c437968dee' ,  'chita' => '57bcc1c7edf745de' ,  'chusovoi' => '9a44d1c5762bd0b8' ,  'dalnegorsk' => 'd294c097092c9feb' ,  'dalnerechensk' => '5a8d972d87fc00f7' ,  'danilov' => 'f7f5c94d18dc7db7' ,  'derbent' => '7c7b915a0254ea5c' ,  'desnogorsk' => 'a6d0f353e607e1d5' ,  'dimitrovgrad' => '17e703167661b3cd' ,  'dinskaya' => '28dcaf86ea08f15d' ,  'dmitrov' => '47f26d60795b8a9a' ,  'dobryanka' => '4968ee8a2c1c2d14' ,  'dolgoprudnyiy' => 'b891e895c2e19d3c' ,  'domodedovo' => '7f3b6258ad85c0fe' ,  'donetsk' => '895672cd2b2bf977' ,  'donskoy' => '1224a9f569126586' ,  'dyatkovo' => 'ca978244270597d8' ,  'dybna' => '8d313d512fa8e4b0' ,  'dzerzhinskiy' => 'b7e5d298bc4a889d' ,  'dzerzhinsk' => '8f00d4ddcb26fadb' ,  'dzhankoy' => '3fd8672adcc70eaf' ,  'dzhubga' => '31c70017ecf6bbf9' ,  'efremov' => 'bff77461aeb6cbcd' ,  'egorevsk' => '55b6256bf712b316' ,  'ekaterinburg' => '8df5c8ec056a0b7a' ,  'elabyga' => '852e7de8578b01e7' ,  'elec' => '8d313cdd18fe8954' ,  'electrostal' => '000a11ca854810f9' ,  'electrougli' => 'ef72fe310764b061' ,  'elisovo' => '3d7878e50915d1f6' ,  'elnya' => '0c54861d9bcc8222' ,  'engels1' => '731b40a178ccd887' ,  'engels' => '400190f665b4f239' ,  'essentuki' => 'e3ba94c16d23dd61' ,  'evpatoriya' => '8393f2f5cdbc3fe2' ,  'eysk' => '15262e8e2ba46da4' ,  'feodosiya' => '84e666cd72945dde' ,  'fokino' => '028b6d3adda29098' ,  'fryazevo' => 'f0724117088a8cc6' ,  'fryazino' => '526e3095b8ca0b87' ,  'furmanov' => 'fcc1905496d2a277' ,  'gagarin' => 'ad251260d01a5812' ,  'gatchina' => '984b260247df2ab4' ,  'gelendzhik' => '4cebce6932a89b6b' ,  'georgievsk' => '735cf5af5d411fc2' ,  'glasov' => '47111cbfe3114e3e' ,  'gomel' => '26ad67034230ce34' ,  'gorbatov' => '5c7c8d9e81aeeb48' ,  'gorki-leninskie' => 'f055f0d60bdca345' ,  'gorno-altaisk1' => '6b68999edbd33c2c' ,  'gorno-altaisk' => '0fa181e7ae1b43d5' ,  'goroxovec' => '43e8c6dab1d06ba7' ,  'goryachiy-klyuch' => '24afa29106bcb099' ,  'groznyiy' => '53e1f28a5827009f' ,  'grysi' => 'cdebd20fa2d19e03' ,  'gulkevich' => '945d26845ca23d38' ,  'gus-hrustalnyiy' => '53568e1c6fac1743' ,  'habarovsk' => 'ee55d9e90c43e11a' ,  'hantimansiysk' => 'fd10547c919026c1' ,  'himki' => '1f917169048734f5' ,  'horol' => 'fc012157211a735a' ,  'hotkovo' => '445b714b4d3fa17f' ,  'igrim' => '7c8fc7b82f69c70e' ,  'ilskiy' => 'ddce74a07fa372ff' ,  'inza' => '0f84fce1945539c6' ,  'irbit' => '9068d9e44b55c1d5' ,  'irkutsk' => '6e7332d8cbb1a150' ,  'ishim' => '55eeac215db2cf2d' ,  'iskitim' => '3c875ff7e0be9214' ,  'istra' => 'ecb6ade3d0cab845' ,  'ivanovo' => '6f352492dd0feedb' ,  'ivanteevka' => '88b54299800070d0' ,  'izhevsk' => '0534a50e4e642e95' ,  'izobilnyiy' => '268cf60e633eb345' ,  'joshkar-ola' => '00773cc28a7c47de' ,  'kachkanar' => '3e72a110ba4af233' ,  'kalach-na-donu' => '20946cc542f657e7' ,  'kaliningrad' => '43bd2a5c738a5945' ,  'kalininsk' => 'da7413806ae8bb1d' ,  'kaluga' => '93e643587f5471e8' ,  'kalyazin' => 'b72931a8e0061134' ,  'kamensk-shahtinskiy' => '353df53e61e8dc5f' ,  'kamensk-uralskiy' => '301a3930571618d5' ,  'kamyishin' => 'afec19cd1e0502d4' ,  'kanash' => '5f265c084378b68e' ,  'kanevskaya' => 'a31e98171b1ba74a' ,  'kansk' => '4383cb715cf00375' ,  'karachaevsk' => '0c4407d1e8fa030b' ,  'kargat' => '655962ce2e8346ac' ,  'kashira' => '6a9c26f602ca3365' ,  'kasimov' => '24d9955fbc93dde0' ,  'kazan1' => 'b7eea8fb0dc75c20' ,  'kazan' => 'ef9da49b0245b21c' ,  'kemerovo' => '2eae95d217fd50a5' ,  'kerch' => '2784f2e9f8f68baa' ,  'kineshma' => '873bc3e58cb13fd7' ,  'kingisepp' => '89870c859f81bf7a' ,  'kirensk' => 'c3d90564b274aa74' ,  'kirgach' => 'aae5ac0a7a1fb752' ,  'kirovo-chepetsk' => '554eea70768124b4' ,  'kirov' => '555fb204eaaa3436' ,  'kirovsk' => '9ca6d5c6a61981f2' ,  'kiselyovsk' => '7e0d16f207a34751' ,  'kislovodsk' => '351fca80d005d803' ,  'kizil' => '0a87e29409bfaecb' ,  'kizlyar' => 'fcff54cb5cfb5630' ,  'klin' => '491165ef0096e279' ,  'klintsi' => '9917c56ef9f8609c' ,  'kogalim' => 'eab70346abf747c2' ,  'kokoshkino' => '6a1c404fac09b53d' ,  'kolchugino' => 'd5b9e9fefd88f8ac' ,  'kolomna' => '9fbbfeca2af6955c' ,  'kolpino' => '7d1703d96841caa7' ,  'komsomolsk-na-amure' => '442156f7f89f6887' ,  'konakovo' => 'ab51cb7ff26dbea8' ,  'kondopoga' => 'f37d9e0c5df47886' ,  'kondrovo' => '96b9fb4adb3bfa41' ,  'kopeysk' => '17e68c412cd3f739' ,  'korablino' => '3c21940052eb57b6' ,  'korenovsk' => 'e0d436403da18cfd' ,  'korolyov' => '3e35c54c515b1ce3' ,  'korsakov' => '8c8bc416615a05ad' ,  'kostroma' => 'e1b5d8f217b522e7' ,  'kotelniki' => '887781ff95b866ae' ,  'kotlas' => '435695f6c604e13f' ,  'kovrov1' => 'd8288bc5b307d5f8' ,  'kovrov' => '1e819c8f07c53767' ,  'krasniy-sulin' => '5b2dc1f83faf218d' ,  'krasnoarmeysk' => 'a64144c44d6041ff' ,  'krasnodar' => '9bd6033bcf43a40c' ,  'krasnoe-selo' => 'd6370a6c9b9c255f' ,  'krasnogorsk' => '94ce354a2e17b9d0' ,  'krasnogvardeysk' => '18df46fd4827d6fa' ,  'krasnokamensk' => 'af1d03fc7f1a608d' ,  'krasnoperekopsk' => '6f035cac7b825fac' ,  'krasnoufimsk' => 'e6be26f55716bbd3' ,  'krasnoyarsk' => 'f7994f63f6251817' ,  'krichev' => '0b1ccfa776cd9f4b' ,  'krimsk' => '61021ba6ef612e6d' ,  'kropotkin' => '93066b779e260227' ,  'kstovo' => '2864281b5b1a33cd' ,  'kubinka' => 'd0823449b13e2490' ,  'kulebaki' => 'ba9a0d4a84041398' ,  'kuloy' => '26ac32715ad034ae' ,  'kumertau' => 'ad0e053020f1cdb5' ,  'kungur' => '8614d9738daaa3a9' ,  'kurgan' => 'f04be0c6efb28d21' ,  'kurilsk' => 'fa9170d7620fa744' ,  'kursk' => '4c0e36f6a946b579' ,  'kushchevskaya' => 'b044daaea70d0da5' ,  'kuznetsk1' => 'f4713018f112e8a3' ,  'kuznetsk' => '74b1e8c59cc2fdb8' ,  'labinsk' => '3c1dda70ace9bc18' ,  'labitnangi' => 'ccc7956f3174a324' ,  'leningradskaya' => 'edb60e522d340291' ,  'leninogorsk' => 'a37c58b0570d0fdd' ,  'leninsk-kuznetskiy' => 'b60554718437e4ac' ,  'lensk' => 'a0aef85328e9efb2' ,  'lermontov' => '5d8d0324b7bd1984' ,  'lesnoy' => 'd264c0a9012cbde7' ,  'lesosibirsk' => '562460faadd69a1e' ,  'likino-dulyovo' => '65bfb37273f87379' ,  'lipetsk' => 'e5e06fad36052f84' ,  'liski' => 'b6a06dd1f86eb32c' ,  'lisva' => 'db1f60363ee45b49' ,  'litkarino' => '64bbe50bf0328453' ,  'lobachev' => 'f600b80ce78f6d08' ,  'lobnya' => '8f1f22393f2d8c4f' ,  'lodeynoepole' => '697eda738aca2322' ,  'loknya' => 'a220e3b23de1ee18' ,  'losino-petrovskiy' => 'ec4a526abf4a3714' ,  'luberci' => '8e56f9d8d5240ef4' ,  'luga' => '9dd3865ee62def61' ,  'luhovitsi' => '9711996e68a534d7' ,  'luza' => 'ac20f7ceb99ebb98' ,  'magadan1' => 'b03b04376adebae4' ,  'magadan' => '66fb256091bda6f7' ,  'magnitogorsk1' => '0f8d9aaaa3045796' ,  'magnitogorsk' => '5b68600e05401268' ,  'mahachkala' => 'de2792b03309afbf' ,  'makarov' => 'f50b95bdb5debfb1' ,  'maloyaroslavets' => '4e73bf7b3e03c9d2' ,  'mama' => '6faf0175f640ddc9' ,  'maykop' => 'dc9d71ba86c796bc' ,  'mayskiy' => 'f29289c74122da1b' ,  'megdurechensk' => 'a94ccee605c879cf' ,  'megion' => 'ab413cebe4f2c94e' ,  'meleuz' => '957c851b1889bc20' ,  'miass' => '2d6b948d54919670' ,  'mihaylovka' => 'd85f84a8054a78bf' ,  'millerovo' => '2fbc39522330775f' ,  'mineralnie-vodi' => '9945268c8b422968' ,  'minusinsk' => 'e4ef0233dbfdc4c2' ,  'mirniy' => 'c9d1ce8084c47d3c' ,  'mitishchi' => '744184ba0641b049' ,  'mogga' => '5f62ceb88eee8f65' ,  'mogilev' => '3b53f220c7751a9b' ,  'mogocha' => 'f412eb66df8214dc' ,  'monchegorsk' => '55c42ae7c1caff89' ,  'morozovsk' => 'bd545982c7b30c43' ,  'morshansk' => 'ee15ebcd1b552901' ,  'moskovskiy' => 'd9c046b423191c34' ,  'moskva1' => 'ada7eb3a8002f63e' ,  'moskva' => '6766a38067f3ee8a' ,  'mozdok' => 'ce2984d888993526' ,  'mtsensk' => 'db9b13967ffddf71' ,  'muravlenko' => '70bdadd98dcb3d82' ,  'murmansk' => 'bcef7845354c46c5' ,  'naberezhnye-chelny' => 'a7b7ad1f5eb6f423' ,  'nadim' => 'abda97de4bdb5c4f' ,  'nahodka' => 'd9111c3754e325dd' ,  'nalchik' => '96e115c90e77470d' ,  'narofominsk' => '361d8a66533d948f' ,  'nazran' => '27bd5a227f862a98' ,  'neftecamsk' => '842cfd57e7ce964b' ,  'nefteugansk' => 'ab08ee0b6959b4e5' ,  'nekrasovskoe' => 'c663f21973b4666c' ,  'nerungri' => '5c963fd70ca3e404' ,  'nevinomssk' => '29e6f45a37cc0232' ,  'nijegorodskaya' => '86840259832aa6b5' ,  'nijneudinsk' => '953ec79159d47064' ,  'nijnikamsk' => '3d948ec476e63495' ,  'nikolaevsknaamure' => '91627ed5f2354111' ,  'nizhnevartovsk' => '772395f776362b3b' ,  'nizhniy-novgorod' => '3e8c67237f42410f' ,  'nizhniy-tagil' => 'd46ab7ffa4585b5d' ,  'noginsk' => 'd4980c99b83a0b8d' ,  'nogliki' => '9f1cfb5bec113bab' ,  'norilsk' => '214c785be6dea039' ,  'novachara' => '1d365709e27c16c6' ,  'noviyoskol' => 'd278b2d52cda8a6a' ,  'noviyurengoy' => 'c8b03218c9d60285' ,  'novoaleksandrovsk' => '776c254b04788bc4' ,  'novocherkassk' => 'f73f21186dd57c8c' ,  'novodvinsk' => 'e1eac8f5535efbbe' ,  'novokubansk' => 'e7019851fcf4b655' ,  'novokuybisjevsk' => 'a1850bc1a3827755' ,  'novokuznetsk' => '70754ac3d674724d' ,  'novomosskovsk' => '915cc72242b95af3' ,  'novorossiysk' => '22b0cdc9d1a46552' ,  'novosibirsk' => '051feb1eff04329d' ,  'novotitarovskaya' => '1e7d3bc20df79f3b' ,  'novotroick' => 'ee0f60143785707b' ,  'novouralsk' => '53b5bf6b6b38042f' ,  'novouzenzk' => '540e3bc30e3092de' ,  'noyabrsk' => 'ded984b4be5d2e1c' ,  'nurlat' => '1e11b76af7deb5d3' ,  'nyagan' => 'f80913f030151970' ,  'obninsk' => '17cac0d3531736da' ,  'odincovo' => '7f45907aae9dfc80' ,  'oha' => '70d1f2e0d41bc8db' ,  'oktyabrskiy' => '8c9625ee43dbd79c' ,  'olenegorsk' => 'da79bd25e8f46b9f' ,  'omsk' => 'eb62a614a4b8b91e' ,  'opochka' => '593f13e78e591f61' ,  'orehovozuevo' => '2846559be1be1c0d' ,  'orel' => '1a6a0a9998bfb0fb' ,  'orenburg' => 'a13cec12076ef7bd' ,  'orsk' => 'e983429b5bf7ce32' ,  'ozersk' => 'b6148e405dc8f9f0' ,  'ozery' => '6bf8c3379c7b4ebb' ,  'palasovka' => 'c31e2afe76c409d7' ,  'pangodi' => 'b4b5a57cc5133903' ,  'pavlofedorovka' => 'dff7b032d4923791' ,  'pavlovo' => '8709173f272ced2d' ,  'pavlovskiyposad' => 'a58a143fad37bc1f' ,  'pavlovskiy' => '7e90bd197afe6701' ,  'pavlovsk' => '01dfd41d01e6400b' ,  'pechora1' => 'fd498be98d0ec86b' ,  'pechora' => 'a3371e810b7f2a1c' ,  'penza1' => '1d42452445dff191' ,  'penza' => 'c2258c0f76b6603a' ,  'perevoz' => 'be81dc95411adbba' ,  'perm' => '75fbb908578204a2' ,  'pervomayskoe' => '6df3b04fb1dfc5c1' ,  'pervouralsk' => '70782001ebbf3fa9' ,  'pestovo' => 'fd1489cfcf7af2dd' ,  'petrodvorec' => 'c96302d62baa5093' ,  'petropavlovskkamchatskiy' => 'a8ac3094a8491b12' ,  'petrovskzabaykalskiy' => '6c0bb755c9675aed' ,  'petrozavodsk' => 'a87f3da9a313f0fd' ,  'pikalevo' => 'd846d25ddbe10b5b' ,  'pitkyantra' => 'baae3275b1a617b8' ,  'podolsk' => 'b34f04c85c169934' ,  'pokrov' => '882a95334c7e5117' ,  'polevskoy' => '1132b79171ea9ae1' ,  'polisaevo' => '8a32aa5b21180686' ,  'polyarniezori' => '3eed2253dd6ca948' ,  'poronaysk' => '9dd7b3de0a2e240f' ,  'prohladniy' => 'd9cb2843c6da5f48' ,  'prokopievsk1' => '9eaa7bf94df23366' ,  'prokopievsk' => 'cd55ffb9a5c7bd2d' ,  'proletarsk' => 'dd8c4c6e141ce0c3' ,  'protvino' => 'e39194af2b23fb03' ,  'pskov1' => '64658d712bb75e54' ,  'pskov' => '275f83d59db53444' ,  'pstrogojsk' => 'd690831ea25657fd' ,  'pugachev' => 'dc2c0e06c03b3983' ,  'pushkino' => '458b1f9bb05f584e' ,  'pyatigorsk' => 'fd943fda30451f84' ,  'radujniy' => 'a355a4bd1e8f60b5' ,  'raichinsk' => '06ecb358e5031457' ,  'ramenskoe' => '24fa397a7ccd10e4' ,  'redkino' => 'baf58dea9cbb4f7c' ,  'reftinskiy' => 'c5052a4bb6fdbc54' ,  'reutov' => 'aef3f41f43c920f8' ,  'revda' => '00d391ce9b7fc1bf' ,  'ribinsk' => 'c7cae8208f878794' ,  'ribnoe' => '5309c4cf322252f8' ,  'rjev' => 'aeceb96bcf731b80' ,  'roschino' => 'e385e719099adca7' ,  'rossosh' => '7101298a9b9619cc' ,  'rostov-na-dony' => 'b6aa5aec1e51ea4b' ,  'rostovvelikiy' => '97b6aa88171c06bd' ,  'rtischevo' => 'f8cff932381d90e4' ,  'rubzovo' => 'bd390c18b99f5cf5' ,  'rusa' => 'b158e9f7c4ff5c90' ,  'ryazan' => '868cac033e50f538' ,  'sajanogorsk' => '6a42af3218a33d6d' ,  'salavat' => '34372937649960a8' ,  'salehard' => 'a9a59dc6f5ff63c4' ,  'salsk' => '76eb3a6153a2d8d9' ,  'samara' => 'a3bcb08fb79e798d' ,  'sankt-piterburg' => 'e3cfd392fe7f9e46' ,  'saraktash' => 'ca490e33156d6411' ,  'saransk' => 'e4a47fc8f3c5d229' ,  'saratov' => '56949d639f16ec5d' ,  'sarov' => '3ad43ed5de9aac01' ,  'satka' => '836c265fa249e908' ,  'segezha' => '5004abd24de0de16' ,  'sengilej' => '4915db8d494040cb' ,  'sergach' => '98f3c08114044658' ,  'sergiev-posad' => '8eebb44e89760271' ,  'serpuhov' => '7bd76b4cd90fe4b8' ,  'sertolovo' => 'e710a9d1e71182bd' ,  'sevastopol' => 'd86904366a3985ff' ,  'severobajkalsk' => '61ea35c7ee8daed2' ,  'severodvinsk' => '8d3712c9edc0628e' ,  'severomorsk' => 'c1eaeb56cc6df9bb' ,  'severskaja' => '6cf4b554d4d27bf2' ,  'seversk' => '8e5fd3645fc7010a' ,  'shadrinsk' => '7f21f9f826734073' ,  'shahti' => '96cc31e09ffa1d54' ,  'sharya' => '16a7b0718ebcc174' ,  'shatura' => 'f662513ce551473e' ,  'shekino' => '1d747746b107e90f' ,  'shelehov' => '71299b57059e91d4' ,  'shelkovo' => '7c5a43ca5804b426' ,  'shimanovsk' => 'a6b9b92c7b794c32' ,  'shushenskoe' => '623e2fe0ade30090' ,  'sibaj' => 'cb7f90a553eff039' ,  'simferopol' => '462f16d69bbc4e0a' ,  'slavjansk-na-kubani' => '5f46993d7d37c2ec' ,  'smolensk' => 'cd8cb60d6528c2e4' ,  'snezhinsk' => 'ff897677732b7e21' ,  'snezhnogorsk' => '5883ddffc98f5a3d' ,  'sochi' => '1d675bba5950a6d6' ,  'solikamsk1' => '3bc78a5389bab1b3' ,  'solikamsk' => '00d221b906b3efd0' ,  'solnechnodolsk' => '70381af20e8a16ce' ,  'solnechnogorsk' => '828edf0336c0a148' ,  'sorochinsk' => '5c4a44e892c4d43f' ,  'sortavala' => '4c4f59a31b437c45' ,  'sosenskij' => '54faf3c1ab160ccd' ,  'sosnovyj-bor' => 'a322cbd9d4bd64ae' ,  'sovetskaja-gavan' => '42d9a075b9aa7246' ,  'sovetskij' => 'fc42eee6aab8f29b' ,  'sovetsk' => '52f15cb33332ed50' ,  'spassk-rjazanskij' => 'dad7a353f75f6162' ,  'starica' => 'f953d520ee5c5f59' ,  'staryj-oskol' => 'bb4bd6a0d6b7c51d' ,  'stavropol' => '96e1f92fbfa93be9' ,  'sterlitamak' => '8b4008fdce50ee37' ,  'strezhevoj' => 'e4cf4ec9366d1b37' ,  'strunino' => '0576e5f85aa0380b' ,  'stupino' => '25161866f12c5c6e' ,  'sudak' => 'ae6f39ac01a03bc4' ,  'suhinichi' => '6f8eba279f19272d' ,  'suhoj-log' => 'b1bdcc3112d09d52' ,  'surgut' => '75b217f7616db844' ,  'surovikino' => '3f4b439dd7c56492' ,  'svirsk' => 'f01e8cd9221db87b' ,  'svobodnyj' => '5638ef4cfd49741a' ,  'syktyvkar1' => 'a40d3e620013357e' ,  'syktyvkar' => 'a166ad8e20f0195a' ,  'syzran1' => '933c1463af13a2dd' ,  'syzran' => '5acaccee52b49569' ,  'taganrog' => 'fa0089a177120477' ,  'talica' => 'c54f7550efb35bc0' ,  'talnah' => 'e8a4c97761f22d2b' ,  'taman' => 'd46deec7bf38483a' ,  'tambov' => 'ae601e74a78dc339' ,  'tashtagol' => '1784338f67614584' ,  'tayshet' => '105555ef1896dbda' ,  'teikovo' => '4044cef74986006a' ,  'tihoretsk' => 'a827f9eb86f9363a' ,  'tihvin' => 'e561ae4da3cb6482' ,  'tinda' => 'fb50f6c4c159a12c' ,  'tobolsk' => '99b46eb003aa91e9' ,  'tolyatti' => 'c1bcc80a2deac066' ,  'tomsk' => '7e95c30c9d7addc8' ,  'troick' => 'c63f1253ddb4316e' ,  'tryohgorniy' => '18269cc66152e10b' ,  'tuapce' => 'de935c69370daa36' ,  'tula' => '8c6d6f15aa401f1f' ,  'tumen' => 'e94a9a408ff22287' ,  'tutaev' => '39fb8ad0b84c21e4' ,  'tver' => '76bed55ca85008df' ,  'ubileyniy' => 'e4bf0f9ac1229285' ,  'ufa' => '4705790a617126e0' ,  'uhta' => '307ea6ec3d75d0fe' ,  'ujnosahalinsk' => '314f1013049b300a' ,  'ujnouralsk' => 'bd2440a31fbf71e8' ,  'ujur' => '7055bb2d386362f7' ,  'ulan-ude' => '3c573ca32dc0d72c' ,  'ulyanovsk' => '21c42c95d0877fae' ,  'unecha' => '849f44eb4a15023a' ,  'uray' => 'ef3b1f071fa9780c' ,  'uren' => '3012e165efa8d720' ,  'urga' => '048039c75ece31d4' ,  'usinsk' => 'b44d2304b8b20a87' ,  'usolesibirskoe' => '8de0381417960667' ,  'ussuriyks' => 'a621e3d5e6ba6952' ,  'ustilimsk' => '5f34baf8dd7cbc0f' ,  'ustkut' => '9c5c5ebf68215af8' ,  'ustlabinsk' => '0a27e040538808d6' ,  'uvarovo' => 'cc43c9767fbbd6ee' ,  'uva' => 'ad92d4b4d54d54b8' ,  'krasnoturinsk' => '5fa866a36482dce9');

        foreach ($arr as $key => $value){

            $webmaster = new Webmaster();

            if ($city = City::find()->where(['url' => $key])->one()){

                $webmaster->city_id = $city->id;

            }else{

                $webmaster->city_name = $key;

            }

            $webmaster->tag = $value;

            $webmaster->save();

        }

    }

    public function actionIndex()
    {

        $cloudUrl = 'https://api.cloudflare.com/client/v4/zones//dns_records?';

        $dataRequest = 'content='.$oldIp.'&page=1&per_page=100';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $cloudUrl.$dataRequest);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $headers = [
            'X-Auth-Email: ' . 'anketa-dosug@yandex.ru',
            'X-Auth-Key: ' . $token,
            'Content-Type: application/json',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);

        $object = json_decode($server_output);

        curl_close($ch);

        foreach ($object->result as $item){

            if (!isset($item->id)) continue;

            $zapid = $item->id;


            // пытаемся поставить галочку на облаке
            $zoneindetif = "https://api.cloudflare.com/client/v4/zones//dns_records/$zapid";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $zoneindetif);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
                'X-Auth-Email: ' . 'anketa-dosug@yandex.ru',
                'X-Auth-Key: ' . $token,
                'Content-Type: application/json',
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $server_output = curl_exec($ch);

        }

    }
}