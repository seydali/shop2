<?php
use yii\db\Schema;
use yii\db\Migration;

class m161021_101958_basket extends Migration
{
    public function up()
    {
        $this->createTable('{{%user_basket}}', [
            'id' => Schema::TYPE_PK,
            'id_user' => Schema::TYPE_INTEGER . ' NOT NULL',
            'id_product' => Schema::TYPE_STRING . ' NOT NULL',
            'hash_product' => Schema::TYPE_STRING . '(32) NOT NULL',
            'price' => Schema::TYPE_DECIMAL . '(10,2) NOT NULL DEFAULT 0',
            'params' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user_basket}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
