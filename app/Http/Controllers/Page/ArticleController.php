<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Region;

class ArticleController extends Controller
{

    public function __construct()
    {
        $regions = Region::with('locations')->get(); // Truy vấn regions và locations
        
        view()->share([
            'regions' => $regions, // Truyền biến regions vào view
           
        ]);
    }
    //
    public function index(Request $request)
    {
        $regions = Region::with('locations')->get(); 
        $articles = Article::active();
        $categories = Category::all(); // Assuming Category is the model for your categories table
    
        if ($request->key_search) {
            $articles->where('a_title', 'like', '%'.$request->key_search.'%');
        }
    
        if ($request->category) {
            // Assuming you have a relationship between Article and Category
            $articles->whereHas('category', function ($query) use ($request) {
                $query->where('id', $request->category);
            });
        }
    
        $articles = $articles->orderByDesc('id')->paginate(NUMBER_PAGINATION_PAGE);
        
        return view('page.articles.index', compact('articles', 'regions', 'categories'));
    }
    
    public function detail(Request $request, $id)
    {
        $article = Article::find($id);

        if (!$article) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        $categories = Category::with('news')->get();
        $articles = Article::active()->orderByDesc('id')->limit(NUMBER_PAGINATION_PAGE)->get();


        return view('page.articles.detail', compact('article', 'categories', 'articles'));
    }
    
    public function showByCategory(Request $request, $category)
    {
        $articles = Article::where('a_category_id', $category);
    
        if ($request->key_search) {
            $articles->where('a_title', 'like', '%' . $request->key_search . '%');
        }
    
        $articles = $articles->orderByDesc('id')->paginate(NUMBER_PAGINATION_PAGE);
    
        $categories = Category::all(); // Assuming Category is the model for your categories table
    
        return view('page.articles.index', compact('articles', 'categories'));
    }
    
    

}
