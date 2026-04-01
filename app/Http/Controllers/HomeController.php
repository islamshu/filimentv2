<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MainCats;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Country;
use App\Models\SubCategory;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function checkenv()
    {
        $products = Product::get();
        foreach ($products as $product) {
            FacadesDB::table('country_product')->insert([
                'product_id' => $product->id,
                'country_id' => 1,

            ]);
        }
    }

    public function index()
    {
        $countryId = session('country_id');

        $categorys = Category::has('subcategories')->get();
        $sliders = Slider::get();
        $main_cats = MainCats::get();
        $countries = Country::all();

        $hasOrder = SubCategory::where('is_homepage', 1)
            ->whereNotNull('order')
            ->exists();

        $subcategory = SubCategory::where('is_homepage', 1)
            ->whereHas('products', function ($query) use ($countryId) {
                if ($countryId) {
                    $query->whereHas('countries', function ($q) use ($countryId) {
                        $q->where('countries.id', $countryId);
                    });
                } else {
                    $query->whereRaw('0 = 1');
                }
            })
            ->with(['products' => function ($query) use ($countryId) {
                if ($countryId) {
                    $query->whereHas('countries', function ($q) use ($countryId) {
                        $q->where('countries.id', $countryId);
                    });
                }
            }])
            ->when($hasOrder, function ($query) {
                $query->orderBy('order', 'asc');
            }, function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->get();

        // معالجة المنتجات لكل قسم فرعي
        foreach ($subcategory as $category) {
            // ترتيب المنتجات حسب id تنازلياً
            $products = $category->products->sortByDesc('id');

            // تخزين جميع المنتجات في خاصية جديدة
            $category->all_products = $products;

            // تخزين أول 8 منتجات للعرض الأولي
            $category->initial_products = $products->take(9);

            // تحديد إذا كان هناك أكثر من 8 منتجات
            $category->has_more_products = $products->count() > 9;

            // العدد الإجمالي للمنتجات
            $category->total_products = $products->count();
        }

        // تحديد إذا كان هناك قسم فرعي واحد فقط
        $isSingleCategory = $subcategory->count() == 1;

        return view('frontend.index', compact(
            'categorys',
            'sliders',
            'main_cats',
            'subcategory',
            'countries',
            'isSingleCategory'
        ));
    }
    public function load_more(Request $request)
    {
        $categoryId = $request->category_id;
        $offset = $request->offset ?? 0;
        $limit = $request->limit ?? 9;
        $countryId = $request->country_id ?? session('country_id');

        $category = SubCategory::with(['products' => function ($query) use ($countryId, $offset, $limit) {
            if ($countryId) {
                $query->whereHas('countries', function ($q) use ($countryId) {
                    $q->where('countries.id', $countryId);
                });
            }
            $query->orderBy('id', 'desc')
                ->skip($offset)
                ->take($limit);
        }])->find($categoryId);

        $html = '';
        if ($category && $category->products) {
            foreach ($category->products as $item) {
                // إضافة كل منتج داخل div بنفس كلاسات الـ grid
                $html .= '<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 product-item">
                        ' . view('frontend.partials.product-card', ['item' => $item])->render() . '
                      </div>';
            }
        }

        return response()->json([
            'html' => $html,
            'has_more' => $category && $category->products->count() == $limit
        ]);
    }

    public function single_product($id)
    {
        $countryId = session('country_id');

        $product = Product::where('id', $id)
            ->whereHas('countries', function ($q) use ($countryId) {
                $q->where('countries.id', $countryId);
            })
            ->firstOrFail();

        return view('frontend.single_product', compact('product'));
    }

    public function category($slug)
    {
        $countryId = session('country_id');

        $category = SubCategory::where('slug', $slug)
            ->whereHas('products', function ($query) use ($countryId) {

                if ($countryId) {
                    $query->whereHas('countries', function ($q) use ($countryId) {
                        $q->where('countries.id', $countryId);
                    });
                } else {
                    $query->whereRaw('0 = 1'); // يمنع النتائج
                }
            })
            ->with(['products' => function ($query) use ($countryId) {

                if ($countryId) {
                    $query->whereHas('countries', function ($q) use ($countryId) {
                        $q->where('countries.id', $countryId);
                    });
                }
            }])
            ->firstOrFail();

        return view('frontend.category', compact('category'));
    }

    public function page($page)
    {
        return view('frontend.page', compact('page'));
    }

    public function csrab()
    {
        set_time_limit(300);

        MainCats::truncate();

        try {
            $response = Http::timeout(120)->get('https://ploteam-sa.store');
        } catch (\Exception $e) {
            return "Error fetching URL: " . $e->getMessage();
        }

        if ($response->successful()) {
            $htmlContent = $response->body();
            $crawler = new Crawler($htmlContent);

            $count = 0;

            $crawler->filter('div.text-center')->each(function (Crawler $node) use (&$count) {
                if ($node->filter('img')->count() && $node->filter('p')->count()) {
                    $imageUrl = $node->filter('img')->attr('src');
                    $text = $node->filter('p')->text();

                    try {
                        $imageContents = file_get_contents($imageUrl);
                        $imageName = basename($imageUrl);
                        $path = 'categories/' . uniqid() . '_' . $imageName;

                        Storage::disk('public')->put($path, $imageContents);
                    } catch (\Exception $e) {
                        return;
                    }

                    MainCats::create([
                        'title' => $text,
                        'image' => $path,
                    ]);

                    $count++;
                }
            });

            return "Import completed successfully. Imported items: " . $count;
        } else {
            return "Failed to get content from the URL.";
        }
    }

    private function convertToFloat($value)
    {
        $value = preg_replace('/[^0-9.]/', '', $value);
        return (float)$value;
    }
}
