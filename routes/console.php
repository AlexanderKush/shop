<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

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

Artisan::command('parseEkatalog', function () {

    function mb_str_replace($search, $replace, $string)
    {
        $charset = mb_detect_encoding($string);
        $unicodeString = iconv($charset, "UTF-8", $string);
        return str_replace($search, $replace, $unicodeString);
    }

    $url = 'https://www.e-katalog.ru/ek-list.php?katalog_=189&search_=rtx+3090';

    $data = file_get_contents($url);

    $dom = new DOMDocument();
    @$dom->loadHTML($data);

    $xpath = new DOMXPath($dom);

    $totalProductsString = $xpath->query('//span[@class="t-g-q"]')[0]->nodeValue ?? false;
    $totalProducts = preg_replace('/[^0-9]/', '', $totalProductsString);

    $products = [];

    function getProductPage() {

        $divs = $xpath->query('//div[contains(@class, \'model-short-div\']');
        
    }

    $divs = $xpath->query('//div[contains(@class, \'model-short-div\']');

    $productsOnePage = $divs->length;

    $totalPages = ceil($totalProducts / $productsOnePage);

    foreach ($divs as $div) {
        $a = $xpath->query('descendant::a[@class="model-short-title no-u"]', $div)[0];
        $name = $a->nodeValue;

        $price = '';
        $range = $xpath->query('descendant::div[@class="model-price-range"]', $div)[0];
        if ($range) {
            $price =  mb_substr(trim(explode('Сра', $range->nodeValue)[0]), 1);
            /* foreach ($range->childNodes as $child) {
                if ($child->nodeName == 'a') {
                    $price = trim($child->nodeValue);
                }
            } */
            
            dump($price);
        }
        $range = $xpath->query('descendant::div[@class="pr31 ib"]', $div)[0];
        if ($range) {
            $price = trim($range->nodeValue);
        }
    }

    for ($i = 1; $i < $totalPages; $i++) {
        $nextUrl = $url . '&page_=' . $i;
    }

});

Artisan::command('massCategoriesInsert', function () {

    $categories = [
        [
            'name' => 'Видеокарты',
            'description' => 'Ждём rtx 3050',
            'created_at' => date('Y-m-d H:i:s') 
        ],
        [
            'name' => 'Процессоры',
            'description' => 'Ждём i5',
            'created_at' => date('Y-m-d H:i:s')
        ]
    ];

    Category::insert($categories);

});

Artisan::command('updateCategory', function () {
    Category::where('id', 2)->update([
        'name' => 'Процессоры',
    ]);
});

Artisan::command('deleteCategory', function () {
    /* $category = Category::find(1);
    $category->delete(); */
    /* Category::where('id', 2)->delete(); */
    Category::whereNotNull('id')->delete();
});

Artisan::command('createCategory', function () {
    $category = new Category([
        'name' => 'Видеокарты',
        'description' => 'Ждём rtx 3050'
    ]);
    $category->save();
});


Artisan::command('inspire', function () {

    $user = User::find(1);
    $addresses = $user->addresses->filter(function ($adress) {
        return $adress->main;
    })->pluck('address');

    $addresses = $user->addresses()->where('main', 1)->get();
    dd($addresses);

    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
