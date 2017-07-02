<?php

use yii\db\Migration;

class m161115_153219_add_orderslinks_price_count extends Migration
{
    public function up()
    {
        $this->addColumn ('{{%orders_links}}', 'price', $this->integer());
        $this->addColumn ('{{%orders_links}}', 'count', $this->integer());
    }

    public function down()
    {
        $this->dropColumn ('{{%orders_links}}', 'price');
        $this->dropColumn ('{{%orders_links}}', 'count');
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
