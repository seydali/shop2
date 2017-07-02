<?php

use yii\db\Migration;

class m161115_151454_change_column_type extends Migration
{
    public function up()
    {
        $this->alterColumn ('{{%orders}}', 'count', $this->integer() );
        $this->alterColumn ('{{%orders}}', 'sum', $this->integer() );
    }

    public function down()
    {
        $this->alterColumn ('{{%orders}}', 'count', $this->string() );
        $this->alterColumn ('{{%orders}}', 'sum', $this->string() );
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
