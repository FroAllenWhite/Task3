<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m230726_180951_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'fio' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'phone' => $this->string(),
            'date_create' => $this->dateTime(),
            'password' => $this->string()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
