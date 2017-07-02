<?php

use yii\db\Migration;

class m170126_152657_create_shares_shares_links extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%shares}}', [
            'id' => $this->primaryKey(),
            'title' => $this->String(),
            'duration' => $this->String(),
            'icon'=>$this->String(),
            'created_at' => $this->timestamp(),
        ], $tableOptions);
        $this->createTable('{{%shares_links}}', [
            'id' => $this->primaryKey(),
            'id_share' => $this->integer(),
            'id_product' => $this->integer(),
            'discount'=>$this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%shares_links}}');
        $this->dropTable('{{%shares}}');
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
