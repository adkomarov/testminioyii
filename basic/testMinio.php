<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\ObjectUploader;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

#Создадим экземпляр s3
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