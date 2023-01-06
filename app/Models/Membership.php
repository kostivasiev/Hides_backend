<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'Users_membership';
	 /**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
    protected $fillable = [
        'fullName', 'userAppleID', 'userAppleEmail',
    ];

}
