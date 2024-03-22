<?php

use App\Jobs\SendPendingApplicationNotifications;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/jobs', function () {
//    $users = User::where('profile_status', 0)->get();
//    foreach ($users as $user) {
//        Log::info("Dispatching job for user: {$user->id}");
//        SendPendingApplicationNotifications::dispatch($user);
//    }
//});


Route::get('/', function () {
    return to_route('login');
});


Route::get('/shortlisted', function () {
    foreach (User::where('profile_status',1)->where('status','Shortlisted')->get() as $user)
    {
//        Mail::to($user->email)->later(now()->addSeconds(20), new \App\Mail\ShortListed());
        \App\Jobs\SendShortListedJob::dispatch($user)->delay(now()->addSeconds(10));
        //send(new \App\Mail\ShortListed());
    }

    echo "Mail Send";
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $nationals = array(
            'Afghan',
            'Albanian',
            'Algerian',
            'American',
            'Andorran',
            'Angolan',
            'Antiguans',
            'Argentinean',
            'Armenian',
            'Australian',
            'Austrian',
            'Azerbaijani',
            'Bahamian',
            'Bahraini',
            'Bangladeshi',
            'Barbadian',
            'Barbudans',
            'Batswana',
            'Belarusian',
            'Belgian',
            'Belizean',
            'Beninese',
            'Bhutanese',
            'Bolivian',
            'Bosnian',
            'Brazilian',
            'British',
            'Bruneian',
            'Bulgarian',
            'Burkinabe',
            'Burmese',
            'Burundian',
            'Cambodian',
            'Cameroonian',
            'Canadian',
            'Cape Verdean',
            'Central African',
            'Chadian',
            'Chilean',
            'Chinese',
            'Colombian',
            'Comoran',
            'Congolese',
            'Costa Rican',
            'Croatian',
            'Cuban',
            'Cypriot',
            'Czech',
            'Danish',
            'Djibouti',
            'Dominican',
            'Dutch',
            'East Timorese',
            'Ecuadorean',
            'Egyptian',
            'Emirian',
            'Equatorial Guinean',
            'Eritrean',
            'Estonian',
            'Ethiopian',
            'Fijian',
            'Filipino',
            'Finnish',
            'French',
            'Gabonese',
            'Gambian',
            'Georgian',
            'German',
            'Ghanaian',
            'Greek',
            'Grenadian',
            'Guatemalan',
            'Guinea-Bissauan',
            'Guinean',
            'Guyanese',
            'Haitian',
            'Herzegovinian',
            'Honduran',
            'Hungarian',
            'I-Kiribati',
            'Icelander',
            'Indian',
            'Indonesian',
            'Iranian',
            'Iraqi',
            'Irish',
            'Israeli',
            'Italian',
            'Ivorian',
            'Jamaican',
            'Japanese',
            'Jordanian',
            'Kazakhstani',
            'Kenyan',
            'Kittian and Nevisian',
            'Kuwaiti',
            'Kyrgyz',
            'Laotian',
            'Latvian',
            'Lebanese',
            'Liberian',
            'Libyan',
            'Liechtensteiner',
            'Lithuanian',
            'Luxembourger',
            'Macedonian',
            'Malagasy',
            'Malawian',
            'Malaysian',
            'Maldivan',
            'Malian',
            'Maltese',
            'Marshallese',
            'Mauritanian',
            'Mauritian',
            'Mexican',
            'Micronesian',
            'Moldovan',
            'Monacan',
            'Mongolian',
            'Moroccan',
            'Mosotho',
            'Motswana',
            'Mozambican',
            'Namibian',
            'Nauruan',
            'Nepali',
            'New Zealander',
            'Nicaraguan',
            'Nigerian',
            'Nigerien',
            'North Korean',
            'Northern Irish',
            'Norwegian',
            'Omani',
            'Pakistani',
            'Palauan',
            'Panamanian',
            'Papua New Guinean',
            'Paraguayan',
            'Peruvian',
            'Polish',
            'Portuguese',
            'Qatari',
            'Romanian',
            'Russian',
            'Rwandan',
            'Saint Lucian',
            'Salvadoran',
            'Samoan',
            'San Marinese',
            'Sao Tomean',
            'Saudi',
            'Scottish',
            'Senegalese',
            'Serbian',
            'Seychellois',
            'Sierra Leonean',
            'Singaporean',
            'Slovakian',
            'Slovenian',
            'Solomon Islander',
            'Somali',
            'South African',
            'South Korean',
            'Spanish',
            'Sri Lankan',
            'Sudanese',
            'Surinamer',
            'Swazi',
            'Swedish',
            'Swiss',
            'Syrian',
            'Taiwanese',
            'Tajik',
            'Tanzanian',
            'Thai',
            'Togolese',
            'Tongan',
            'Trinidadian/Tobagonian',
            'Tunisian',
            'Turkish',
            'Tuvaluan',
            'Ugandan',
            'Ukrainian',
            'Uruguayan',
            'Uzbekistani',
            'Venezuelan',
            'Vietnamese',
            'Welsh',
            'Yemenite',
            'Zambian',
            'Zimbabwean'
        );
        return view('dashboard', compact('user', 'nationals'));
    });

    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');

    Route::put('user/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');

    Route::get('education/{user}/edit', [\App\Http\Controllers\EducationController::class, 'edit'])->name('education.edit');
    Route::post('education', [\App\Http\Controllers\EducationController::class, 'store'])->name('education.store');
    Route::delete('education/{education}/{user}', [\App\Http\Controllers\EducationController::class, 'destroy'])->name('education.destroy');


    Route::get('experience/{user}/edit', [\App\Http\Controllers\ExperienceController::class, 'edit'])->name('experience.edit');
    Route::post('experience', [\App\Http\Controllers\ExperienceController::class, 'store'])->name('experience.store');
    Route::delete('experience/{experience}/{user}', [\App\Http\Controllers\ExperienceController::class, 'destroy'])->name('experience.destroy');

    Route::get('submit/{user}/edit', [\App\Http\Controllers\ExperienceController::class, 'submit'])->name('submit.edit');
    Route::post('submit', [\App\Http\Controllers\ExperienceController::class, 'submitStore'])->name('submit.store');

    Route::get('candidate', [\App\Http\Controllers\UserController::class, 'index'])->name('candidate.index');
    Route::get('candidate/show/{user}', [\App\Http\Controllers\UserController::class, 'print'])->name('candidate.print');


    Route::get('reports/call-letters', [\App\Http\Controllers\ReportController::class, 'callLetters'])->name('report.call-letters');


    Route::post('shortlisted/submit/{user}', [\App\Http\Controllers\UserController::class, 'shortlisted'])->name('candidate.shortlisted');

    Route::get('start-session', [\App\Http\Controllers\RandomUserQuestionController::class, 'index'])->name('start_session');
    Route::post('save-answer', [\App\Http\Controllers\RandomUserQuestionController::class, 'store'])->name('save-answer');
});
