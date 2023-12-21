<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDate extends Model
{
    use HasFactory;
    protected $table = 'tour_details';
    public $timestamps = true;

    protected $fillable = [
        'td_start_date',
        'td_end_date',
        'td_tour_id',
        'number_registered',
        'td_status',
        'td_follow',
        'td_guide_id'
    ];
    
    const STATUS = [
        0 => 'Chưa xác định',
        1 => 'Đang mở đăng ký',
        2 => 'Đang chuẩn bị',
        3 => 'Đang khởi hành',
        4 => 'Đã hoàn tất',
        5 => 'Đã hủy'
    ];
    
    const CLASS_STATUS = [
        0 => 'btn-info',
        1 => 'btn-info',
        2 => 'btn-success',
        3 => 'btn-warning',
        4 => 'btn-primary', // Change key 4 to a different class
        5 => 'btn-danger',
    ];
    
    
    public function createOrUpdate($request , $id ='')
    {
        $params = $request->except([ '_token', 'submit']);

        $params['td_status'] = 1;
            
        if ($id) {
            return $this->find($id)->update($params);
        }
        return $this->create($params);
    }
   
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'td_tour_id', 'id');
    }
    public function guide()
    {
        return $this->belongsTo(Staff::class, 'td_guide_id', 'id');
    }
    public function bookTour()
    {
        return $this->hasMany(BookTour::class, 'b_tourdetail_id', 'id');
    }
    
    
}
