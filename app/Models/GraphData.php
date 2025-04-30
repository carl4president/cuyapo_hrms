<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraphData extends Model
{
    use HasFactory;

    protected $fillable = [
        'graph_type', 
        'filter_column', 
        'data',
        'department_filter_column'
    ];

    protected $casts = [
        'data' => 'array', // Store the graph data as an array
    ];
}
