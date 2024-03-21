<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Message extends Model
{
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $fillable = ['title', 'message', 'message_for', 'related_id', 'message_by', 'is_deleted'];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'message_by', 'id');
    // }

    public static function userName($id){

       $username = DB::table('users')
    	->select('username')
    	->where('id',$id)
    	->first();
    	return $username->username;
    }
}
