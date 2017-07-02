<?php

use yii\db\Migration;

class m170208_143440_add_prod_oldprice extends Migration
{
    public function up()
    {
        $this->addColumn ('{{%products}}', 'oldprice', $this->double());
    }

    public function down()
    {
        $this->dropColumn ('{{%products}}', 'oldprice');
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
