<?php

use yii\db\Migration;

class m160516_215224_evidences extends Migration
{
    public function up()
    {

        $this->createTable('evidence', array(
            'id' => 'pk',
            'title' => 'varchar(120) NOT NULL',
            //'type' => 'varchar(255) NOT NULL',
            //'main_content' => 'text NOT NULL',
            'text' => 'text NOT NULL',
            //'user_id' => 'int(11) NOT NULL',
            //'activities_id' => 'int(11) NOT NULL',
            'created_at' => 'datetime NOT NULL',
            'created_by' => 'int(11) NOT NULL',
            'updated_at' => 'datetime NOT NULL',
            'updated_by' => 'int(11) NOT NULL',
                ), '');

        /*$this->addForeignKey(
            'fk-evidence-user_id',
            'evidence',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
        */

        /*$this->addForeignKey(
            'fk-evidence-activities_id',
            'evidence',
            'activities_id',
            'activities',
            'id',
            'CASCADE'
        );
        */

    }

    public function down()
    {
        $this->dropTable('evidence');

        return true;
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
