<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m220507_111130_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'isbn' => $this->string(16),
            'title' => $this->string(256)->notNull(),            
            'thumbnail_url' => $this->string(256),
            'short_description' => $this->text(),
            'long_description' => $this->text(),
            'status' => $this->integer(1),
            'authors' => $this->string(255),
            'page_count' => $this->integer(4)
        ]);

        $this->addPrimaryKey('PK_book_isbn', '{{%book}}', 'isbn');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book}}');
    }
}
