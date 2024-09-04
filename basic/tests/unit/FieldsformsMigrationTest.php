<?php

namespace tests\unit;

use app\modules\takedatam\models\Fieldsforms;
use Yii;
use yii\db\Schema;
use Codeception\Test\Unit;

class FieldsformsMigrationTest extends Unit
{

    public function testFieldsformsTableSchema()
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema('fieldsforms');
        
        $this->assertNotNull($tableSchema, 'Таблица "fieldsforms" не найдена в базе данных.');

        $this->assertArrayHasKey('id', $tableSchema->columns, 'Поле "id" отсутствует.');
        $this->assertTrue($tableSchema->columns['id']->isPrimaryKey, 'Поле "id" должно быть первичным ключом.');

        $this->assertArrayHasKey('nameform', $tableSchema->columns, 'Поле "nameform" отсутствует.');
        $this->assertEquals(Schema::TYPE_TEXT, $tableSchema->columns['nameform']->type, 'Поле "nameform" должно быть текстовым.');

        $this->assertArrayHasKey('fieldform', $tableSchema->columns, 'Поле "fieldform" отсутствует.');
        $this->assertEquals(Schema::TYPE_TEXT, $tableSchema->columns['fieldform']->type, 'Поле "fieldform" должно быть текстовым.');

        $this->assertArrayHasKey('count_upload_doc', $tableSchema->columns, 'Поле "count_upload_doc" отсутствует.');
        $this->assertEquals(Schema::TYPE_INTEGER, $tableSchema->columns['count_upload_doc']->type, 'Поле "count_upload_doc" должно быть целочисленным.');
        $this->assertTrue($tableSchema->columns['count_upload_doc']->unsigned, 'Поле "count_upload_doc" должно быть беззнаковым.');
        $this->assertEquals(0, $tableSchema->columns['count_upload_doc']->defaultValue, 'Поле "count_upload_doc" должно иметь значение по умолчанию 0.');
    }

    public function testFieldsformsModel()
    {
        $model = new Fieldsforms();
        $model->nameform = 'Test Form';
        $model->fieldform = 'Test Field';
        $model->count_upload_doc = 5;

        $this->assertTrue($model->validate(), 'Модель Fieldsforms не прошла валидацию.');

        $model->save(false);

        $savedModel = Fieldsforms::findOne($model->id);

        $this->assertNotNull($savedModel, 'Модель Fieldsforms не была сохранена.');
        $this->assertEquals($model->nameform, $savedModel->nameform, 'Поле "nameform" не соответствует сохраненному значению.');
        $this->assertEquals($model->fieldform, $savedModel->fieldform, 'Поле "fieldform" не соответствует сохраненному значению.');
        $this->assertEquals($model->count_upload_doc, $savedModel->count_upload_doc, 'Поле "count_upload_doc" не соответствует сохраненному значению.');

        $model->delete();
    }
}
