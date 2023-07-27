<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */


use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\SignupForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'phone')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'password1')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
