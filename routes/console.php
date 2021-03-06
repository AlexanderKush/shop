<?php

use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('orderTest',function () {

    $order = Order::first();

    $order->products->each(function ($product) {
        dump ($product->pivot->quantity);
    });

});

Artisan::command('importCategoriesFromFile', function () {

    $file = fopen('categories.csv', 'r');

    $i = 0;
    $insert = [];
    while ($row = fgetcsv($file, 1000, ';')) {
        if ($i++ == 0) {
            $bom = pack('H*', 'EFBBBF');
            $row = preg_replace("/^$bom/", '', $row);
            $columns = $row;
            continue;
        }

        $data = array_combine($columns, $row);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $insert[] = $data;
    }

    Category::insert($insert);
});

Artisan::command('parseEkatalog', function () {

    function getProductsPage($url, $data = '')
    {

        if (!$data) {
            $data = file_get_contents($url);
        }
        $dom = new DOMDocument();
        @$dom->loadHTML($data);

        $xpath = new DOMXPath($dom);
        $divs = $xpath->query("//div[@class='model-short-div list-item--goods   ']");

        foreach ($divs as $div) {
            $a = $xpath->query('descendant::a[@class="model-short-title no-u"]', $div)[0];
            $name = $a->nodeValue;

            if (empty($name)) continue;

            $price = '';
            $range = $xpath->query('descendant::div[@class="model-price-range"]', $div)[0];
            if ($range) {
                $price =  mb_substr(trim(explode('??????', $range->nodeValue)[0]), 1);
            }
            $range = $xpath->query('descendant::div[@class="pr31 ib"]', $div)[0];
            if ($range) {
                $price = trim($range->nodeValue);
            }

            $products[] = [
                'name' => $name,
                'price' => $price
            ];
        }

        return $products;
    }

    $url = 'https://www.e-katalog.ru/ek-list.php?katalog_=189&search_=rtx+3090';

    $data = file_get_contents($url);
    $dom = new DOMDocument();
    @$dom->loadHTML($data);

    $xpath = new DOMXPath($dom);
    $divs = $xpath->query("//div[contains(@class, 'model-short-div')]");

    $totalProductsString = $xpath->query('//span[@class="t-g-q"]')[0]->nodeValue ?? false;
    $totalProducts = preg_replace('/[^0-9]/', '', $totalProductsString);
    $productsOnePage = $divs->length;
    $totalPages = ceil($totalProducts / $productsOnePage) - 1;

    $products = [];

    $products = getProductsPage($url, $data);

    for ($i = 1; $i <= $totalPages; $i++) {
        $nextUrl = $url . '&page_=' . $i;
        $products = array_merge($products, getProductsPage($nextUrl));
    }

    $file = fopen('videocards.csv', 'w');
    foreach ($products as $product) {
        fputcsv($file, $product, ';');
    }
    fclose($file);
});

Artisan::command('massCategoriesInsert', function () {

    $categories = [
        [
            'name' => '????????????????????',
            'description' => '???????? rtx 3050',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => '????????????????????',
            'description' => '???????? i5',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]
    ];

    Category::insert($categories);
});

Artisan::command('updateCategory', function () {
    Category::where('id', 2)->update([
        'name' => '????????????????????',
    ]);
});

Artisan::command('deleteCategory', function () {
    /* $category = Category::find(1);
    $category->delete(); */
    /* Category::where('id', 2)->delete(); */
    Category::whereNotNull('id')->delete();
});

Artisan::command('createCategory', function () {
    //Auth::loginUsingId(1);
    $category = new Category([
        'name' => '????????????????????1',
        'description' => '???????? rtx 3050 1'
    ]);
    $category->save();
});


Artisan::command('inspire', function () {

    $user = User::find(1);
    $addresses = $user->addresses->filter(function ($adress) {
        return $adress->main;
    })->pluck('address');

    $addresses = $user->addresses()->where('main', 1)->get();
    //dd($addresses);

    //$this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('queryBuilder', function () {

    $data = DB::table('categories as c')
        ->select(
            'c.name',
            'c.description'
        )
        ->where('name', '????????????????????')
        ->get();

    $data = DB::table('categories as c')
        ->select(
            'c.name',
            DB::raw('count(p.id) as product_quantity'),
            DB::raw('sum(p.price) as priceAmount')
        )
        ->leftJoin('products as p', function ($join) {
            $join->on('c.id', 'p.category_id');
        })
        ->groupBy('c.id')
        ->get();

        DB::table('categories')
            ->orderBy('id')
            ->chunk(3, function ($categories) {
                dump($categories->count());
            });

        //dd($data);

});