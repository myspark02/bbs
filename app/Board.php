<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
	protected $fillable = ['title', 'writer', 'content'];
    //

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function attachments() {
    	return $this->hasMany(Attachment::class);
    }
}
