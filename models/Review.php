<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Review extends ActiveRecord
{
    public $imageFile;

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
            [['id_city', 'id_author'], 'integer'],
            [['date_create'], 'safe'],
            [['imageFile'], 'file', 'extensions' => 'jpg, png', 'maxSize' => 1024 * 1024],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->date_create = date('Y-m-d H:i:s');
            }
            $this->img = preg_replace('#^images/#', '', $this->img);
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
    public function updateReview(Review $review)
    {
        if (!$this->validate()) {
            return false;
        }

        $review->title = $this->title;
        $review->text = $this->text;
        $review->rating = $this->rating;

        $review->imageFile = UploadedFile::getInstance($this, 'img');
        if ($review->imageFile) {
            $imageName = Yii::$app->security->generateRandomString(12);
            $review->img = 'images/' . $imageName . '.' . $review->imageFile->extension;
        }

        return $review->save();
    }
}
