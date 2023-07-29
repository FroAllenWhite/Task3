<?php
use yii\helpers\Html;

$this->title = "Информация об авторе: " . Html::encode($user->fio);
?>

<h2>Информация об авторе: <?= Html::encode($user->fio) ?></h2>
<p>Email: <?= Html::encode($user->email) ?></p>
<?php if (!empty($user->phone)): ?>
    <p>Телефон: <?= Html::encode($user->phone) ?></p>
<?php endif; ?>

<h3 class="review-title">Отзывы автора</h3>

<style>
    .review-img {
        max-width: 300px;
        border: 1px solid #ccc;
        margin: 10px auto;
    }

    .review-title {
        text-align: center;
    }

    .review-text {
        text-align: left;
    }

    .review-item {
        max-width: 1000px;
        margin: 0 auto 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
    }

    .author-info {
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
    }
</style>
<?php if (count($user->reviews) > 0): ?>
    <?php foreach ($user->reviews as $review): ?>
        <div class="review-item">
            <div>
                <h4 class="review-title"><?= Html::encode($review->title) ?></h4>
                <?php if (!empty($review->img)): ?>
                    <?= Html::img(Yii::getAlias('@web/images/' . $review->img), ['class' => 'review-img']); ?>
                <?php endif; ?>
                <p class="review-text"><?= Html::encode($review->text) ?></p>
            </div>
            <div class="author-info">
                <a href="<?= Yii::$app->urlManager->createUrl(['site/city-reviews', 'cityId' => $review->id_city]) ?>" class="show-author-info">
                    Отзыв для города: <?= Html::encode($review->city->name) ?>
                </a>
                <span class="review-date">
                    Дата создания: <?= Yii::$app->formatter->asDate($review->date_create) ?>
                </span>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>У автора пока нет отзывов.</p>
<?php endif; ?>
