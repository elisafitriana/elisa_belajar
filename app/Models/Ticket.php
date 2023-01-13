<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories()
    {
        return $this->hasMany(TicketCategory::class)
                    ->join('categories', 'categories.id', 'ticket_categories.category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->leftJoin('users', 'users.id', 'comments.user_id');
    }
}
