<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;

use App\Models\Page;
use App\Models\Mode;
use App\Models\Banner;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductLang;
use App\Models\Option;
use App\Models\Currency;
use App\Models\Category;

class PageController extends Controller
{
    public function index($lang)
    {
        app()->setLocale($lang);

        $page = Page::where('slug', '/')->where('lang', $lang)->first();
        $banners = Banner::where('lang', $lang)->where('status', 1)->take(3)->get();
        $modeRecommended = Mode::where('slug', 'recommended')->first(); // For products
        $options = Option::get();
        $posts = Post::orderBy('created_at', 'desc')->where('lang', $lang)->take(3)->get();

        return view('index', ['page' => $page, 'banners' => $banners, 'modeRecommended' => $modeRecommended, 'options' => $options, 'posts' => $posts]);
    }

    public function catalog(Request $request, $lang, $parameters = '')
    {
        $page = Page::where('slug', 'catalog')->where('lang', $lang)->first();
        $options = Option::get();

        $typeId = $request->type;
        $query = Product::when($request->type > 0, function($queryType) use ($typeId) {
            $queryType->where('condition', $typeId);
          });

        if ($request->type_of_property > 0) {
            $propertyId = $request->type_of_property;
            $query->whereHas('options', function ($queryProperty) use ($propertyId) {
                    $queryProperty->where('id', $propertyId);
                });
        }

        if ($request->rooms > 0) {
            $roomsId = $request->rooms;
            $query->whereHas('options', function ($queryRooms) use ($roomsId) {
                    $queryRooms->where('id', $roomsId);
                });
        }

        $products = $query->paginate(15);
        $products->appends($request->query());

        return view('listings', ['page' => $page, 'products' => $products, 'options' => $options]);
    }

    public function page($lang, $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('page')->with('page', $page);
    }

    public function contacts()
    {
        $page = Page::where('slug', 'contacts')->firstOrFail();

        return view('contacts')->with('page', $page);
    }
}
