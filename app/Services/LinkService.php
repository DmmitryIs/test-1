<?php

namespace App\Services;

use App\Models\Link;

class LinkService
{
    private Link|null $link = null;

    /**
     * @throws \Exception
     */
    public function generate($user): string
    {
        $value = md5($user->id . $user->links->count() . time());

        $link = new Link();
        $link->user_id = $user->id;
        $link->value = $value;

        if (!$link->save()) {
            throw new \Exception('Error while save link');
        }

        return $value;
    }

    public function get($value)
    {
        if ($link = Link::where([['value', $value], ['status', Link::STATUS_ACTIVE]])->first()) {
            $this->link = $link;
        }

        return $this->link;
    }

    public function deactivate()
    {
        if (!$link = $this->link) {
            return false;
        }

        $link->status = Link::STATUS_EXPIRED;

        return $link->save();
    }

    public function history()
    {
        return $this->link->clicks()->orderBy('created_at', 'desc')->take(3)->get();
    }
}
