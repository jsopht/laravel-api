<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SheetFileProcess extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['status'];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = ['id'];

    public function setStatus(string $status)
    {
        return $this->update(['status' => $status]);
    }

    public function getStatus()
    {
        return $this->status;
    }
}
