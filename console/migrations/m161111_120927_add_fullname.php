<?php

use yii\db\Migration;

class m161111_120927_add_fullname extends Migration
{
    public function up()
    {
        $this->addColumn ('{{%user}}', 'fullname', $this->string());
    }

    public function down()
    {
        $this->dropColumn ('{{%user}}', 'fullname');
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
