<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Attraction extends Model
{
    use HasFactory;
    protected $table = 'attractions';
    public $timestamps = true;
    protected $fillable = [
        'at_name',
        'at_location_id',
        'at_description'
    ];
    public function createOrUpdate($request , $id ='')
    {
        $params = $request->except(['_token']);
        if ($id) {
            return $this->find($id)->update($params);
        }
        return $this->create($params);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'at_location_id', 'id');
    }
 
}
