<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Review extends ActiveRecord
{
    public $city_name;
    public static function tableName()
    {
        return 'reviews';
    }

    public function rules()
    {
        return [
            [['id_city', 'title', 'text', 'rating'], 'required'],
            [['text'], 'string'],
            [['rating'], 'integer', 'min' => 1, 'max' => 5],
            [['title'], 'string', 'max' => 255],
            [['img'], 'file', 'extensions' => 'jpg, png', 'maxSize' => 1024 * 1024],
            [['id_city', 'id_author'], 'integer'],
            [['date_create'], 'safe'],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            return true;
        }
        return false;
    }

    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'id_city']);
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'id_author']);
    }
}