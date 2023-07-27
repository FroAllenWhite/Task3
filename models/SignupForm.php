<?php

namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $email;
    public $password;
    public $phone;
    public $password1;

    public function rules()
    {
        return [
            [['email', 'password', 'phone', 'password1'], 'required'],
            ['email', 'email'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
            'phone' => 'Номер телефона',
            'password1' => 'Повторите пароль',
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->password !== $this->password1) {
                $this->addError($attribute, 'Пароли не совпадают.');
            }
        }
    }

    public function signup()
    {
        if ($this->validate()) {

            return true;
        }

        return false;
    }
}