<?php
namespace tests\unit\controllers;

use Yii;
use yii\web\Request;
use yii\web\Session;
use yii\web\Response;
use yii\base\InvalidRouteException;
use PHPUnit\Framework\TestCase;

use app\modules\takedatam\controllers\DefaultController;
use app\modules\takedatam\models\Dataforms;

//require __DIR__ . '/../../../vendor/autoload.php';
//require __DIR__ . '/../../../vendor/yiisoft/yii2/Yii.php';
//require __DIR__ . '/../../../config/test_db.php';

//require __DIR__ . '/../../../vendor/autoload.php';
//require __DIR__ . '/../../../vendor/yiisoft/yii2/Yii.php';
//require __DIR__ . '/../../../config/test_db.php';

/*
        Yii::$app->set('request', new Request([
            'method' => 'POST',//$request->setMethod('POST');
            'bodyParams' => [
                'paid_educational' => [
                    [1, '1', 'Test Name 1', 'http://example.com/1'],
                    [2, '2', 'Test Name 2', 'http://example.com/2'],
                    [3, '3', 'Test Name 3', 'http://example.com/3'],
                    [4, '4', 'Test Name 4', 'http://example.com/4']
                ]
            ]
        ]));
        */
        /*
        $request = new Request();
        $request->setMethod('POST');
        $request->setBodyParams([
            'paid_educational' => [
                [1, '1', 'Test Name 1', 'http://example.com/1'],
                [2, '2', 'Test Name 2', 'http://example.com/2'],
                [3, '3', 'Test Name 3', 'http://example.com/3'],
                [4, '4', 'Test Name 4', 'http://example.com/4']
            ]
        ]);

        // Set the request object in the Yii application
        Yii::$app->set('request', $request);
        */
/*

class PaidEduControllerTest extends TestCase
{
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        // Инициализация контроллера
        $this->controller = new DefaultController('your-controller', Yii::$app);

        // Настройка запроса и сессии
        
        $request = new Request([
            'url' => '/paidedu',
            'method' => 'POST',
            'bodyParams' => [
                'paid_educational' => [
                    [1, '1', 'Test Name 1', 'http://example.com/1'],
                    [2, '2', 'Test Name 2', 'http://example.com/2'],
                    [3, '3', 'Test Name 3', 'http://example.com/3'],
                    [4, '4', 'Test Name 4', 'http://example.com/4']
                ]
            ]
        ]);

        // Set the request object in the Yii application
        Yii::$app->set('request', $request);

        Yii::$app->set('response', new Response());
        Yii::$app->set('session', new Session());
        Yii::$app->session->open();
    }

    protected function tearDown(): void
    {
        Yii::$app->session->destroy();
        parent::tearDown();
    }

    public function testActionPaidedu()
    {
        // Подготовка начальных данных в базе данных
        Dataforms::deleteAll();
        foreach (range(1, 4) as $i) {
            $dataform = new Dataforms();
            $dataform->iddataforms = $i;
            $dataform->variable = (string)$i;
            $dataform->namefildsforms = "Initial Name $i";
            $dataform->datafilds = "http://initial.com/$i";
            $dataform->save(false);
        }

        // Выполнение экшена
        try {
            $this->controller->runAction('paidedu');
        } catch (InvalidRouteException $e) {
            $this->fail("Invalid route: " . $e->getMessage());
        }

        // Проверка обновлённых данных в базе данных
        $data = Dataforms::find()->where(['or', ['variable' => '1'], ['variable' => '2'], ['variable' => '3'], ['variable' => '4']])->all();

        foreach ($data as $datum) {
            $this->assertEquals("Test Name " . $datum->variable, $datum->namefildsforms);
            $this->assertEquals("http://example.com/" . $datum->variable, $datum->datafilds);
        }

        // Проверка отсутствия флеш-сообщений об ошибке
        $this->assertFalse(Yii::$app->session->hasFlash('error'));
    }
}
*/

