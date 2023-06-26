<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'invoice';
    protected $primaryKey = 'id';
    protected $fillable = ['invoice_date', 'total_amount', 'invoice_type'];
    public function invoiceDetails()
{
    return $this->hasMany(Invoice_detail::class);
}

}
