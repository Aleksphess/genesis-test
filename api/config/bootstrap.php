<?php

Yii::setAlias('@base', dirname(__DIR__, 2) . '/');
Yii::setAlias('@api', dirname(__DIR__, 2) . '/api');
Yii::setAlias('@tests', dirname(__DIR__, 2) . '/tests');

Yii::$container->setSingleton(\yii\web\Request::class);
Yii::$container->setSingleton(\yii\web\Response::class);

/**
 * Category bootstrap
 */
Yii::$container->set(
    \api\modules\api\cache\CategoryCache::class,
    function () {
        return new \api\modules\api\cache\CategoryCache(Yii::$app->cache);
    }
);

Yii::$container->set(
    \api\modules\api\repository\CategoryRepository::class,
    \api\modules\api\repository\CategoryRepository::class,
    [
        \api\modules\api\resources\Category::class
    ]
);

Yii::$container->set(\api\modules\api\validation\CategoryCreateScenario::class);
Yii::$container->set(\api\modules\api\validation\CategoryUpdateScenario::class);

Yii::$container->set(
    \api\modules\api\services\CategoryServiceInterface::class,
    function () {
        return new \api\modules\api\services\CategoryService(
            Yii::$container->get(\api\modules\api\repository\CategoryRepository::class),
            Yii::$container->get(\api\modules\api\cache\CategoryCache::class)
        );
    }
);

/**
 * Article bootstrap
 */
Yii::$container->set(
    \api\modules\api\cache\ArticleCache::class,
    function () {
        return new \api\modules\api\cache\ArticleCache(Yii::$app->cache);
    }
);

Yii::$container->set(
    \api\modules\api\repository\ArticleRepository::class,
    \api\modules\api\repository\ArticleRepository::class,
    [
        \api\modules\api\resources\Article::class
    ]
);

Yii::$container->set(\api\modules\api\validation\ArticleCreateScenario::class);
Yii::$container->set(\api\modules\api\validation\ArticleUpdateScenario::class);

Yii::$container->set(
    \api\modules\api\services\ArticleServiceInterface::class,
    function () {
        return new \api\modules\api\services\ArticleService(
            Yii::$container->get(\api\modules\api\repository\ArticleRepository::class),
            Yii::$container->get(\api\modules\api\repository\CategoryRepository::class),
            Yii::$container->get(\api\modules\api\cache\ArticleCache::class),
            Yii::$container->get(\api\modules\api\cache\CategoryCache::class)
        );
    }
);
