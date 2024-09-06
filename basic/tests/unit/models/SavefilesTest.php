<?php

namespace tests\unit\models;

use Yii;
use yii\db\ActiveQuery;
use PHPUnit\Framework\TestCase;

use app\modules\takedatam\models\Savefiles;


class SavefilesTest extends TestCase
{
    public function testTrueIsTrue()
    {
        $this->assertTrue(True === True);
    }

    protected function setUp(): void
    {
        parent::setUp();
        Yii::getLogger()->flushInterval = 1;
        Savefiles::deleteAll();
    }

    public function testTableName()
    {
        $model = new Savefiles();
        $this->assertEquals('savefiles', $model::tableName());
        $this->assertNotEquals('savesfiles', $model::tableName());
    }

    public function testСorrectTableExists()
    {
        $db = Yii::$app->db;
        $schema = $db->getSchema();
        $this->assertTrue($schema->getTableSchema('savefiles') !== null, 'The table must exist');

    }
    public function testIncorrectTableExists()
    {

        $db = Yii::$app->db;
        $schema = $db->getSchema();
        $this->assertFalse($schema->getTableSchema('savesfiles') !== null, 'The table must not exist');

    }

    public function testRules()
    {
        $model = new Savefiles();
        $rules = $model->rules();

        // Проверка количества правил
        $this->assertCount(4, $rules, 'There should be exactly 4 rules');

        // Проверка каждого правила
        $this->assertEquals(['Titel', 'NameFile'], $rules[0][0], 'First rule should be for Titel and NameFile');
        $this->assertEquals('required', $rules[0][1], 'First rule should be required');

        $this->assertEquals(['Titel', 'NameFile', 'Position'], $rules[1][0], 'Second rule should be for Titel, NameFile, and Position');
        $this->assertEquals('string', $rules[1][1], 'Second rule should be string');

        $this->assertEquals('Position', $rules[2][0], 'Third rule should be for Position');
        $this->assertEquals('match', $rules[2][1], 'Third rule should be match');
        $this->assertEquals('/^[a-zA-Z0-9_-]{31,32}$/', $rules[2]['pattern'], 'Third rule should have the correct pattern');

        $this->assertEquals('Link', $rules[3][0], 'Fourth rule should be for Link');
        $this->assertEquals('match', $rules[3][1], 'Fourth rule should be match');
        $this->assertEquals('/^http:\/\/192.168.33.23:9000\/testbucket\/[a-zA-Z0-9_-]{31,32}$/', $rules[3]['pattern'], 'Fourth rule should have the correct pattern');
    }
    public function testAttributeLabels()
    {
        $model = new Savefiles();
        $labels = $model->attributeLabels();

        $this->assertArrayHasKey('idsavefiles', $labels);
        $this->assertArrayHasKey('Titel', $labels);
        $this->assertArrayHasKey('NameFile', $labels);
        $this->assertArrayHasKey('Link', $labels);
        $this->assertArrayHasKey('Position', $labels);

        $this->assertEquals('Idsavefiles', $labels['idsavefiles']);
        $this->assertEquals('Titel', $labels['Titel']);
        $this->assertEquals('Name File', $labels['NameFile']);
        $this->assertEquals('Link', $labels['Link']);
        $this->assertEquals('Position', $labels['Position']);
    }

    public function testTableSchemaMatchesModelAttributes()
    {
        $model = new Savefiles();
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

    public function testValidDataInsertion()
    {
        $model = new Savefiles();
        $model->Titel = 'Test Titel';
        $model->NameFile = 'Test NameFile';

        $model->Position = 'aBc123_-aBc123_-aBc123_-aBc123_-'; 
        
        $model->Link = 'http://192.168.33.23:9000/testbucket/aBc123_-aBc123_-aBc123_-aBc123_-';
        
        // Добавляем проверку на валидацию перед сохранением
        $this->assertTrue($model->validate(), 'Model should be valid with valid data');

        $this->assertTrue($model->save(), 'Model should save with valid data');

        // Проверка, что данные сохранены корректно
        $savedModel = Savefiles::findOne($model->idsavefiles);
        $this->assertNotNull($savedModel, 'Saved model should be found');
        $this->assertEquals('Test Titel', $savedModel->Titel, 'Titel should match');
        $this->assertEquals('Test NameFile', $savedModel->NameFile, 'NameFile should match');
        $this->assertEquals('aBc123_-aBc123_-aBc123_-aBc123_-', $savedModel->Position, 'Position should match');
        $this->assertEquals('http://192.168.33.23:9000/testbucket/aBc123_-aBc123_-aBc123_-aBc123_-', $savedModel->Link, 'Link should match');
    }

    public function testInvalidDataInsertion()
    {
        $model = new Savefiles();

        // Проверка на отсутствие обязательного поля 'Titel'
        $model->NameFile = 'Test NameFile';
        $model->Position = 'aBc123_-aBc123_-aBc123_-aBc123_-aBc';
        $model->Link = 'http://192.168.33.23:9000/testbucket/aBc123_-aBc123_-aBc123_-aBc123_-aBc';
        $this->assertFalse($model->save(), 'Model should not save without Titel');

        // Проверка на отсутствие обязательного поля 'NameFile'
        $model->Titel = 'Test Titel';
        $model->NameFile = null;
        $this->assertFalse($model->save(), 'Model should not save without NameFile');

        // Проверка на неправильный формат 'Position'
        $model->NameFile = 'Test NameFile';
        $model->Position = 'invalid';
        $this->assertFalse($model->save(), 'Model should not save with invalid Position');

        // Проверка на неправильный формат 'Link'
        $model->Position = 'aBc123_-aBc123_-aBc123_-aBc123_-aBc';
        $model->Link = 'invalid_link';
        $this->assertFalse($model->save(), 'Model should not save with invalid Link');
    }

    public function testDataDeletion()
    {
        $model = new Savefiles();
        $model->Titel = 'Test Titel';
        $model->NameFile = 'Test NameFile';
        $model->Position = 'aBc123_-aBc123_-aBc123_-aBc123_-';
        $model->Link = 'http://192.168.33.23:9000/testbucket/aBc123_-aBc123_-aBc123_-aBc123_-';

        $this->assertTrue($model->save(), 'Model should save with valid data');

        // Удаление данных
        $model->delete();

        // Проверка, что таблица пуста
        $this->assertEquals(0, Savefiles::find()->count(), 'Table should be empty after deletion');
    }
}
/*
        if (!$model->validate()) {
            print_r($model->getErrors()); // Выводим ошибки валидации
        }
*/