<?php

namespace App\Models\CRM\Ticket;

use Illuminate\Database\Eloquent\Model;
use App\Models\CRM\Company\Company;
use App\Models\Core\Auth\User;
use App\Models\CRM\Comment\Comment;

class Ticket extends Model
{
    protected $fillable = [
    'user_id', 'company_id', 'ticket_id', 'title', 'priority', 'message', 'status'
];

public function company()
	{
	    return $this->belongsTo(Company::class);
	}

	public function comments()
	{
	    return $this->hasMany(Comment::class);
	}

	public function user()
	{
	    return $this->belongsTo(User::class);
	}
	
	// public function ticketCustomField()
    // {
    //     return $this->hasMany('App\Models\TicketCustomField');
    // }

}
