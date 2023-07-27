<?php

namespace app\models;

use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            'password' => [['password'], 'string', 'max' => 60, 'min' => 8],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }



    public function login()
    {
        if ($this->validate()) {
            return true;
        }

        return false;
    }
}