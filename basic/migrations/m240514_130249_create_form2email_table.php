<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%form2email}}`.
 */
class m240514_130249_create_form2email_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%form2email}}', [
            'idform2email' => $this->primaryKey(),
            'email' => $this->string(255),
            'iddataforms' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-form2email-iddataforms',
            '{{%form2email}}',
            'iddataforms'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-form2email-iddataforms', '{{%form2email}}');
        $this->dropTable('{{%form2email}}');
    }
}

/*
<?php

use yii\db\Migration;


class m240514_130249_create_form2email_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%form2email}}', [
            'idform2email' => $this->primaryKey(),
            'email' => $this->string(255),
            'iddataforms' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-form2email-iddataforms',
            '{{%form2email}}',
            'iddataforms'
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

    public function safeDown()
    {
        $this->dropForeignKey('fk-form2email-iddataforms', '{{%form2email}}');
        $this->dropIndex('idx-form2email-iddataforms', '{{%form2email}}');
        $this->dropTable('{{%form2email}}');
    }
}
*/