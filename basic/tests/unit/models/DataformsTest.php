<?php

namespace tests\unit\models;

use Yii;
use yii\db\ActiveQuery;
use PHPUnit\Framework\TestCase;

use app\modules\takedatam\models\Dataforms;


class DataformsTest extends TestCase
{
    public function testTrueIsTrue()
    {
        $this->assertTrue(True === True);
    }

    protected function setUp(): void
    {
        parent::setUp();
        Yii::getLogger()->flushInterval = 1;
        Dataforms::deleteAll();
    }

    public function testTableName()
    {
        $model = new Dataforms();
        $this->assertEquals('dataforms', $model::tableName());
        $this->assertNotEquals('datasforms', $model::tableName());
    }

    public function testСorrectTableExists()
    {
        $db = Yii::$app->db;
        $schema = $db->getSchema();
        $this->assertTrue($schema->getTableSchema('dataforms') !== null, 'The table must exist');

    }
    public function testIncorrectTableExists()
    {

        $db = Yii::$app->db;
        $schema = $db->getSchema();
        $this->assertFalse($schema->getTableSchema('datasforms') !== null, 'The table must not exist');

    }

    public function testRules()
    {
        $model = new Dataforms();
        $rules = $model->rules();

        // Проверка количества правил
        $this->assertCount(5, $rules, 'There should be exactly 5 rules');

        // Проверка каждого правила
        $this->assertEquals(['namefildsforms'], $rules[0][0], 'First rule should be for namefildsforms');
        $this->assertEquals('required', $rules[0][1], 'First rule should be required');

        $this->assertEquals(['variable'], $rules[1][0], 'Second rule should be for variable');
        $this->assertEquals('required', $rules[1][1], 'Second rule should be required');

        $this->assertEquals(['variable'], $rules[2][0], 'Third rule should be for variable');
        $this->assertEquals('number', $rules[2][1], 'Third rule should be number');

        $this->assertEquals(['datafilds'], $rules[3][0], 'Fourth rule should be for datafilds');
        $this->assertEquals('required', $rules[3][1], 'Fourth rule should be required');

        $this->assertEquals(['datafilds'], $rules[4][0], 'Fifth rule should be for datafilds');
        $this->assertEquals('url', $rules[4][1], 'Fifth rule should be url');
        $this->assertEquals('Это не ссылка', $rules[4]['message'], 'Fifth rule should have the correct message');
    }
    public function testAttributeLabels()
    {
        $model = new Dataforms();
        $labels = $model->attributeLabels();

        $this->assertArrayHasKey('iddataforms', $labels);
        $this->assertArrayHasKey('namefildsforms', $labels);
        $this->assertArrayHasKey('datafilds', $labels);
        $this->assertArrayHasKey('variable', $labels);

        $this->assertEquals('Iddataforms', $labels['iddataforms']);
        $this->assertEquals('Namefildsforms', $labels['namefildsforms']);
        $this->assertEquals('Datafilds', $labels['datafilds']);
        $this->assertEquals('Variable', $labels['variable']);
    }

    public function testTableSchemaMatchesModelAttributes()
    {
        $model = new Dataforms();
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

    public function testValidData()
    {
        $model = new Dataforms();
        $model->namefildsforms = 'Test Name';
        $model->datafilds = 'http://example.com';
        $model->variable = 123;

        $this->assertTrue($model->validate(), 'Model should be valid with correct data');
    }

    public function testMissingRequiredFields()
    {
        $model = new Dataforms();

        // Проверка на отсутствие обязательного поля 'namefildsforms'
        $model->datafilds = 'http://example.com';
        $model->variable = 123;
        $this->assertFalse($model->validate(), 'Model should not be valid without namefildsforms');

        // Проверка на отсутствие обязательного поля 'datafilds'
        $model->namefildsforms = 'Test Name';
        $model->datafilds = null;
        $this->assertFalse($model->validate(), 'Model should not be valid without datafilds');

        // Проверка на отсутствие обязательного поля 'variable'
        $model->datafilds = 'http://example.com';
        $model->variable = null;
        $this->assertFalse($model->validate(), 'Model should not be valid without variable');
    }

    public function testInvalidData()
    {
        $model = new Dataforms();

        // Проверка на неправильный формат 'datafilds' (не URL)
        $model->namefildsforms = 'Test Name';
        $model->datafilds = 'not_a_url';
        $model->variable = 123;
        $this->assertFalse($model->validate(), 'Model should not be valid with invalid datafilds');

        // Проверка на неправильный тип 'variable' (не число)
        $model->datafilds = 'http://example.com';
        $model->variable = 'not_a_number';
        $this->assertFalse($model->validate(), 'Model should not be valid with invalid variable');
    }
    public function testSaveAndDeleteDataforms()
    {
        $model = new Dataforms();
        $model->namefildsforms = 'Test Name';
        $model->datafilds = 'http://example.com';
        $model->variable = 123;

        // Сохранение данных
        $this->assertTrue($model->save(), 'Model should save with valid data');

        // Проверка, что данные сохранены корректно
        $savedModel = Dataforms::findOne($model->iddataforms);
        $this->assertNotNull($savedModel, 'Saved model should be found');
        $this->assertEquals('Test Name', $savedModel->namefildsforms, 'Namefildsforms should match');
        $this->assertEquals('http://example.com', $savedModel->datafilds, 'Datafilds should match');
        $this->assertEquals(123, $savedModel->variable, 'Variable should match');

        // Удаление данных
        $model->delete();

        // Проверка, что таблица пуста
        $this->assertEquals(0, Dataforms::find()->count(), 'Table should be empty after deletion');
    }
}
