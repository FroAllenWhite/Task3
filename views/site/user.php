<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


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

    .modal-content {
        padding: 15px;
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
                <p class="review-rating">Оценка: <?= Html::encode($review->rating) ?></p> <!-- Add this line -->
            </div>
            <div class="author-info">
                <a href="<?= Url::to(['site/city', 'cityId' => $review->id_city]) ?>" class="show-author-info">
                    Отзыв для города: <?= Html::encode($review->city->name) ?>
                </a>
                <span class="review-date">
                    Дата создания: <?= Yii::$app->formatter->asDate($review->date_create) ?>
                </span>
            </div>
            <div class="review-actions">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editReviewModal<?= $review->id ?>">
                    Редактировать
                </button>
                <?= Html::a('Удалить', ['site/confirm-delete-review', 'reviewId' => $review->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить этот отзыв?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>

        <div class="modal fade" id="editReviewModal<?= $review->id ?>" tabindex="-1" aria-labelledby="editReviewModalLabel<?= $review->id ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editReviewModalLabel<?= $review->id ?>">Редактирование отзыва</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php $form = ActiveForm::begin(['action' => ['site/edit-review', 'reviewId' => $review->id]]); ?>

                        <?= $form->field($review, 'title')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($review, 'text')->textarea(['rows' => 6]) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>У автора пока нет отзывов.</p>
<?php endif; ?>
