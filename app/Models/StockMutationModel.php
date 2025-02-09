<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMutationModel extends Model
{
    use HasFactory;

    protected $table = 'stock_mutations';

    public function stockMutationDetailBy()
    {
        return $this->hasMany(StockMutationDetailModel::class, 'mutation_id');
    }

    public function fromWarehouse()
    {
        return $this->hasOne(WarehouseModel::class, 'id', 'from')->withTrashed();
    }

    public function toWarehouse()
    {
        return $this->hasOne(WarehouseModel::class, 'id', 'to')->withTrashed();
    }

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by')->withTrashed();
    }
    
    public function getProductCode(){
        return $this->hasOne(AccuClaimModel::class,'mutation_number','mutation_number');
    }
}
