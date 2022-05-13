<?php

use yii\db\Migration;

/**
 * Class m220513_011523_create_table_feedback
 */
class m220513_011523_create_table_feedback extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('feedback', [
            'id' => $this->primaryKey(),
            'email' => $this->string(32)->notNull(),
            'phone' => $this->string(11),
            'name' => $this->string(32),
            'text' => $this->text()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220513_011523_create_table_feedback cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220513_011523_create_table_feedback cannot be reverted.\n";

        return false;
    }
    */
}
