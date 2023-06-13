<?php

namespace Service\Payment\Momo\Database;
use Illuminate\Database\Eloquent\Model;
class MomoLog extends Model
{
    protected $fillable = [];
    protected $table = 'momoLogs';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}