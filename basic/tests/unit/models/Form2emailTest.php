<?php

namespace tests\unit\models;

use Yii;
//nclude_ '/work/sites/yiiprojects/appbasic/basic/modules/takedatam/models/Form2email.php';

use yii\db\ActiveQuery;
use PHPUnit\Framework\TestCase;

include_once(("/work/sites/yiiprojects/appbasic/basic/modules/takedatam/models/Form2email.php"));
include_once(("/work/sites/yiiprojects/appbasic/basic/modules/takedatam/models/Dataforms.php"));
//include_once('/work/sites/yiiprojects/appbasic/basic/config/test_db.php');
use app\modules\takedatam\models\Form2email;
use app\modules\takedatam\models\Dataforms;
class Form2emailTest extends TestCase
{
    public function testTrueIsTrue()
    {
        $this->assertTrue(True === True);
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Отключаем логи Yii для тестов
        Yii::getLogger()->flushInterval = 1;
    }

    public function testTableName()
    {
        $model = new Form2email();
        $this->assertEquals('form2email', $model->tableName());
    }

    public function testTableName2()
    {
        $model = new Form2email();
        $this->assertNotEquals('form2emails', $model->tableName());
    }

    
    public function testRules()
    {
        $model = new Form2email();

        // Test empty iddataforms
        //$model->iddataforms = null;
        //$this->assertTrue($model->validate(['iddataforms']));

        // Test invalid email
        $model->email = 'invalid-email';
        $this->assertFalse($model->validate(['email']));

        // Test valid email
        $model->email = 'valid-email@example.com';
        $this->assertTrue($model->validate(['email']));

        // Test existing iddataforms (assuming 1 is a valid id in Dataforms table)
        // Убедитесь, что в таблице Dataforms существует запись с id 1
        $model->iddataforms = 1;
        $this->assertTrue($model->validate(['iddataforms']));
    }
    

    public function testAttributeLabels()
    {
        $model = new Form2email();
        $labels = $model->attributeLabels();

        $this->assertEquals('Idform2email', $labels['idform2email']);
        $this->assertEquals('Email', $labels['email']);
        $this->assertEquals('Iddataforms', $labels['iddataforms']);
    }

    public function testGetIddata0()
    {
        $model = new Form2email();
        $relation = $model->getIddata0();
        $this->assertInstanceOf(ActiveQuery::class, $relation);
    }

    public function testSaveAndRetrieve()
    {
        // Убедитесь, что запись с iddataforms = 1 отсутствует
        Dataforms::deleteAll(['iddataforms' => 1]);

        // Создайте новую запись в таблице Dataforms
        $dataform = new Dataforms();
        $dataform->iddataforms = 1;
        $dataform->variable = '1';
        $dataform->namefildsforms = 'Test Name';
        $dataform->datafilds = 'http://example.com';
        $this->assertTrue($dataform->save());

        // Теперь тестируйте модель Form2email
        $model = new Form2email();
        $model->email = 'test@example.com';
        $model->iddataforms = 1;
        $this->assertTrue($model->save());

        // Проверьте, что данные были корректно сохранены и могут быть извлечены
        $retrieved = Form2email::findOne(['iddataforms' => 1]);
        $this->assertNotNull($retrieved);
        $this->assertEquals('test@example.com', $retrieved->email);
        $this->assertEquals(1, $retrieved->iddataforms);
    }

}
