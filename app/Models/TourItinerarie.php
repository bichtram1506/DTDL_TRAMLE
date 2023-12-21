<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourItinerarie extends Model
{
    use HasFactory;
    protected $table = 'tour_itineraries';
    public $timestamps = true;

    protected $fillable = [
        'ti_tour_id',
        'ti_day',
        'ti_description',
        'ti_content',
        'ti_images',
    ];

    public function createOrUpdate($request , $id ='')
    {
        $params = $request->except(['images','_token', 'submit']);

        if (isset($request->images) && !empty($request->images)) {
            $image = upload_image('images');
            if ($image['code'] == 1) {
                $params['ti_images'] = $image['name'];
            }
        }
        if ($id) {
            return $this->find($id)->update($params);
        }
        return $this->create($params);
    }
    
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'ti_tour_id', 'id');
    }

    
}
