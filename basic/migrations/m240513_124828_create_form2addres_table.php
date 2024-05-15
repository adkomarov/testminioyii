<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%form2addres}}`.
 */
class m240513_124828_create_form2addres_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%form2addres}}', [
            'idform2addres' => $this->primaryKey(),
            'addres' => $this->string(255),
            'iddataforms' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-form2addres-iddataforms',
            '{{%form2addres}}',
            'iddataforms'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-form2addres-iddataforms', '{{%form2addres}}');
        $this->dropTable('{{%form2addres}}');
    }
}


/*
<?php

use yii\db\Migration;

class m240513_124828_create_form2addres_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%form2addres}}', [
            'idform2addres' => $this->primaryKey(),
            'addres' => $this->string(255),
            'iddataforms' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-form2addres-iddataforms',
            '{{%form2addres}}',
            'iddataforms'
        );

        $this->addForeignKey(
            'fk-form2addres-iddataforms',
            '{{%form2addres}}',
            'iddataforms',
            '{{%dataforms}}',
            'iddataforms',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-form2addres-iddataforms', '{{%form2addres}}');
        $this->dropIndex('idx-form2addres-iddataforms', '{{%form2addres}}');
        $this->dropTable('{{%form2addres}}');
    }
}
*/
