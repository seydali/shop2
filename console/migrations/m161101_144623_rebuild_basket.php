<?php

use yii\db\Migration;

class m161101_144623_rebuild_basket extends Migration
{
    public function up()
    {
        $this->alterColumn ('{{%user_basket}}', 'hash_product', $this->integer() );
        $this->renameColumn('{{%user_basket}}','hash_product','count');
    }

    public function down()
    {
        $this->alterColumn ('{{%user_basket}}', 'hash_product', $this->string() );
        $this->renameColumn('{{%user_basket}}','count','hash_product');
        return false;
    }
}
