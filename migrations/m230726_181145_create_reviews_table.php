<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reviews}}`.
 */
class m230726_181145_create_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('reviews', [
            'id' => $this->primaryKey(),
            'id_city' => $this->integer(),
            'title' => $this->string()->notNull(),
            'text' => $this->string()->notNull(),
            'rating' => $this->integer()->notNull(),
            'img' => $this->string(),
            'id_author' => $this->integer(),
            'date_create' => $this->dateTime(),
        ]);

        $this->addForeignKey(
            'fk_reviews_cities',
            'reviews',
            'id_city',
            'cities',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_reviews_users',
            'reviews',
            'id_author',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_reviews_cities', 'reviews');
        $this->dropForeignKey('fk_reviews_users', 'reviews');
        $this->dropTable('reviews');
    }
}
