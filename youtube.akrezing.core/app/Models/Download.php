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

    public function getRouteKeyName()
    {
        return 'uid';
    }

    protected $responseInfo;
    public function getResponseInfo($key, $default = null)
    {
        if (empty($this->response)) {
            return $default;
        }

        if ($this->responseInfo === null) {
            $unserialized = unserialize($this->response);
            if ($unserialized) {
                $this->responseInfo = json_decode(json_encode($unserialized->getInfo()), true);
            } else {
                $this->responseInfo = [];
            }
        }
        return Arr::get($this->responseInfo, $key, $default);
    }

    protected $responseAllFormats;
    public function getResponseAllFormats()
    {
        if (empty($this->response)) {
            return [];
        }

        if ($this->responseAllFormats === null) {
            $unserialized = unserialize($this->response);
            if ($unserialized) {
                $this->responseAllFormats = json_decode(json_encode($unserialized->getAllFormats()), true);
            } else {
                $this->responseAllFormats = [];
            }
        }
        return $this->responseAllFormats;
    }

    public static function getHumanReadableSize($size, $unit = "")
    {
        if ((!$unit && $size >= 1 << 30) || $unit == "GB")
            return number_format($size / (1 << 30), 2) . " GB";
        if ((!$unit && $size >= 1 << 20) || $unit == "MB")
            return number_format($size / (1 << 20), 2) . " MB";
        if ((!$unit && $size >= 1 << 10) || $unit == "KB")
            return number_format($size / (1 << 10), 2) . " KB";
        return number_format($size) . " Bytes";
    }
}
