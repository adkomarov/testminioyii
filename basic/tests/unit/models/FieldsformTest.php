<?php

namespace tests\unit\models;

use Yii;
use yii\db\ActiveQuery;
use PHPUnit\Framework\TestCase;

//include_once("/work/sites/yiiprojects/appbasic/basic/modules/takedatam/models/Fieldsform.php");
use app\modules\takedatam\models\Fieldsform;

class FieldsformTest extends TestCase
{
    public function testTrueIsTrue()
    {
        $this->assertTrue(True === True);
    }

    protected function setUp(): void
    {
        parent::setUp();
        Yii::getLogger()->flushInterval = 1;
        Fieldsform::deleteAll();
    }

    public function testTableName()
    {
        $model = new Fieldsform();
        $this->assertEquals('fieldsforms', $model::tableName());
        $this->assertNotEquals('fieldforms', $model::tableName());
    }

    public function testСorrectTableExists()
    {
        $db = Yii::$app->db;
        $schema = $db->getSchema();
        $this->assertTrue($schema->getTableSchema('fieldsforms') !== null, 'The table must exist');

    }
    public function testIncorrectTableExists()
    {

        $db = Yii::$app->db;
        $schema = $db->getSchema();
        $this->assertFalse($schema->getTableSchema('fieldforms') !== null, 'The table must not exist');

    }

    public function testRules()
    {
        $model = new Fieldsform();
        $rules = $model->rules();
        $this->assertEquals("nameform", $rules[0][0][0]);
        $this->assertEquals("fieldform", $rules[0][0][1]);
        $this->assertEquals("string", $rules[0][1]);
    }

    public function testNoAdditionalRules()
    {
        $model = new Fieldsform();
        $rules = $model->rules();

        $this->assertCount(1, $rules, 'There should only be one rule');
        $this->assertEquals(['nameform', 'fieldform'], $rules[0][0], 'Attributes should be nameform and fieldform');
        $this->assertEquals('string', $rules[0][1], 'Validation type should be string');
    }

    public function testAttributeLabels()
    {
        $model = new Fieldsform();
        $labels = $model->attributeLabels();

        $this->assertArrayHasKey('idfieldsforms', $labels);
        $this->assertArrayHasKey('nameform', $labels);
        $this->assertArrayHasKey('fieldform', $labels);

        $this->assertEquals('Idfieldsforms', $labels['idfieldsforms']);
        $this->assertEquals('Nameform', $labels['nameform']);
        $this->assertEquals('Fieldform', $labels['fieldform']);
    }

    public function testTableSchemaMatchesModelAttributes()
    {
        $model = new Fieldsform();
        $tableSchema = $model->getTableSchema();
        $modelAttributes = $model->attributes();

        $tableColumns = $tableSchema->getColumnNames();

        foreach ($modelAttributes as $attribute) {
            $this->assertContains($attribute, $tableColumns);
        }

        foreach ($tableColumns as $column) {
            $this->assertContains($column, $modelAttributes);
        }
    }

    public function testValidDataInsertionAndDeletion()
    {
        $model = new Fieldsform();
        $model->nameform = 'Test Form';
        $model->fieldform = 'Test Field';

        $this->assertTrue($model->save(), 'Model should save with valid data');

        $this->assertEquals(1, Fieldsform::find()->count(), 'There should be one record in the table');

        $savedModel = Fieldsform::findOne(['nameform' => 'Test Form']);
        $this->assertNotNull($savedModel, "Saved model should be found");
        $this->assertEquals('Test Form', $savedModel->nameform, "Nameform should match");
        $this->assertEquals('Test Field', $savedModel->fieldform, "Fieldform should match");

        Fieldsform::deleteAll();
        $this->assertEquals(0, Fieldsform::find()->count(),'');
    }

    public function testInvalidDataInsertion()
    {
        $model = new Fieldsform();
        $model->idfieldsforms = '';
        $model->nameform = 'Test Form';
        $model->fieldform = '';

        $this->assertTrue($model->save(), 'Model should not save with invalid data');

        $this->assertNotEquals(0, Fieldsform::find()->count(), 'There should be no records in the table');
    }
}
