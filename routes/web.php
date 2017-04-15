<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::post('/amozeshbot/bot.php','AmozeshBot@controll');



Route::get('fupdate',function(){


	App\Food::truncate();

	$contents = file_get_contents('http://jeton.araku.ac.ir/Ghaza.aspx?date=960126');

	$DOM = new DOMDocument;
	$DOM->loadHTML('<?xml encoding="UTF-8">' .$contents);

	$table=$DOM->getElementById('TABLE1');
	$items = $table->getElementsByTagName('td');

	for($i=4; $i<$items->length;$i++)
	{
	    if($i % 4!=0&&$i % 4!=1)
	    {
	        $text="\n";
	        foreach ($items->item($i)->getElementsByTagName('li') as $item) 
	        {
	            $text.=$item->nodeValue."   ";
	        }
	        // dd($text);
			$food=new \App\Food;
	        $food->foods=$text;
			$food->save();
	    }
	}


	$contents = file_get_contents('http://jeton.araku.ac.ir/Ghaza.aspx?date=960202');

	$DOM = new DOMDocument;
	$DOM->loadHTML('<?xml encoding="UTF-8">' .$contents);

	$table=$DOM->getElementById('TABLE1');
	$items = $table->getElementsByTagName('td');

	// dd($items->length);
	for($i=4; $i<$items->length;$i++)
	{
	    if($i % 4!=0&&$i % 4!=1)
	    {
	        $text="\n";
	        foreach ($items->item($i)->getElementsByTagName('li') as $item) 
	        {
	            $text.=$item->nodeValue."   ";
	        }
	        // dd($text);
			$food=new \App\Food;
	        $food->foods=$text;
			$food->save();
	    }
	}



});


Route::get('fall',function(){
	return App\Food::all();
});



Route::post('jeton/bot.php','jeton@control');




Route::get('pytest',function(){
	$user_id='110374168';
	$pyPath = 'python3';
	$appPath=app_path().'/loginStep2.py';
	$config='2>&1'; //Redirect stderr to stdout, so you can see errors
	$command="$pyPath $appPath $config $user_id";
	exec($command, $out, $status);
	return $out;
});





