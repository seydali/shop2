<?php

use yii\db\Migration;

class m160930_163815_add_product_name extends Migration
{
    public function up()
    {
        $this->addColumn('{{%products}}', 'name',
            $this->double()->notNull()
        );
        $this->renameColumn ( '{{%os_links}}', 'osq_id', 'os_id' );
    }

    public function down()
    {
        $this->dropColumn('{{%products}}', 'name');
        $this->renameColumn ( '{{%os_links}}', 'os_id', 'osq_id' );
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
