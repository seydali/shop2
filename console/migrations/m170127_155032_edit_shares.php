<?php

use yii\db\Migration;

class m170127_155032_edit_shares extends Migration
{
    public function up()
    {
        $this->addColumn ('{{%shares}}', 'discount', $this->integer());
       //
    }

    public function down()
    {
        $this->dropColumn ('{{%shares}}', 'discount');
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
