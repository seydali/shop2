<?php

use yii\db\Migration;

class m161115_160252_add_address_orders extends Migration
{
    public function up()
    {
        $this->addColumn ('{{%orders}}', 'address', $this->string());
    }

    public function down()
    {
        $this->dropColumn ('{{%orders}}', 'address');
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
