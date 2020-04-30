<?php

namespace App\Job\JobItemImages;

use App\Job\JobItems\JobItem;
use Illuminate\Database\Eloquent\Model;

class JobItemImage extends Model
{
	protected $fillable = [
		'job_item_id',
		'src'
	];

	public $timestamps = false;

	/**
	 * @return \Illumineate\Database\Eloquant\Relations\BelongsTo
	 */

	public function jobitem() 
	{
		return $this->belongsTo(JobItem::class);
	}
}
