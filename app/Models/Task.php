<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable=[
      "title",
      "department_id",
      "project_id",
      "deadline",
      "status"
    ];
    use HasFactory;
    protected $with=["department"];
    public function department(){
        return $this->belongsTo(Department::class);
    }
}
