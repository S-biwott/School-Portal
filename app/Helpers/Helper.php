<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Helper
{
    public static function NumberIDGenerator($tableName, array $conditions = [], string $prefix, int $length): string
    {
        $model = DB::table($tableName);

        if (is_array($conditions) && count($conditions) > 0) {
            $model = $model->where($conditions);
        }

        $lastRecord = $model->latest('id')->first();

        if (!$lastRecord) {
            return $prefix . str_pad(
                1,
                $length,
                '0',
                STR_PAD_LEFT
            );
        } else {
            $latestId = $lastRecord->id;
            return $prefix . str_pad(
                $latestId + 1,
                $length,
                '0',
                STR_PAD_LEFT
            );
        }
    }
}
