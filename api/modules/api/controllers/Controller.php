<?php

declare(strict_types=1);

namespace api\modules\api\controllers;

use yii\filters\Cors;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\Response;

class Controller extends ActiveController
{
    public function behaviors(): array
    {
        return [
            'corsFilter' => [
                'class' => Cors::className(),
                'cors'  => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => [
                        'GET',
                        'POST',
                        'PUT',
                        'PATCH',
                        'DELETE',
                        'LINK',
                        'UNLINK',
                        'LOCK',
                        'UNLOCK',
                        'HEAD',
                        'OPTIONS',
                        'PROPFIND',
                        'SEARCH',
                        'PURGE',
                        'COPY',
                        'MOVE',
                        'VIEW'
                    ],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [
                        'X-Pagination-Current-Page',
                        'X-Pagination-Page-Count',
                        'X-Pagination-Per-Page',
                        'X-Pagination-Total-Count'
                    ],
                ]
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml'  => Response::FORMAT_XML,
                ],
            ],
            'verbFilter' => [
                'class'   => VerbFilter::className(),
                'actions' => $this->verbs(),
            ],
        ];
    }
}