<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuppliersModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $connection = 'apps_mysql';
    protected $table = 'suppliers';

    public function subMaterialBy()
    {
        return $this->hasOne(SubMaterialModel::class, 'id', 'sub_materials_id')->withTrashed();
    }
    public function warehouseBy()
    {
        return $this->hasOne(WarehouseModel::class, 'id', 'id_warehouse')->withTrashed();
    }
}
