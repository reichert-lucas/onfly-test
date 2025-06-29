<?php

namespace App\Models;

use App\Traits\UseSystemScope;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use UseSystemScope;
}
