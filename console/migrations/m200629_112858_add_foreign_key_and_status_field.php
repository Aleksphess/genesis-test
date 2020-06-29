<?php

use yii\db\Migration;

/**
 * Class m200629_112858_add_foreign_key_and_status_field
 */
class m200629_112858_add_foreign_key_and_status_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-article-category_id',
            'articles',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );

        $this->addColumn('articles', 'status', $this->string(20)->defaultValue('new'));
        $this->addColumn('categories', 'status', $this->string(20)->defaultValue('new'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('articles', 'status');
        $this->dropColumn('categories', 'status');

        $this->dropForeignKey('fk-article-category_id', 'articles');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200629_112858_add_foreign_key_and_status_field cannot be reverted.\n";

        return false;
    }
    */
}
