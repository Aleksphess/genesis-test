<?php

use yii\db\Migration;

class m200629_082527_create_articles_and_categories_table extends Migration
{
    public function safeUp()
    {
        $this->createTable(
            'categories',
            [
                'id' => $this->primaryKey(),
                'title' => $this->string(255)->defaultValue(''),
                'description' => $this->text(),
                'text' => $this->text(),
                'alias' => $this->string(100)->unique()->notNull(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'articles_counter' => $this->integer(),
            ]
        );

        $this->createIndex('idx-categories-alias', 'categories', 'alias');
        $this->createIndex('idx-categories-created_at', 'categories', 'created_at');
        $this->createIndex('idx-categories-updated_at', 'categories', 'updated_at');

        $this->createTable(
            'articles',
            [
                'id' => $this->primaryKey(),
                'title' => $this->string(255)->defaultValue(''),
                'description' => $this->text(),
                'text' => $this->text(),
                'alias' => $this->string(100)->unique()->notNull(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'category_id' => $this->integer()->notNull(),
            ]
        );

        $this->createIndex('idx-articles-alias', 'articles', 'alias');
        $this->createIndex('idx-articles-created_at', 'articles', 'created_at');
        $this->createIndex('idx-articles-updated_at', 'articles', 'updated_at');
    }

    public function safeDown()
    {
        $this->dropTable('categories');
        $this->dropTable('articles');
    }
}
