<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\UploadForm;
use yii\web\UploadedFile;

require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\ObjectUploader;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

/*
$amountBuckets = $s3->listBuckets();

#echo $amountBuckets;

$command = $s3->getCommand('GetObject', [
    'Bucket' => 'testbucket',
    'Key'    => 'my-object'
]);

$myPresignedRequest = $s3->createPresignedRequest($command, '+10 minutes');
$presignedUrl =  (string)  $myPresignedRequest->getUri(); //получили актуальную ссылку


$insert = $s3->putObject([
    'Bucket' => 'testbucket',
    'Key'    => 'desiredFileName',//'testkey',
    'Body'   => 'Hello from Sanechek'
]);

echo $presignedUrl;
*/

class SiteController extends Controller
{
    
    
    public function actionUpload()
    {
        $s3 = new S3Client([
            'version' 	=> 'latest',
            'region'  	=> 'msk',
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key'	=> 'minioadmin',
                'secret' => 'minioadmin',
            ],
            'endpoint' => 'http://127.0.0.1:9000',
        ]);
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) {
                $s3 -> putObject([
                    'Bucket' => 'testbucket',
                    'Key'    => $model->file->baseName.'.'.$model->file->extension,//'desiredFileName',//'testkey',
                    'Body'   => file_get_contents($model->file->tempName),
                    //['ContentType' => $model->file->extension]),//'Hello from Sanechek',
                ]);                
                //$model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
