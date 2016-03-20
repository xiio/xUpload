<?php

use xiio\xUpload\Validation\Rules\SizeRule;
use xiio\xUpload\xUpload;

include "../vendor/autoload.php";

$upload_dir = __DIR__ . "/uploads";
$storage = new xiio\xUpload\Storage\LocalStorage($upload_dir);//set storage start point

$uploader = xUpload::fromFiles("my_files", $storage);

$uploader->validation()->addRule(new SizeRule(100));

$files = $uploader->getUploadingFiles();
$uploaded_files = $uploader->storeValidFiles('', xUpload::OVERRIDE_EXITING_FILES);

var_dump($files, $uploaded_files, $uploader->getErrors());
die;