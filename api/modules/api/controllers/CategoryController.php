<?php

declare(strict_types=1);

namespace api\modules\api\controllers;

use api\modules\api\exceptions\NotFoundCategoryException;
use api\modules\api\resources\Category;
use api\modules\api\services\CategoryServiceInterface;
use api\modules\api\validation\CategoryCreateScenario;
use api\modules\api\validation\CategoryUpdateScenario;
use yii\base\Module;
use yii\data\DataProviderInterface;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class CategoryController extends Controller
{
    /**
     * @var string
     */
    public $modelClass = Category::class;

    private CategoryServiceInterface $service;

    private Request $request;

    private Response $response;

    private CategoryCreateScenario $createCategoryScenario;

    private CategoryUpdateScenario $updateCategoryScenario;

    public function __construct(
        string $id,
        Module $module,
        CategoryServiceInterface $service,
        CategoryCreateScenario $createCategoryScenario,
        CategoryUpdateScenario $updateCategoryScenario,
        Request $request,
        Response $response,
        array $config = []
    ) {
        $this->service = $service;
        $this->createCategoryScenario = $createCategoryScenario;
        $this->updateCategoryScenario = $updateCategoryScenario;
        $this->request = $request;
        $this->response = $response;

        parent::__construct($id, $module, $config);
    }

    public function actions(): array
    {
        $actions = parent::actions();

        return ['options' => $actions['options']];
    }

    public function actionView(string $id): Category
    {
        try {
            return $this->service->findCategory($id);
        } catch (NotFoundCategoryException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function actionUpdate(string $id): Category
    {
        $this->updateCategoryScenario->validateRequest($this->request);
        $params = $this->request->getBodyParams();
        try {
            return $this->service->updateCategory($id, $params);
        } catch (NotFoundCategoryException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }

    public function actionDelete(string $id): void
    {
        $this->service->deleteCategory($id);
        $this->response->statusCode = 204;
    }

    public function actionCreate(): Category
    {
        $this->createCategoryScenario->validateRequest($this->request);
        $params = $this->request->getBodyParams();

        return $this->service->createCategory($params);
    }

    public function actionIndex(): DataProviderInterface
    {
        return $this->service->findAllByParams($this->request->getBodyParams());
    }
}
