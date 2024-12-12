<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class BookingLogs extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'booking_logs';

	 /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['booking_id', 
                            'user_id', 
                            'content', 
                            'action'           
                            ];
    
    public function booking()
    {
        return $this->belongsTo('App\Models\Booking', 'booking_id');
    }   
}
