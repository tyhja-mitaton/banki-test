<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%parameter}}`.
 */
class m240723_144806_create_parameter_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%parameter}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'type' => $this->integer()->notNull(),
            'icon_path' => $this->string(),
            'icon_original_name' => $this->string(),
            'icon_gray_path' => $this->string(),
            'icon_gray_original_name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%parameter}}');
    }
}
