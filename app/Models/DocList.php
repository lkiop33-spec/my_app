<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocList extends Model
{
    use HasFactory;

    protected $table = 'doc_lists';
    protected $primaryKey = 'idx';
    
    protected $fillable = [
        'type',
        'name',
        'filename',
        'path',
        'language',
        'reference',
    ];

    /**
     * Get the type of the document.
     */
    public function typeRelationship()
    {
        return $this->belongsTo(Type::class, 'type', 'idx');
    }

    /**
     * Get the language of the document.
     */
    public function languageRelationship()
    {
        return $this->belongsTo(Language::class, 'language', 'idx');
    }
}

