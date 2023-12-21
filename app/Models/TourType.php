<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourType extends Model
{
    use HasFactory;
    protected $table = 'tour_types';
    public $timestamps = true;

    protected $fillable = [
        'tt_name',
        'tt_description',
        'tt_image'
    ];

    public function createOrUpdate($request , $id ='')
    {
        $params = $request->except(['images', '_token']);
        if (isset($request->images) && !empty($request->images)) {
            $image = upload_image('images');
            if ($image['code'] == 1)
                $params['tt_image'] = $image['name'];
        }
        if ($id) {
            return $this->find($id)->update($params);
        }
        return $this->create($params);
    }

    public function tours()
    {
        return $this->hasMany(Tour::class, 't_tourtype_id', 'id');
    }
    
}
