<?php

namespace App\Services;

use App\Models\Click;

class ClickService
{
    const WINS = [
        900 => 80,
        600 => 60,
        300 => 20,
        0 => 10,
    ];

    public function create($link)
    {
        $num = rand(1, 1000);

        $click = new Click();
        $click->type = $num & 1 ? Click::TYPE_LOSE : Click::TYPE_WIN;
        $click->link_id = $link->id;
        $click->value = 0;
        if ($click->isWin()) {
            foreach (self::WINS as $value => $rate) {
                if ($num > $value) {
                    $click->value = round(($rate / 100) * $num);
                    break;
                }
            }
        }

        if (!$click->save()) {
            throw new \Error('Error while saving click');
        }

        return $click;
    }
}
