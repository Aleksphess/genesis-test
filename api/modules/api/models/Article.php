<?php

declare(strict_types=1);

namespace api\modules\api\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Article
 * @package api\modules\api\models
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 * @property integer $category_id
 * @property string $status
 */
class Article extends ActiveRecord
{
    private const DATETIME_FORMAT = 'Y-m-d H:i:s';

    private const SAFE_ATTRIBUTE = [
        'alias',
        'title',
        'description',
        'text',
        'status'
    ];

    public static function tableName(): string
    {
        return 'articles';
    }

    public function attributes(): array
    {
        return [
            'id',
            'alias',
            'title',
            'description',
            'text',
            'created_at',
            'updated_at',
            'category_id'
        ];
    }

    public function rules(): array
    {
        return [
            [
                self::SAFE_ATTRIBUTE, 'safe'
            ]
        ];
    }

    public function getCategoryRelation(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getCategory(): Category
    {
        return $this->getCategoryRelation()->one();
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function changeUpdateAt(): void
    {
        $this->updated_at = date(self::DATETIME_FORMAT);
    }

    public function setCreateAt(): void
    {
        $this->created_at = date(self::DATETIME_FORMAT);
    }

    public function setNewStatus(): void
    {
        $this->status = StatusDictionaryInterface::STATUS_NEW;
    }

    public function setCategory(Category $category): void
    {
        $this->category_id = $category->getId();
    }
}
