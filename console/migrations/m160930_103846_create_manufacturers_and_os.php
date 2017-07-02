<?php

use yii\db\Migration;

class m160930_103846_create_manufacturers_and_os extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%manufacturers}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->string(),
        ], $tableOptions);
        $this->createTable('{{%manufacturers_links}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'manufacturer_id' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createTable('{{%os}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->string(),
        ], $tableOptions);
        $this->createTable('{{%os_links}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'osq_id' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%os}}');
        $this->dropTable('{{%os_links}}');
        $this->dropTable('{{%manufacturers}}');
        $this->dropTable('{{%manufacturers_links}}');
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
