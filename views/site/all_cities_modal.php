<?php
use app\models\City;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Выберите город';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<div class="modal-header">
    <h5 class="modal-title">Выберите ваш город</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
</div>
<div class="modal-body">
    <ul>
        <?php

        foreach ($cities as $city) : ?>
            <li>
                <a href="#" class="choose-city" data-city="<?= Html::encode($city->name) ?>">
                    <?= Html::encode($city->name) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>