<?php

use yii\db\Migration;

class m170207_163320_change_type_shares extends Migration
{
    public function up()
    {
        $this->alterColumn ('{{%shares}}', 'from', $this->dateTime() );
        $this->alterColumn ('{{%shares}}', 'to', $this->dateTime() );
    }

    public function down()
    {
        $this->alterColumn ('{{%shares}}', 'from', $this->string() );
        $this->alterColumn ('{{%shares}}', 'to', $this->string() );
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
