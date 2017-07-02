<?php

use yii\db\Migration;

class m160929_160930_add_price_to_product extends Migration
{
    public function up()
    {
        $this->addColumn('{{%products}}', 'price',
            $this->double()->notNull()
        );
    }

    public function down()
    {
        $this->dropColumn('{{%products}}', 'price');
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
