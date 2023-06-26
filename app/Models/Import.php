<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;
    protected $table = 'import';
    protected $primaryKey = 'id';
    protected $fillable = ['medicine_id', 'quantity', 'total_amount', 'import_date'];
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
