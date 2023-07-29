<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = "Информация об авторе: " . Html::encode($author->fio);
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<h2>Информация об авторе: <?= Html::encode($author->fio) ?></h2>
<p>Email: <?= Html::encode($author->email) ?></p>
<?php if (!empty($author->phone)): ?>
    <p>Телефон: <?= Html::encode($author->phone) ?></p>
<?php endif; ?>






<?php $this->endContent(); ?>
