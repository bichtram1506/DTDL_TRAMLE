<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Thêm dòng này vào đầu file
use Illuminate\Support\Str;


class Tour extends Model
{
    use HasFactory;
    protected $table = 'tours';
    public $timestamps = true;

    protected $fillable = [
        't_title',
        't_journeys',
        't_day',
        't_night',
        't_starting_gate',
        't_code',
        't_number_guests',
        't_content',
        't_image',
        't_status',
        't_description',
        't_tourtype_id',
        't_staff_id',
        't_sale',
        't_price_adults',
        't_price_children',
        't_min_participants',
        't_type',
        't_note',
        't_views',
        'service_ids',
        'vehicle_ids',
        'attraction_ids',
    ];

    const STATUS = [
        0 => 'Đang xác nhận',
        1 => 'Đang bán',
        2 => 'Ẩn',
        3 => 'Đang thiết kế',
        4 => 'Đã hoàn thành',
    ];
    protected $casts = [
        'service_ids' => 'array', // Đảm bảo rằng Laravel biết cột này chứa mảng
        'vehicle_ids' => 'array',
        'attraction_ids' => 'array',
    ];
    
    public function createOrUpdate(Request $request, $id = '')
    {
        $params = $request->except(['images', '_token', 'submit', 'selected_hotels', 'vehicle_ids', 'selected_locations', 'service_ids', 'attraction_ids', 'selected_extraServices']);
    
        // Lấy giá trị từ checkboxes và đặt vào mảng service_ids
   // Lấy giá trị từ checkboxes và đặt vào mảng service_ids với mô tả
            $selectedServices = $request->input('service_ids', []);
            $serviceDescriptions = [];

        foreach ($selectedServices as $serviceId) {
            $descriptionKey = 'service_descriptions.' . $serviceId;
            $serviceDescriptions[$serviceId] = $request->input($descriptionKey, '');
        }

        $params['service_ids'] = json_encode([
            'selected_services' => $selectedServices,
            'descriptions' => $serviceDescriptions,
        ]);

        $params['vehicle_ids'] = json_encode($request->input('vehicle_ids', []));
        $params['attraction_ids'] = json_encode($request->input('attraction_ids', []));
    
        if (isset($request->images) && !empty($request->images)) {
            $image = upload_image('images');
            if ($image['code'] == 1) {
                $params['t_image'] = $image['name'];
            }
        }
    
        $params['t_staff_id'] = Auth::user()->id;
    
        // Sinh mã tự động cho cột t_code
        $randomPart = substr(md5(rand()), 0, 6);
        $params['t_code'] = 'TOUR' . $randomPart;
    
        if ($id) {
            $tour = $this->find($id);
            $tour->update($params);
    
            $selectedLocations = $request->input('selected_locations', []);
            $tour->locations()->sync($selectedLocations); // Thêm điểm đến cho tour
    
            $selectedHotels = $request->input('selected_hotels', []);
            $tour->hotels()->sync($selectedHotels);
    
            $selectedExtra_services = $request->input('selected_extraServices', []);
            $extraServicePrices = $request->input('service_prices', []);
    
            $syncData = [];
            foreach ($selectedExtra_services as $index => $extraServiceId) {
                $price = isset($extraServicePrices[$extraServiceId]) ? $extraServicePrices[$extraServiceId] : null;
                $syncData[$extraServiceId] = ['price' => $price];
            }
    
            $tour->extra_services()->sync($syncData);
    
            return $tour;
        }
    
        $tour = $this->create($params);
    
        $selectedHotels = $request->input('selected_hotels', []);
        $tour->hotels()->attach($selectedHotels);
    
        $selectedLocations = $request->input('selected_locations', []);
        $tour->locations()->attach($selectedLocations); // Thêm điểm đến cho tour
    
        $selectedExtra_services = $request->input('selected_extraServices', []);
        $extraServicePrices = $request->input('service_prices', []);
    
        $syncData = [];
        foreach ($selectedExtra_services as $extraServiceId) {
            $price = isset($extraServicePrices[$extraServiceId]) ? $extraServicePrices[$extraServiceId] : null;
            $syncData[$extraServiceId] = ['price' => $price];
        }
    
        $tour->extra_services()->sync($syncData);
    
        return $tour;
    }
    

    public function staff()
    {
        return $this->belongsTo(Staff::class, 't_staff_id', 'id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class, 'cm_tour_id', 'id');
    }
    public function commentCount()
    {
        return $this->comments()->whereIn('cm_status',[1,2])->count();
    }

    public function eventdate()
    {
        return $this->hasMany(EventDate::class, 'td_tour_id', 'id');
    }

    public function touritineraries()
    {
        return $this->hasMany(TourItinerarie::class, 'ti_tour_id', 'id');
    }// Lấy danh sách tour_itineraries


    public function  favorites()
    {
        return $this->hasMany(Favorite::class, 'f_tour_id','id');
    }
    public function tourImages()
    {
        return $this->hasMany(TourImage::class, 'tm_tour_id', 'id');
    }
    public function tourtype()
    {
        return $this->belongsTo(TourType::class, 't_tourtype_id', 'id');
    }
    public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'tour_hotel');
    }

    public function extra_services()
    {
        return $this->belongsToMany(Service::class, 'tour_extraservice', 'tour_id', 'extra_service_id')
            ->withPivot('price')
            ->where('type', 2);
    }
    // Trong mô hình Tour
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'f_tour_id', 'f_user_id');
    }
    
    public function locations()
    {
        return $this->belongsToMany(Location::class, 'tour_location');
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class, 'p_tour_id', 'id');
    }
    public function quoteHistory()
    {
        return $this->hasMany(QuoteHistory::class);
    }
    public function quoteHistory_user()
    {
        return $this->hasMany(QuoteHistory::class)->where('status', 0);
    }

}