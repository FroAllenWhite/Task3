<?php
use app\models\City;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Города';
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="city-index">
    <?php
    // Определение города пользователя по IP
    // $ip = Yii::$app->request->userIP;
    $ip = '78.85.5.98';
    $city = null;
    $request = file_get_contents('http://ipwho.is/' . $ip . '?lang=ru');
    $request = json_decode($request, true);
    if ($request['success']) {
        $city = $request['city'];
    } else {
        $city = null;
    }


    $session = Yii::$app->session;

    if ($session->has('city') && $session->get('city_timestamp') >= time() -  2 * 3600 ) {
        $city = $session->get('city');
    } else {
        Modal::begin([
            'options' => [
                'id' => 'cityModal',
                'style' => 'font-size: 20px; text-align: center'
            ],
            'size' => Modal::SIZE_SMALL
        ]);

        echo '<p>Ваш город: ' . $city . ' <img src=' . $request['flag']['img'] .' width="15" height="10" alt="">?</p>';

        echo Html::button("Да", ['class' => 'btn btn-primary', 'style' => 'margin-right: 5px', 'id' => 'yes']);
        echo Html::button("Нет", ['class' => 'btn btn-primary', 'id' => 'no']);

        Modal::end();

        $this->registerJs("
            $('#cityModal').modal('show');

            $('#yes').click(() => {
                var city = '{$city}';
                window.location.href = '" . Url::to(['index']) . "';
                $('#cityModal').modal('hide');
                // Store the city information and timestamp in the session
                $.ajax({
                    url: '" . Url::to(['store-city-in-session']) . "',
                    type: 'POST',
                    data: { city: city, timestamp: " . time() . " },
                });
            });

            $('#no').click(() => {
                $('#cityModal').modal('hide');
                // Show modal to choose from all cities in Russia
                $('#cityListModal').modal('show');
            });

            $(document).on('click', '.choose-city', function(e) {
                e.preventDefault();
                var city = $(this).data('city');
                window.location.href = '" . Url::to(['feedback/index']) . "?city=' + city;
            });
        ");
    }
    ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    // Получение списка всех городов из базы данных
    $cities = City::find()->orderBy(['name' => SORT_ASC])->all();
    if (!empty($cities)) {
        echo '<h2>Список городов:</h2>';
        echo '<ul>';
        foreach ($cities as $city) {
            echo '<li>' . Html::a(Html::encode($city->name), ['city', 'cityId' => $city->id, 'cityName' => $city->name], ['class' => 'btn btn-link']) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Нет доступных городов с отзывами.</p>';
    }
    ?>
</div>

<!-- Modal for city list -->
<div class="modal" id="cityListModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Выберите ваш город</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <?php
                    foreach ($cities as $city) {
                        echo '<li><a href="#" class="choose-city" data-city="' . Html::encode($city->name) . '">' . Html::encode($city->name) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
