<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class VueModel extends Model {
    protected $vue_created;
    protected $vue_updated;
    protected $vue_deleted;

    protected $primary = 'id';

    protected $appends = [
        'vue_created',
        'vue_updated',
        'vue_deleted'
    ];
    
    public function __construct( ) {
        $vueModelVars = get_class_vars(__CLASS__);
        $this->appends = array_merge($vueModelVars['appends'], $this->appends);
    }

    public function deleteRecord() 
    {
        $this->destroy($this->id);
    }

    public function getVueCreatedAttribute()
    {
        return $this->vue_created or false;
    }

    public function setVueCreatedAttribute($value)
    {
        $this->vue_created = $value;
    }

    public function getVueUpdatedAttribute()
    {
        return $this->vue_updated or false;
    }

    public function setVueUpdatedAttribute($value)
    {
        $this->vue_updated = $value;
    }

    public function getVueDeletedAttribute()
    {
        return $this->vue_deleted or false;
    }

    public function setVueDeletedAttribute($value)
    {
        $this->vue_deleted = $value;
    }

    public static function createBlankObject()
    {
        $blankModel = new static();
        $blankModel->created_at = Carbon::now();
        $blankModel->updated_at = Carbon::now();
        $blankModel->vue_created = true;
        $blankModel->vue_updated = true;
        return $blankModel;
    }

    public static function createBlank()
    {
        $blankModel = static::createBlankObject();
        $blankModel = $blankModel->attributesToArray();
        return new Collection($blankModel);
    }
}