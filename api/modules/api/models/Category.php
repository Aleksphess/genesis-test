<?php

declare(strict_types=1);

namespace api\modules\api\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Category
 * @package api\modules\api\models
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 * @property integer $articles_counter
 * @property string $status
 */
class Category extends ActiveRecord
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
        return 'categories';
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
            'articles_counter',
            'status'
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

    public function getArticlesRelation(): ActiveQuery
    {
        return $this->hasMany(Article::class, ['category_id' => 'id']);
    }

    /**
     * @return Article[]
     */
    public function getArticles(): array
    {
        return $this->getArticlesRelation()->all();
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

    public function getId(): int
    {
        return $this->id;
    }

    public function incrementArticle(): void
    {
        $this->articles_counter++;
    }

    public function decrementArticle(): void
    {
        $this->articles_counter--;
    }
}
