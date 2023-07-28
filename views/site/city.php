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

<div class="city-review-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['action' => ['submit-review']]); ?>

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