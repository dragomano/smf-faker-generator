<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LpCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'category_id';

    public function pages()
    {
        return $this->hasMany(LpPage::class, 'category_id', 'category_id');
    }
}
