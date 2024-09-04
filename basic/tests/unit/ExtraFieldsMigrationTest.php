<?php

namespace tests\unit;

use app\modules\takedatam\models\ExtraFields;
use yii\db\Schema;
use Yii;

class ExtraFieldsMigrationTest extends \Codeception\Test\Unit
{

    public function testExtraFieldsTableSchema()
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema('{{%extra_fields}}');
        $this->assertNotNull($tableSchema, 'Таблица "extra_fields" не была найдена в базе данных.');

        $columns = ['id', 'data', 'type', 'dataforms_id', 'fieldsforms_id'];
        foreach ($columns as $column) {
            $this->assertArrayHasKey($column, $tableSchema->columns, "Поле \"$column\" отсутствует.");
        }

        $this->assertTrue($tableSchema->columns['id']->isPrimaryKey, 'Поле "id" должно быть первичным ключом.');
        $this->assertEquals(Schema::TYPE_TEXT, $tableSchema->columns['data']->type, 'Поле "data" должно быть типа TEXT.');
        $this->assertEquals(Schema::TYPE_TEXT, $tableSchema->columns['type']->type, 'Поле "type" должно быть типа TEXT.');
        $this->assertEquals(Schema::TYPE_INTEGER, $tableSchema->columns['dataforms_id']->type, 'Поле "dataforms_id" должно быть типа INTEGER.');
        $this->assertEquals(Schema::TYPE_INTEGER, $tableSchema->columns['dataforms_id']->type, 'Поле "fieldsforms_id" должно быть типа INTEGER.');
    }

    public function testExtraFieldsModel()
    {

        $model = new ExtraFields();
        $model->data = 'Test Data';
        $model->type = 'Test Type';
        $model->dataforms_id = 1;//Надо заменить на реальный id записи в таблице dataforms
        $model->fieldsforms_id = 1;//Надо заменить на реальный id записи в таблице fieldsforms

        $this->assertTrue($model->validate(), 'Модель ExtraFields не прошла валидацию.');

        $model->save(false);

        $savedModel = ExtraFields::findOne($model->id);

        $this->assertNotNull($savedModel, 'Модель ExtraFields не была сохранена.');
        $this->assertEquals($model->data, $savedModel->data, 'Поле "data" не соответствует сохраненному значению.');
        $this->assertEquals($model->type, $savedModel->type, 'Поле "type" не соответствует сохраненному значению.');
        $this->assertEquals($model->dataforms_id, $savedModel->dataforms_id, 'Поле "dataforms_id" не соответствует сохраненному значению.');
        $this->assertEquals($model->fieldsforms_id, $savedModel->fieldsforms_id, 'Поле "fieldsforms_id" не соответствует сохраненному значению.');

        $model->delete();
    }
}
