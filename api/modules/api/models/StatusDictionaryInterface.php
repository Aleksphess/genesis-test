<?php

declare(strict_types=1);

namespace api\modules\api\models;

interface StatusDictionaryInterface
{
    public const STATUS_NEW = 'new';

    public const STATUS_MODERATION = 'moderation';

    public const STATUS_APPROVE = 'approve';

    public const STATUS_CANCEL = 'cancel';

    public const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_MODERATION,
        self::STATUS_APPROVE,
        self::STATUS_CANCEL,
    ];
}
