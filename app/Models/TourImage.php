<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourImage extends Model
{
    use HasFactory;
    protected $table = 'tour_images';
    public $timestamps = true;

    protected $fillable = [
        'tm_tour_id',
        'tm_image_url',
        'tm_name',
    ];

    public function createOrUpdate($request , $id ='')
    {
        $params = $request->except(['images','_token', 'submit']);

        if (isset($request->images) && !empty($request->images)) {
            $image = upload_image('images');
            if ($image['code'] == 1) {
                $params['tm_image_url'] = $image['name'];
            }
        }
        if ($id) {
            return $this->find($id)->update($params);
        }
        return $this->create($params);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tm_tour_id', 'id')->where('t_status', 1);
    }

    
}
