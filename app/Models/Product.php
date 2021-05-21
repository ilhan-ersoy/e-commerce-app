<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function presetPrice()
    {
        return ('$'.number_format($this->price / 10, 2));
    }
}
