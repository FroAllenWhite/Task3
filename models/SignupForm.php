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

    public function rules()
    {
        return [
            [['fio', 'email', 'password', 'phone', 'password1'], 'required'],
            ['fio', 'string', 'max'=> 60, 'min' =>6],
            ['fio', 'fioPattern'],
            ['phone', 'phonePattern'],
            ['email', 'email'],
            ['password', 'string', 'min'=>8, 'max'=>30],
            ['password1', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
            ['phone', 'validateUniquePhone'],
            ['email', 'validateUniqueEmail'],
        ];
    }
    public function fioPattern($attribute, $params)
    {
        $pattern = '/^[а-яА-ЯёЁa-zA-Z\s-]+$/u'; // Регулярное выражение для проверки ФИО на наличие только букв.
        if (!preg_match($pattern, $this->$attribute)) {
            $this->addError($attribute, 'ФИО должно содержать только буквы.');
        }
    }

    public function phonePattern($attribute, $params)
    {
        $pattern = '/^(\+7|8)\d{10}$/'; // Регулярное выражение для проверки формата номера телефона.
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
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            return true;
        }

        return false;
    }
}