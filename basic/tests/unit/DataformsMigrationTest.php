<?php

namespace tests\unit;

use app\modules\takedatam\models\Dataforms;
use Yii;
use yii\db\Schema;
use Codeception\Test\Unit;

class DataformsMigrationTest extends Unit
{
    
    public function testDataformsTableSchema()
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema('dataforms');

        $this->assertNotNull($tableSchema, 'Таблица "dataforms" не найдена в базе данных.');

        $this->assertArrayHasKey('id', $tableSchema->columns, 'Поле "id" отсутствует.');
        $this->assertTrue($tableSchema->columns['id']->isPrimaryKey, 'Поле "id" должно быть первичным ключом.');
        
        $this->assertArrayHasKey('titel', $tableSchema->columns, 'Поле "titel" отсутствует.');
        $this->assertEquals(Schema::TYPE_TEXT, $tableSchema->columns['titel']->type, 'Поле "titel" должно быть текстовым.');

        $this->assertArrayHasKey('data', $tableSchema->columns, 'Поле "data" отсутствует.');
        $this->assertEquals(Schema::TYPE_TEXT, $tableSchema->columns['data']->type, 'Поле "data" должно быть текстовым.');
        $this->assertNull($tableSchema->columns['data']->defaultValue, 'Поле "data" должно иметь значение по умолчанию null.');
        
        $this->assertArrayHasKey('fieldsforms_id', $tableSchema->columns, 'Поле "fieldsforms_id" отсутствует.');
        $this->assertEquals(Schema::TYPE_INTEGER, $tableSchema->columns['fieldsforms_id']->type, 'Поле "fieldsforms_id" должно быть целочисленным.');
        
        $this->assertArrayHasKey('enabled', $tableSchema->columns, 'Поле "enabled" отсутствует.');
        $this->assertEquals(Schema::TYPE_TINYINT, $tableSchema->columns['enabled']->type, 'Поле "enabled" должно быть целочисленным.');
        $this->assertTrue($tableSchema->columns['enabled']->unsigned, 'Поле "enabled" должно быть беззнаковым.');
        $this->assertEquals(1, $tableSchema->columns['enabled']->defaultValue, 'Поле "enabled" должно иметь значение по умолчанию 1.');
        
        $this->assertArrayHasKey('position', $tableSchema->columns, 'Поле "position" отсутствует.');
        $this->assertEquals(Schema::TYPE_TEXT, $tableSchema->columns['position']->type, 'Поле "position" должно быть текстовым.');
        $this->assertNull($tableSchema->columns['position']->defaultValue, 'Поле "position" должно иметь значение по умолчанию null.');

        $this->assertArrayHasKey('created_at', $tableSchema->columns, 'Поле "created_at" отсутствует.');
        $this->assertEquals(Schema::TYPE_DATETIME, $tableSchema->columns['created_at']->type, 'Поле "created_at" должно быть datetime.');
        $this->assertEquals('CURRENT_TIMESTAMP', $tableSchema->columns['created_at']->defaultValue, 'Поле "created_at" должно иметь значение по умолчанию CURRENT_TIMESTAMP.');

        $this->assertArrayHasKey('updated_at', $tableSchema->columns, 'Поле "updated_at" отсутствует.');
        $this->assertEquals(Schema::TYPE_DATETIME, $tableSchema->columns['updated_at']->type, 'Поле "updated_at" должно быть datetime.');
        $this->assertNull($tableSchema->columns['updated_at']->defaultValue, 'Поле "updated_at" должно иметь значение по умолчанию null.');
    }

    public function testDataformsModel()
    {

        $model = new Dataforms();
        $model->titel = 'Test Title';
        $model->fieldsforms_id = 1; // Надо заменить на реальный id записи в таблице fieldsforms
        $model->enabled = 1;
        $model->data = 'Test Data';
        $model->position = 'Test Position';
        $model->created_at = date('Y-m-d H:i:s');

        $this->assertTrue($model->validate(), 'Модель Dataforms не прошла валидацию.');

        $model->save(false);

        $savedModel = Dataforms::findOne($model->id);

        $this->assertNotNull($savedModel, 'Модель Dataforms не была сохранена.');
        $this->assertEquals($model->titel, $savedModel->titel, 'Поле "titel" не соответствует сохраненному значению.');
        $this->assertEquals($model->fieldsforms_id, $savedModel->fieldsforms_id, 'Поле "fieldsforms_id" не соответствует сохраненному значению.');
        $this->assertEquals($model->enabled, $savedModel->enabled, 'Поле "enabled" не соответствует сохраненному значению.');
        $this->assertEquals($model->data, $savedModel->data, 'Поле "data" не соответствует сохраненному значению.');
        $this->assertEquals($model->position, $savedModel->position, 'Поле "position" не соответствует сохраненному значению.');
        $this->assertEquals($model->created_at, $savedModel->created_at, 'Поле "created_at" не соответствует сохраненному значению.');

        $model->delete();
    }
}
