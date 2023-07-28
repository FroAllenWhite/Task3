<?php

namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $fio;
    public $email;
    public $password;
    public $phone;
    public $date_create;
    public $password1;
    public $verifyCode;
    public $activationCode;

    public function rules()
    {
        return [
            [['fio', 'email', 'password', 'phone', 'password1', 'verifyCode'], 'required'],
            ['fio', 'string', 'max' => 60, 'min' => 6],
            ['fio', 'fioPattern'],
            ['phone', 'phonePattern'],
            ['email', 'email'],
            ['password', 'string', 'min' => 8, 'max' => 30],
            ['password1', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
            ['phone', 'validateUniquePhone'],
            ['email', 'validateUniqueEmail'],
            ['verifyCode', 'captcha'],
            [['activationCode'], 'required', 'on' => 'activation'],
            [['activationCode'], 'string', 'length' => 8],
        ];
    }

    public function fioPattern($attribute, $params)
    {
        $pattern = '/^[а-яА-ЯёЁa-zA-Z\s-]+$/u';
        if (!preg_match($pattern, $this->$attribute)) {
            $this->addError($attribute, 'ФИО должно содержать только буквы.');
        }
    }

    public function phonePattern($attribute, $params)
    {
        $pattern = '/^(\+7|8)\d{10}$/';
        if (!preg_match($pattern, $this->$attribute)) {
            $this->addError($attribute, 'Номер телефона должен быть вида 8********** или +7**********.');
        }
    }

    public function validateUniquePhone($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findOne(['phone' => $this->phone]);
            if ($user !== null) {
                $this->addError($attribute, 'Номер телефона уже зарегистрирован.');
            }
        }
    }

    public function validateUniqueEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findOne(['email' => $this->email]);
            if ($user !== null) {
                $this->addError($attribute, 'Email уже зарегистрирован.');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'fio' => 'ФИО',
            'email' => 'Email',
            'password' => 'Пароль',
            'phone' => 'Номер телефона',
            'password1' => 'Повторите пароль',
            'verifyCode' => 'Введите код с картинки',
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->fio = $this->fio;
            $user->email = $this->email;
            $user->password = password_hash($this->password, PASSWORD_BCRYPT);
            $user->phone = $this->phone;
            $user->date_create = date('Y-m-d H:i:s');

            // Save the user record to the database
            if ($user->save()) {
                return true;
            }

            return false;
        }
        /**
         *
         * @param string $attribute
         * @param array $params
         */
//    public function validateActivationCode($attribute, $params)
//    {
//        if (!$this->hasErrors()) {
//            if ($this->activationCode !== 'ваш_сгенерированный_код_активации') {
//                $this->addError($attribute, 'Неверный код активации.');
//            }
//        }
//    }
    }
}