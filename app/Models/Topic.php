<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    public function topicRegistrations()
    {
        return $this->hasMany(TopicRegistration::class);
    }
}
