<?php

use yii\db\Migration;

class m161114_113228_add_user_address extends Migration
{
    public function up()
    {
        $this->addColumn ('{{%user}}', 'address', $this->string());
    }

    public function down()
    {
        $this->dropColumn ('{{%user}}', 'address');
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
