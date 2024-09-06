<?php
namespace tests\unit\controllers;

use app\modules\takedatam\controllers\DefaultController;
use Yii;
use yii\web\Request;
use yii\web\Session;
use app\modules\takedatam\models\Dataforms;
use PHPUnit\Framework\TestCase;

//require __DIR__ . '/../../../vendor/autoload.php';
//require __DIR__ . '/../../../vendor/yiisoft/yii2/Yii.php';
//require __DIR__ . '/../../../config/test_db.php';

require __DIR__ . '/../../../vendor/autoload.php';
require __DIR__ . '/../../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../../config/test_db.php';

class SiteControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Инициализация
        $config = require __DIR__ . '/../../../config/web.php';
        new \yii\web\Application($config);

        Yii::$app->set('db', require __DIR__ . '/../../../config/test_db.php');

        Yii::$app->set('request', [
            'class' => 'yii\web\Request',
            'cookieValidationKey' => 'testkey',
        ]);
    }
    
    public function testActionForm4Post()
    {
        $controller = new DefaultController('site', Yii::$app);
        $request = Yii::$app->request;

        // Post
        $postData = [
            'Fieldsurl' => [
                ['field1_data1', 'field1_data2'],
                ['https://www.deepl.com/ru/translator', 'https://www.deepl.com/ru/translator'],
            ],
            'id' => [1, 2]
        ];

        $request->setBodyParams($postData);
        $result = $controller->runAction('form4');

        $this->assertEquals(302, Yii::$app->response->statusCode);
        $this->assertEquals('form4', Yii::$app->response->headers->get('Location'));

        $savedData1 = Dataforms::findOne(1);
        $this->assertEquals('field1_data1', $savedData1->datafilds);

        $savedData2 = Dataforms::findOne(2);
        $this->assertEquals('field1_data2', $savedData2->datafilds);
    }

    /*
    public function testActionForm4Get()
    {
        $controller = new DefaultController('site', Yii::$app);

        $response = $controller->runAction('form4');

        $this->assertIsArray($response);


        $this->assertArrayHasKey('nameurl', $response);
        $this->assertArrayHasKey('url', $response);

        $nameurl = Dataforms::find()->where(['namefildsforms' => 'test'])->all();
        $url = Dataforms::find()->where(['namefildsforms' => 'https://www.deepl.com/ru/translator'])->all();
        $this->assertNotEmpty($nameurl);
        $this->assertNotEmpty($url);
    }
    */
    
}