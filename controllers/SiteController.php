<?php

namespace app\controllers;

use app\models\City;
use app\models\LoginForm;
use app\models\Review;
use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\debug\models\search\Log;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testime' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->set('userLoggedIn', true);
            Yii::$app->session->set('userId', Yii::$app->user->identity->id);
            Yii::$app->session->set('userFio', Yii::$app->user->identity->fio);

            return $this->redirect(['index']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->session->remove('userLoggedIn');
        Yii::$app->session->remove('userId');
        Yii::$app->session->remove('userFio');

        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->session->set('captcha', $model->verifyCode);
            if ($this->validateCaptcha($model->verifyCode)) {
                if ($model->signup()) {
//                    $activationCode = Yii::$app->security->generateRandomString(8);
//                    $this->sendActivationEmail($model->email, $activationCode);

                    return $this->redirect(['login']);
                }
            } else {
                $model->addError('verifyCode', 'Неверный код с картинки.');
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

//    /**
//     *
//     * @param string $email
//     * @param string $activationCode
//     */
//    protected function sendActivationEmail($email, $activationCode)
//    {
//        $subject = 'Активация аккаунта';
//        $message = 'Код активации: ' . $activationCode;
//        Yii::$app->mailer->compose()
//            ->setTo($email)
//            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
//            ->setSubject($subject)
//            ->setTextBody($message)
//            ->send();
//    }

    /**
     *
     *
     * @param string $code
     * @return bool
     * @throws BadRequestHttpException
     */
    protected function validateCaptcha($code)
    {
        $session = Yii::$app->session;
        $captchaSessionValue = $session->get('captcha');

        if ($captchaSessionValue === null || $captchaSessionValue !== $code) {
            throw new BadRequestHttpException('Неверный код с картинки.');
        }

        $session->remove('captcha');

        return true;
    }

    public function actionCheckCity()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $city = Yii::$app->request->post('city');
        $exists = City::find()->where(['name' => $city])->exists();
        return ['exists' => $exists];
    }

    public function actionAddCity()
    {
        $city = Yii::$app->request->post('city');


        var_dump($city);


        if (!empty($city)) {
            $newCity = new City(['name' => $city, 'date_create' => date('Y-m-d H:i:s')]);
            $newCity->save();
        } else {
            throw new \yii\web\BadRequestHttpException('Пустое значение города');
        }
    }

    public function actionStoreCityInSession()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $city = Yii::$app->request->post('city');
        $timestamp = Yii::$app->request->post('timestamp');

        $session = Yii::$app->session;
        $session->set('city', $city);
        $session->set('city_timestamp', $timestamp);

        return ['success' => true];
    }
    public function actionAllCitiesModal()
    {
        return $this->renderAjax('_all_cities_modal');
    }
    public function actionCity($cityId)
    {
        $city = City::findOne($cityId);

        if (!$city) {
            throw new \yii\web\NotFoundHttpException('Город не найден.');
        }

        $cityList = City::find()->orderBy(['name' => SORT_ASC])->all();
        $model = new Review();

        return $this->render('city', [
            'cityName' => $city->name,
            'model' => $model,
            'cityList' => $cityList,
        ]);
    }

    public function actionSubmitReview()
    {
        $model = new Review();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $selectedCityId = $model->id_city;
            $city = City::findOne($selectedCityId);

            if (!$city) {
                throw new \yii\web\NotFoundHttpException('Город не найден.');
            }
            $model->id_author = Yii::$app->user->identity->id;

            if ($model->save()) {
                Yii::$app->session->setFlash('reviewSubmitted', 'Ваш отзыв отправлен');
                return $this->redirect(['index']);
            }
        }

        $cityList = City::find()->orderBy(['name' => SORT_ASC])->all();

        return $this->render('city', [
            'model' => $model,
            'cityList' => $cityList,
        ]);
    }

}