class PaidEduControllerTest extends TestCase
{
    public function testActionPaidedu()
    {

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getMethod', 'getBodyParams'])
            ->getMock();


        $request->method('getMethod')->willReturn('POST');
        $request->method('getBodyParams')->willReturn([
            'paid_educational' => [
                [1, '1', 'Test Name 1', 'http://example.com/1'],
                [2, '2', 'Test Name 2', 'http://example.com/2'],
                [3, '3', 'Test Name 3', 'http://example.com/3'],
                [4, '4', 'Test Name 4', 'http://example.com/4']
            ]
        ]);

        $request->cookieValidationKey = 'your-secret-key';
        $controller = new DefaultController('PaidEdu', Yii::$app);
        // Set the request object in the Yii application
        Yii::$app->controller = $controller;
        Yii::$app->controller->enableCsrfValidation = false;
        Yii::$app->set('request', $request);
        // Your test logic here
        // For example, you can call a controller action and assert the response
        $response = $controller->runAction('paidedu');

        // Assertions
        $this->assertInstanceOf('yii\web\Response', $response);
        var_dump($response);
        // Add more assertions as needed
    }
}

/*
class NoCookieSession extends Session
{
    public function open()
    {
        if ($this->getIsActive()) {
            return;
        }

        $this->setCookieParamsInternal();

        @session_start();
    }

    private function setCookieParamsInternal()
    {
        $cookieParams = $this->getCookieParams();
        if (isset($cookieParams['lifetime'], $cookieParams['path'], $cookieParams['domain'], $cookieParams['secure'], $cookieParams['httponly'])) {
            session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], $cookieParams['domain'], $cookieParams['secure'], $cookieParams['httponly']);
        }
    }
}
*/
/*
class PaidEduControllerTest extends TestCase
{
    private $controller;

    protected function setUp(): void
    {
        parent::setUp();

        // Start output buffering
        //ob_start();

        // Инициализация контроллера
        $this->controller = new DefaultController('PaidEdu', Yii::$app);
        
        // Настройка запроса и сессии
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getMethod', 'getBodyParams'])
            ->getMock();
        //$request->cookieValidationKey = 'your-secret-key';

        $request->method('getMethod')->willReturn('POST');
        $request->method('getBodyParams')->willReturn([
            'paid_educational' => [
                [1, '1', 'Test Name 1', 'http://example.com/1'],
                [2, '2', 'Test Name 2', 'http://example.com/2'],
                [3, '3', 'Test Name 3', 'http://example.com/3'],
                [4, '4', 'Test Name 4', 'http://example.com/4']
            ]
        ]);


        // Set the request object in the Yii application
        Yii::$app->set('request', $request);

        Yii::$app->set('response', new Response());
        //Yii::$app->set('session', new NoCookieSession());
        Yii::$app->session->open();
    }

    protected function tearDown(): void
    {
        Yii::$app->session->destroy();
        //ob_end_clean(); // Clean and end output buffering
        parent::tearDown();
    }

    public function testActionPaidedu()
    {
        // Подготовка начальных данных в базе данных
        Dataforms::deleteAll();
        foreach (range(1, 4) as $i) {
            $dataform = new Dataforms();
            $dataform->iddataforms = $i;
            $dataform->variable = (string)$i;
            $dataform->namefildsforms = "Initial Name $i";
            $dataform->datafilds = "http://initial.com/$i";
            $dataform->save(false);
        }

        // Выполнение экшена
        Yii::$app->controller = $this->controller;
        Yii::$app->controller->enableCsrfValidation = false;
        $response = $this->controller->runAction('paidedu');

        // Проверка обновлённых данных в базе данных
        $data = Dataforms::find()->where(['or', ['variable' => '1'], ['variable' => '2'], ['variable' => '3'], ['variable' => '4']])->all();

        foreach ($data as $datum) {
            $this->assertEquals("Test Name " . $datum->variable, $datum->namefildsforms);
            $this->assertEquals("http://example.com/" . $datum->variable, $datum->datafilds);
        }

        // Проверка отсутствия флеш-сообщений об ошибке
        $this->assertFalse(Yii::$app->session->hasFlash('error'));

        // Assertions
        $this->assertInstanceOf('yii\web\Response', $response);
        var_dump($response);
    }
}
*/