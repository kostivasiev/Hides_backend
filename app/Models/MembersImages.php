<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembersImages extends Model
{
    protected $table = 'members_images';
	 /**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
    protected $fillable = [
        'member_id', 'member_file_name'
    ];

}
