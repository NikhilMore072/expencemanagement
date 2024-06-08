<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenceManagement extends Model
{
    use HasFactory;
    protected $table ='expence_management';
    protected $fillable = [ 'category', 'amount', 'comments','user_id'];
}
