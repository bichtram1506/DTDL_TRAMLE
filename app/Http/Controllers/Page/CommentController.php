<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Region;
use App\Models\BookTour;
use App\Models\CommentImage;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //

    public function __construct(Comment $comment)
    {
        $regions = Region::with('locations')->get(); // Truy vấn regions và locations
        
        view()->share([
            'regions' => $regions, // Truyền biến regions vào view
        ]);
    }
    public function comment(Request $request)
    {

        if($request->ajax()) {
            try {
                $comment = new Comment();
                if ($request->tour_id) {
                    $comment->cm_tour_id = $request->tour_id;
                }
                if ($request->article_id) {
                    $comment->cm_article_id = $request->article_id;
                }
                if ($request->hotel_id) {
                    $comment->cm_hotel_id = $request->hotel_id;
                }
                if ($request->cm_rating) {
                    $comment->cm_rating = $request->cm_rating;
                }
             
                $comment->cm_user_id = Auth::guard('users')->user()->id;
                $comment->cm_content = $request->message;
                $comment->cm_status = 1;
                $comment->save();
                if (!empty($uploadedImages)) {
                    foreach ($uploadedImages as $imagePath) {
                        $image = new CommentImage();
                        
                        // Sửa tên trường thành 'ci_comment_id' thay vì 'cicomment_id'
                        $image->ci_comment_id = $comment->id;
                        
                        // Sửa tên trường thành 'ci_images' thay vì 'ci_image'
                        $image->ci_images = $imagePath;
                        
                        $image->save();
                    }
                }
                
                $comment = $comment->with('user')->find($comment->id);
                $html =  view('page.common.itemComment',compact('comment'))->render();
                return response([
                    'code' => 200,
                    'html' => $html
                ]);
            } catch (\Exception $exception) {
                return response([
                    'code' => 404,
                    'html' => ''
                ]);
            }
        }
    }

    public function delete($id)
    {
        //
        $comment = Comment::find($id);
        if (!$comment) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $comment->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }

    public function submitReview(Request $request)
    {
        // Validate dữ liệu nhập từ biểu mẫu
        $validatedData = $request->validate([
            'cm_rating' => 'required|integer|min:1|max:5',
            'cm_content' => 'required|string|max:255',
            'cm_booktour_id' => 'required|integer',
            // Các trường khác của đánh giá (nếu có)
        ]);
        $bookTour = BookTour::findOrFail($request->input('cm_booktour_id'));
        $eventdate = $bookTour->eventdate;
        // Tạo một bản ghi đánh giá mới và điền thông tin từ biểu mẫu
        $comment = new Comment();
        $comment->cm_rating = $request->input('cm_rating');
        $comment->cm_content = $request->input('cm_content');
        $comment->cm_booktour_id = $request->input('cm_booktour_id');
        $comment->cm_status = 1;
        $comment->cm_user_id = Auth::guard('users')->user()->id;
        $comment->cm_tour_id = $eventdate->td_tour_id; // Lấy cm_tour_id từ eventdate
        // Các trường khác của đánh giá (nếu có)
    
        // Lưu đánh giá vào CSDL
        $comment->save();
    
        // Redirect hoặc thực hiện các hành động cần thiết sau khi lưu đánh giá
    
        return redirect()->route('my.tour', ['id' => $request->input('cm_booktour_id')])
            ->with('success', 'Đánh giá đã được gửi thành công!');
    }
    public function showReviewForm($id)
    {
        // Truy vấn đơn đặt tour theo ID và user_id
        $bookTour = BookTour::where('id', $id)
        ->where('b_user_id', Auth::guard('users')->user()->id)
        ->where('b_status', 4)
        ->firstOrFail();
    
        $eventdate = $bookTour->eventdate;
        $tour = $eventdate->tour;
    
        // Trả về view hiển thị biểu mẫu đánh giá và truyền đối tượng đơn đặt tour tới view
        return view('page.comment.create', ['bookTour' => $bookTour,'eventdate' => $eventdate, 'tour' => $tour]);
    }

}
