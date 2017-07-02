<?php

use yii\db\Migration;

class m170201_113245_add_descr_share extends Migration
{
    public function up()
    {
        $this->addColumn ('{{%shares}}', 'description', $this->string());
    }

    public function down()
    {
        $this->dropColumn ('{{%shares}}', 'description');
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
