<?php

$APP_PATH = storage_path('app/public');
$APP_URL = env('APP_URL');

return [
    "PATH" => [
        "UPLOAD_BRAND_IMAGE"     => $APP_PATH. "/images/brand/",
        "UPLOAD_MODEL_IMAGE"     => $APP_PATH. "/images/model/",
        "UPLOAD_VEHICAL_IMAGE"     => $APP_PATH. "/images/vehical/",
    ]
];
