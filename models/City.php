<?php

namespace app\models;

use Yii;

class City extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'cities';
    }

    public function rules()
    {
        return [
            [['date_create'], 'required'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название города',
            'date_create' => 'Дата добавления',
        ];
    }

    // Один город имеет множество отзывов
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['id_city' => 'id']);
    }
}
