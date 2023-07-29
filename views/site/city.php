<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Review */
/* @var $form yii\widgets\ActiveForm */

// ...

$this->title = isset($cityName) ? "Отзывы о городе {$cityName}" : 'Города';
$this->params['breadcrumbs'][] = $this->title;
?>

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

<div class="container">
    <div class="text-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php if (Yii::$app->session->hasFlash('reviewError')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('reviewError') ?>
        </div>
    <?php endif; ?>

    <?php if (count($city->reviews) > 0): ?>
        <?php foreach ($city->reviews as $review): ?>
            <div class="review-item">
                <div>
                    <h4 class="review-title"><?= Html::encode($review->title) ?></h4>
                    <?php if (!empty($review->img)): ?>
                        <?= Html::img(Yii::getAlias('@web/images/' . $review->img), ['class' => 'review-img']); ?>
                    <?php endif; ?>
                    <p class="review-text"><?= Html::encode($review->text) ?></p>
                </div>
                <div class="author-info">
                    <a href="<?= Yii::$app->urlManager->createUrl(['site/author-info', 'authorId' => $review->id_author]) ?>" class="show-author-info">
                        Автор: <?= Html::encode($review->author->fio) ?>
                    </a>
                    <span class="review-date">
                        Дата создания: <?= Yii::$app->formatter->asDate($review->date_create) ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Пока нет отзывов для этого города.</p>
    <?php endif; ?>
</div>

<?php $form = ActiveForm::begin([
    'action' => ['submit-review'],
    'options' => ['class' => 'bg-light border p-3'],
]); ?>

<?= $form->field($model, 'city_name')->hiddenInput(['value' => $cityName])->label(false) ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'text')->textarea(['maxlength' => true]) ?>

<?= $form->field($model, 'rating')->textInput(['type' => 'number', 'min' => 1, 'max' => 5]) ?>

<?= $form->field($model, 'img')->fileInput() ?>

<?= $form->field($model, 'id_city')->dropDownList(\yii\helpers\ArrayHelper::map($cityList, 'id', 'name')) ?>

<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
</div>
