<?php

declare(strict_types=1);

namespace api\modules\api\controllers;

use api\modules\api\exceptions\NotFoundCategoryException;
use api\modules\api\resources\Article;
use api\modules\api\services\ArticleServiceInterface;
use api\modules\api\validation\ArticleCreateScenario;
use api\modules\api\validation\ArticleUpdateScenario;
use yii\base\Module;
use yii\base\Response;
use yii\data\DataProviderInterface;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class ArticleController extends Controller
{
    /**
     * @var string
     */
    public $modelClass = Article::class;

    private ArticleServiceInterface $service;

    private Request $request;

    private Response $response;

    private ArticleCreateScenario $articleCreateScenario;

    private ArticleUpdateScenario $articleUpdateScenario;

    public function __construct(
        string $id,
        Module $module,
        ArticleServiceInterface $service,
        Request $request,
        Response $response,
        ArticleCreateScenario $articleCreateScenario,
        ArticleUpdateScenario $articleUpdateScenario,
        array $config = []
    ) {
        $this->service = $service;
        $this->request = $request;
        $this->response = $response;
        $this->articleCreateScenario = $articleCreateScenario;
        $this->articleUpdateScenario = $articleUpdateScenario;

        parent::__construct($id, $module, $config);
    }

    public function actions(): array
    {
        $actions = parent::actions();

        return ['options' => $actions['options']];
    }

    public function actionView(string $id): Article
    {
        try {
            return $this->service->findArticle($id);
        } catch (NotFoundCategoryException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function actionUpdate(string $id): Article
    {
        $this->articleUpdateScenario->validateRequest($this->request);
        $params = $this->request->getBodyParams();
        try {
            return $this->service->updateArticle($id, $params);
        } catch (NotFoundCategoryException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function actionDelete(string $id): void
    {
        $this->service->deleteArticle($id);
        $this->response->statusCode = 204;
    }

    public function actionCreate(): Article
    {
        $this->articleCreateScenario->validateRequest($this->request);
        $params = $this->request->getBodyParams();

        return $this->service->createArticle($params);
    }

    public function actionIndex(): DataProviderInterface
    {
        return $this->service->findAllByParams($this->request->getBodyParams());
    }
}
