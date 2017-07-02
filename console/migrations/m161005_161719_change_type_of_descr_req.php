<?php

use yii\db\Migration;

class m161005_161719_change_type_of_descr_req extends Migration
{
    public function up()
    {
        $this->alterColumn ('{{%products}}', 'description', $this->text() );
        $this->alterColumn ('{{%products}}', 'system_requirements', $this->text() );
    }

    public function down()
    {
        $this->alterColumn ('{{%products}}', 'description', $this->string() );
        $this->alterColumn ('{{%products}}', 'system_requirements', $this->string() );
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
