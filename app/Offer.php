<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['partner_id', 'offer_for', 'identity', 'function', 'title', 'discount', 'deal_amount', 'incentive', 'available_in', 'currency', 'status', 'offerred_by', 'weblink', 'notification_email'];

    public function country()
    {
        return $this->belongsTo('App\Country', 'available_in', 'country_code');
    }

    public function partner()
    {
        return $this->belongsTo('App\User', 'partner_id', 'id');
    }

    public function industry()
    {
        return $this->belongsTo('App\Industry','function');
    }
}

