<?php

use yii\db\Migration;

class m161009_130933_create_image_and_image_links extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'path' => $this->string(),
            'description' => $this->string(),
        ], $tableOptions);
        $this->createTable('{{%images_links}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'image_id' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%images}}');
        $this->dropTable('{{%images_links}}');
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
