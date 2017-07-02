<?php

use yii\db\Migration;

class m170207_152009_add_shares_duration extends Migration
{
    public function up()
    {
        $this->addColumn ('{{%shares}}', 'from', $this->string());
        $this->addColumn ('{{%shares}}', 'to', $this->string());
        $this->addColumn ('{{%shares}}', 'status', $this->integer());
    }

    public function down()
    {
        $this->dropColumn ('{{%shares}}', 'from');
        $this->dropColumn ('{{%shares}}', 'to');
        $this->dropColumn ('{{%shares}}', 'status');
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
