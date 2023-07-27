<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация завершена';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup-success">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Вы успешно зарегистрировались. На ваш email отправлен код активации.</p>
    <p>Введите код активации ниже:</p>

    <?php $form = ActiveForm::begin(['id' => 'activation-form']); ?>

    <?= $form->field($model, 'activationCode')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Активировать', ['class' => 'btn btn-primary', 'name' => 'activation-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
