<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'condition_type', 'condition_rule', 'condition_value', 'apply_type', 'buy', 'get'
    ];
}
