<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    use HasFactory;

    const TYPE_WIN = 1;
    const TYPE_LOSE = 2;

    public function isWin(): bool
    {
        return $this->type === self::TYPE_WIN;
    }
}
