<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class Download extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uid = Str::random(12);
        });
    }

    protected $responseInfo;
    public function getResponseInfo($key, $default = null)
    {
        if (empty($this->response)) {
            return $default;
        }

        if ($this->responseInfo === null) {
            if (
                $this->response
                and $unserialized = unserialize($this->response)
            ) {
                $this->responseInfo = json_decode(json_encode($unserialized->getInfo()), true);
            } else {
                $this->responseInfo = [];
            }
        }
        return Arr::get($this->responseInfo, $key, $default);
    }
}
