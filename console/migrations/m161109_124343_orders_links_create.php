<?php
use yii\db\Schema;
use yii\db\Migration;

class m161109_124343_orders_links_create extends Migration
{
    public function up()
    {
        {
            $this->createTable('{{%orders_links}}', [
                'id' => Schema::TYPE_PK,
                'id_order' => Schema::TYPE_INTEGER . ' NOT NULL',
                'id_product' => Schema::TYPE_INTEGER . ' NOT NULL',
            ]);
        }
    }

    public function down()
    {
        $this->dropTable('{{%orders_links}}');
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
