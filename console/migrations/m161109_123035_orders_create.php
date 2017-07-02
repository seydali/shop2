<?php
use yii\db\Schema;
use yii\db\Migration;

class m161109_123035_orders_create extends Migration
{
    public function up()
    {
        {
            $this->createTable('{{%orders}}', [
                'id' => Schema::TYPE_PK,
                'id_user' => Schema::TYPE_INTEGER . ' NOT NULL',
                'sum' => Schema::TYPE_STRING . ' NOT NULL',
                'count' => Schema::TYPE_STRING . '(32) NOT NULL',
                'status' => Schema::TYPE_INTEGER,
                'params' => Schema::TYPE_STRING,
                'created_at' => $this->timestamp(),
                'updated_at' => $this->timestamp(),
            ]);
        }
    }

    public function down()
    {
        $this->dropTable('{{%orders}}');
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
