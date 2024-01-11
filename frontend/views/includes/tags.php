<?php /* @var $post \frontend\modules\user\models\Posts */ ?>

<div class="catalog-item__tags">
    <ul class="catalog-item-tags__list">

        <?php if (isset($post['nacionalnost']) and $post['nacionalnost']) : ?>

            <li class="catalog-item-tags__item">
                <a href="/nacionalnost-<?php echo $post['nacionalnost']['url'] ?>"
                   class="catalog-item-tags__link">#<?php echo $post['nacionalnost']['value'] ?></a>
            </li>

        <?php endif; ?>

        <?php if (isset($post['service']) and $post['service']) : ?>

            <?php foreach ($post['service'] as $item) : ?>

                <?php if ($item['service_id'] == 20) : ?>

                    <li class="catalog-item-tags__item">
                        <a href="/usluga-analnyj-seks"
                           class="catalog-item-tags__link">#Анал</a>
                    </li>

                <?php endif; ?>

                <?php if ($item['service_id'] == 12) : ?>

                    <li class="catalog-item-tags__item">
                        <a href="/usluga-kunilingus"
                           class="catalog-item-tags__link">#Куни</a>
                    </li>

                <?php endif; ?>

                <?php if ($item['service_id'] == 22) : ?>

                    <li class="catalog-item-tags__item">
                        <a href="/usluga-minet-bez-rezinki"
                           class="catalog-item-tags__link">#МБР</a>
                    </li>

                <?php endif; ?>

                <?php if ($item['service_id'] == 7) : ?>

                    <li class="catalog-item-tags__item">
                        <a href="/usluga-minet-v-mashine"
                           class="catalog-item-tags__link">#Минет в машине</a>
                    </li>

                <?php endif; ?>

            <?php endforeach; ?>

        <?php endif; ?>

        <?php if (isset($post['place']) and $post['place']) : ?>

            <?php foreach ($post['place'] as $item) : ?>

                <li class="catalog-item-tags__item">
                    <a href="/mesto-<?php echo $item['url'] ?>"
                       class="catalog-item-tags__link">#<?php echo $item['value'] ?></a>
                </li>

            <?php endforeach; ?>


        <?php endif; ?>

        <?php if (isset($post['strizhka']) and $post['strizhka']) : ?>

            <li class="catalog-item-tags__item">
                <a href="/intimnaya-strizhka-<?php echo $post['strizhka']['url'] ?>"
                   class="catalog-item-tags__link">#<?php echo $post['strizhka']['value'] ?></a>
            </li>

        <?php endif; ?>

    </ul>
</div>