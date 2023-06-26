<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Medicine extends Model
{
    use HasFactory;
    protected $table = 'medicine';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'quantity', 'producer', 'manufacture_date', 'expiration_date'];
}