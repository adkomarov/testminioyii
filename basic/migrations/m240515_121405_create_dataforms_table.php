<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dataforms}}`.
 */
class m240515_121405_create_dataforms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dataforms}}', [
            'iddataforms' => $this->primaryKey(),
            'namefildsforms' => $this->string()->notNull(),
            'datafilds' => $this->string(255),
        ]);

        $this->createIndex(
            'idx-dataforms-iddataforms',
            '{{%dataforms}}',
            'iddataforms'
        );

        // Добавление внешних ключей для связей с другими таблицами
        $this->addForeignKey(
            'fk-form2addres-iddataforms',
            '{{%form2addres}}',
            'iddataforms',
            '{{%dataforms}}',
            'iddataforms',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-form2email-iddataforms',
            '{{%form2email}}',
            'iddataforms',
            '{{%dataforms}}',
            'iddataforms',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаление внешних ключей
        $this->dropForeignKey('fk-form2addres-iddataforms', '{{%form2addres}}');
        $this->dropForeignKey('fk-form2email-iddataforms', '{{%form2email}}');

        // Удаление индекса
        $this->dropIndex('idx-dataforms-iddataforms', '{{%dataforms}}');

        // Удаление таблицы
        $this->dropTable('{{%dataforms}}');
    }
}
