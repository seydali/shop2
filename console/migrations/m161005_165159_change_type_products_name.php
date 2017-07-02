<?php

use yii\db\Migration;

class m161005_165159_change_type_products_name extends Migration
{
    public function up()
    {
        $this->alterColumn ('{{%products}}', 'name', $this->string() );

    }

    public function down()
    {
        $this->alterColumn ('{{%products}}', 'name', $this->double() );
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
