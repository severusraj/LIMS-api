<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['id', 'isbn', 'call_number', 'title', 'author', 
                            'location_id', 'publisher', 'copyright', 'volume', 'edition', 
                            'pages', 'content', 'remarks', 'date_published', 'purchased_date'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
