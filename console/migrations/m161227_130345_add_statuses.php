<?php

use yii\db\Migration;

class m161227_130345_add_statuses extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user_statuses}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ], $tableOptions);
        $this->createTable('{{%user_stat_links}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'status_id' => $this->integer(),
        ], $tableOptions);
        $this->createTable('{{%order_statuses}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ], $tableOptions);
        $this->createTable('{{%order_stat_links}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'status_id' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%user_statuses}}');
        $this->dropTable('{{%user_stat_links}}');

        $this->dropTable('{{%order_statuses}}');
        $this->dropTable('{{%order_stat_links}}');
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
