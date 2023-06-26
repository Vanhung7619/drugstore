<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_detail extends Model
{
    use HasFactory;
    protected $table = 'invoice_detail';
    protected $primaryKey = 'id';
    protected $fillable = ['medicine_id', 'invoice_id', 'quantity', 'unit_price'];
    public function medicine()
{
    return $this->belongsTo(Medicine::class);
}

}
