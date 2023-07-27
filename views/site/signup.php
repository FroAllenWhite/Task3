<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\SignupForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->isGuest): ?>
        <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

        <?= $form->field($model, 'fio')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'email')->textInput() ?>
        <?= $form->field($model, 'phone')->textInput() ?>

        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password1')->passwordInput() ?>
        <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::classname(), [
            'template' => '{input} {image}',
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php else: ?>
        <div>
            <?= Html::a('Выйти', ['site/logout'], ['class' => 'btn btn-danger', 'data-method' => 'post']) ?>
        </div>
    <?php endif; ?>
</div>