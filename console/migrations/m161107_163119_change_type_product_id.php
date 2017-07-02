<?php

use yii\db\Migration;

class m161107_163119_change_type_product_id extends Migration
{
    public function up()
    {
        $this->alterColumn ('{{%user_basket}}', 'id_product', $this->integer() );
    }

    public function down()
    {
        $this->alterColumn ('{{%user_basket}}', 'id_product', $this->string() );
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
