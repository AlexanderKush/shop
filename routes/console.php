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
