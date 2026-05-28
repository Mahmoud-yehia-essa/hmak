<?php

use App\Models\Header;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CamalController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\PlanneController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PayMentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TeamWorkController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteColorController;
use App\Http\Controllers\AboutAdminController;
use App\Http\Controllers\AppVersionController;
use App\Http\Controllers\QuestionAIController;
use App\Http\Controllers\SociaMediaController;
use App\Http\Controllers\CompanyWorkController;
use App\Http\Controllers\ContactInfoController;
use App\Http\Controllers\SocialmediaController;
use App\Http\Controllers\UserServiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CompanyClientController;
use App\Http\Controllers\CompanyJourneyController;
use App\Http\Controllers\AdminNewsEyeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\ServiceCommentController;
use App\Http\Controllers\HomeSliderController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Frontend\FrontNewsController;
use App\Http\Controllers\UserServicePaymentController;
use App\Http\Controllers\Frontend\FrontClientController;
use App\Http\Controllers\Frontend\FrontPlanneController;
use App\Http\Controllers\Frontend\FrontAiAgentController;
use App\Http\Controllers\Frontend\FrontContactController;
use App\Http\Controllers\Frontend\FrontGalleryController;
use App\Http\Controllers\Frontend\FrontServiceController;
use App\Http\Controllers\NotificationDashboardController;
use App\Http\Controllers\Frontend\FrontTeamWorkController;
use App\Http\Controllers\Frontend\user\FrontUserController;
use App\Http\Controllers\Frontend\FrontCompanyWorkController;
use App\Http\Controllers\Frontend\FrontCompanyProfileController;
use App\Http\Controllers\Frontend\FrontNewsEyeController;
use App\Http\Controllers\Frontend\FrontGroupController;
use App\Http\Controllers\MarketCategoryController;

// Route::get('/', function () {
//     // return view('welcome');
//     // return redirect()->route('dashboard');
//     // return view('frontend.index');


//         return view('frontend.index');


// });



/// FrontEnd  ///


Route::controller(IndexController::class)->group(function () {


    Route::get('/main', 'showHome')->name('show.home');
    Route::get('/article/details/{id}', 'showArticleDetails')->name('show.article.details');
    Route::get('/market', 'showMarket')->name('market.public.index');
    Route::get('/market/main/{id}', 'showMarketMain')->name('market.public.main');
    Route::get('/market/sub/{id}', 'showMarketSub')->name('market.public.sub');
    Route::get('/market/subsub/{id}', 'showMarketSubSub')->name('market.public.subsub');
    Route::get('/market/item/{id}', 'showMarketItemDetails')->name('market.public.item_details');

    // إضافة إعلان جديد
    Route::get('/market/add-item', 'createMarketItem')->name('market.public.add_item')->middleware('auth');
    Route::post('/market/store-item', 'storeMarketItem')->name('market.public.store_item')->middleware('auth');
    Route::get('/market/item/delete/{id}', 'deleteMarketItem')->name('market.public.delete_item')->middleware('auth');

    // روابط جلب الفئات بالـ AJAX
    Route::get('/market/api/subcategories/{main_id}', 'getSubcategories');
    Route::get('/market/api/subsubcategories/{sub_id}', 'getSubSubcategories');

    // مكتبة حماك الصوتية (الواجهة الأمامية)
    Route::get('/sound-library', 'showSoundLibrary')->name('front.sound_library.index');
    Route::get('/sound-library/category/{id}', 'showSoundLibraryCategory')->name('front.sound_library.category');
    Route::get('/sound-library/author/{id}', 'showSoundLibraryAuthor')->name('front.sound_library.author');

    // حماك الخير (الواجهة الأمامية)
    Route::get('/help', 'showHmakHelp')->name('front.help.index');
    Route::get('/help/apply/{category_id}', 'createHmakHelpRequest')->name('front.help.apply')->middleware('auth');
    Route::post('/help/store', 'storeHmakHelpRequest')->name('front.help.store')->middleware('auth');
    Route::get('/help/success', 'showHelpSuccess')->name('front.help.success');

    // ساحة منافسة حماك الثقافية (إنشاء لعبة)
    Route::get('/competition/create', 'createCompetition')->name('front.competition.create');
    Route::post('/competition/store', 'storeCompetition')->name('front.competition.store');
    Route::get('/competition/play/{id}', 'playCompetition')->name('front.competition.play');
    Route::post('/competition/play/{id}/answer', 'answerQuestion')->name('front.competition.answer');
});


Route::controller(IndexController::class)->group(function () {


    Route::get('/', 'showSoon')->name('show.soon');


});




Route::controller(AboutController::class)->group(function () {


    Route::get('/about', 'showAbout')->name('show.about');


});


Route::controller(FrontServiceController::class)->group(function () {


    Route::get('/services', 'showServices')->name('show.services');


        Route::get('/services/details/{id}', 'showServicesDetails')->name('show.services.details');



});


Route::controller(FrontAiAgentController::class)->group(function () {


    Route::get('/ai-agent', 'showAiAgent')->name('show.ai.agent');


// Route::get('/ai-agent', [FrontAiAgentController::class,'showAiAgent']);
Route::post('/ai-agent/ask', 'askAiAgent');


});



Route::controller(FrontCompanyProfileController::class)->group(function () {


    Route::get('/company/profile', 'sowCompanyProfile')->name('show.company.profile');


// Route::get('/ai-agent', [FrontAiAgentController::class,'showAiAgent']);


});




Route::controller(FrontTeamWorkController::class)->group(function () {


    Route::get('/all/teams', 'showTeamWork')->name('show.team.work');


        // Route::get('/services/details/{id}', 'showServicesDetails')->name('show.services.details');



});





Route::controller(FrontGalleryController::class)->group(function () {


    Route::get('/galleries', 'showGallery')->name('show.gallery');


        Route::get('/gallery/details/{id}', 'galleryDetails')->name('gallery.details');



});

Route::controller(FrontCompanyWorkController::class)->group(function () {


    Route::get('/portfolio', 'showPortfolio')->name('show.portfolio');
        // Route::get('/portfolio/details/{id}', 'showServicesPortfolio')->name('show.portfolio.details');
        Route::get('/works/details/{id}', 'showServicesPortfolio')->name('show.portfolio.details');


});



Route::controller(FrontClientController::class)->group(function () {


    Route::get('/clients', 'showClient')->name('show.client');


});



Route::controller(FrontContactController::class)->group(function () {


Route::get('/contactus', 'showContactUs')->name('show.contactus');

Route::post('/add/contactus' , 'storeContactus')->name('add.contactus.store');



});


Route::controller(FrontPlanneController::class)->group(function () {






Route::get('/plans/details/{id}', 'showPlanne')->name('show.front.planne');



Route::post('/add/user/planne' , 'storePlanne')->name('add.planee.user.store');

Route::get('/planne/all/user', 'showAllPlanneUser')->name('show.all.planne.user');


});







Route::controller(FrontNewsController::class)->group(function () {


    Route::get('/news', 'showNews')->name('show.news');

        Route::get('/news/details/{id}', 'showNewsDetails')->name('show.news.details');

        Route::get('/news/search-ajax', 'searchAjax')->name('news.search.ajax');



});


// أنت عين الخبر – public routes (no auth required)
Route::controller(FrontNewsEyeController::class)->group(function () {
    Route::get('/news-eye', 'index')->name('front.news_eye.index');
    Route::get('/news-eye/{id}', 'show')->name('front.news_eye.show');
    Route::post('/news-eye/{id}/rate', 'rate')->name('front.news_eye.rate');
    Route::post('/news-eye/{id}/comment', 'comment')->name('front.news_eye.comment');
});

// المجموعات النقاشية – Discussion Groups
Route::controller(FrontGroupController::class)->group(function () {
    Route::get('/groups', 'index')->name('front.groups.index');
    Route::get('/groups/{id}', 'show')->name('front.groups.show');
    Route::get('/groups/subjects/{id}/reactions', 'getReactions')->name('front.groups.subject_reactions');
    Route::get('/groups/subjects/{id}', 'showSubject')->name('front.groups.show_subject');

    // Protected group routes (require role/auth check)
    Route::middleware(['role'])->group(function () {
        Route::get('/groups/create/new', 'create')->name('front.groups.create');
        Route::post('/groups/create/new', 'store')->name('front.groups.store');
        Route::post('/groups/{id}/join', 'join')->name('front.groups.join');
        Route::post('/groups/{id}/leave', 'leave')->name('front.groups.leave');
        Route::post('/groups/{id}/subjects', 'storeSubject')->name('front.groups.store_subject');
        Route::post('/groups/subjects/{id}/like', 'likeSubject')->name('front.groups.like_subject');
        Route::post('/groups/subjects/{id}/dislike', 'dislikeSubject')->name('front.groups.dislike_subject');
        Route::post('/groups/subjects/{id}/comments', 'storeComment')->name('front.groups.store_comment');
        Route::delete('/groups/comments/{id}', 'deleteComment')->name('front.groups.delete_comment');
        Route::delete('/groups/subjects/{id}', 'deleteSubject')->name('front.groups.delete_subject');
        Route::delete('/groups/{id}', 'deleteGroup')->name('front.groups.delete_group');
        Route::delete('/groups/{id}/members/{userId}', 'removeMember')->name('front.groups.remove_member');
    });
});




// Route::controller(FrontUserController::class)->middleware(['role'])->group(function () {


//     Route::get('/user/login', 'showLogin')->name('show.user.login');

//     Route::get('/user/register', 'showRegister')->name('show.user.register');

//         Route::get('/user/dashboard', 'showUserDashboard')->name('show.user.dashboard');
//     Route::post('/user/dashboard', 'addUserFrontStore')->name('add.user.front.store');




// });
// Route::controller(FrontUserController::class)->middleware(['role'])->group(function () {
//     Route::get('/user/login', 'showLogin')->name('show.user.login');
//     Route::get('/user/register', 'showRegister')->name('show.user.register');
//     Route::get('/user/dashboard', 'showUserDashboard')->name('show.user.dashboard');
//     Route::post('/user/dashboard', 'addUserFrontStore')->name('add.user.front.store');
// });





Route::controller(FrontUserController::class)->group(function () {
    // Public routes

    Route::post('/user/dashboard', 'addUserFrontStore')->name('add.user.front.store');
Route::get('/user/messages/fetch/{id}','fetchUserMessages')->name('fetch.user.messages');
Route::post('/user/messages/add-ajax','addUserMessagesAjax')->name('add.user.messages.ajax');


});


Route::controller(FrontUserController::class)->middleware(['role'])->group(function () {
    // // Public routes
    Route::get('/user/login', 'showLogin')->name('show.user.login');
    Route::get('/user/register', 'showRegister')->name('show.user.register');

    // Dashboard protected by role middleware
    Route::get('/user/dashboard', 'showUserDashboard')->name('show.user.dashboard');
    Route::post('/user/news-eye/store', 'storeNewsEye')->name('user.news_eye.store');
    Route::get('/user/dashboard/order', 'showUserDashboardOrder')->name('show.user.dashboard.order');



    Route::post('/user/login', 'showLoginStore')->name('show.user.login.store');


    Route::get('/user/dashboard/logout', 'destroyLogout')->name('user.logout.dashboard');


    Route::get('/user/dashboard/new/order', 'showAddNewOrder')->name('show.add.new.order');

    Route::post('/user/dashboard/new/order', 'addNewOrderStore')->name('add.new.order.store');



    Route::get('/user/messages/{id}', 'showUserMessages')->name('show.user.messages');
    Route::post('/user/add/messages', 'addUserMessagesStore')->name('add.user.messages.store');

Route::post('/user/dashboard/new/order', 'addNewOrderStore')->name('add.new.order.store');


/// for chat with ajax

/////



});






///



// Route::post('/orders/complete', [OrderController::class, 'complete'])
//     ->name('orders.complete');


    // Route::view('/orders/test', 'orders.test'); // test form page

    Route::get('/orders/test', [OrderController::class, 'ordersTest'])
    ->name('orders.complete');

Route::post('/orders/complete', [OrderController::class, 'complete'])
    ->name('orders.complete');

// Route::get('/dashboard', function () {
//     return view('admin.index');
// })->middleware(['auth', 'verified','checkUserRole'])->name('dashboard');


Route::controller(DashboardController::class)->middleware(['auth', 'verified','checkUserRole'])->group(function () {


    Route::get('/dashboard', 'showDashboard')->name('dashboard');


});

Route::controller(NotificationController::class)->middleware(['checkUserRole','auth'])->group(function () {


    Route::get('/add/notification', 'sendNotification')->name('send.notification');
    Route::get('/all/notification', 'alldNotification')->name('all.notification');


});



Route::controller(NotificationDashboardController::class)->middleware(['auth'])->group(function () {



    Route::get('/notification/read/{id}' , 'setNotificationRead')->name('notification.read');

});


Route::controller(AppVersionController::class)->middleware(['checkUserRole','auth'])->group(function () {


    Route::get('/add/versions', 'addVersions')->name('add.versions');
    Route::post('/update/versions', 'updateVersions')->name('update.versions.store');


});


Route::controller(ContactUsController::class)->middleware(['checkUserRole','auth'])->group(function () {


    Route::get('/all/contactus', 'allContactUs')->name('all.contact.us');
    Route::get('/delete/contactus/{id}' , 'deleteContactUs')->name('delete.contact.us');


});






Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');




});


Route::controller(AdminController::class)
->middleware(['checkUserRole','auth'])
->group(function () {
    // Route::get('/admin/logout', 'destroy')->name('admin.logout');

    Route::get('/admin/profile', 'adminProfile')->name('admin.profile');

    Route::post('/admin/profile', 'adminProfileStore')->name('admin.profile.store');

    Route::get('/admin/change/password', 'AdminChangePassword')->name('admin.change.password');


    Route::post('/admin/update/password', 'AdminUpdatePassword')->name('update.password');







});



Route::controller(GalleryController::class)->middleware(['checkUserRole','auth'])->group(function () {

    // Show all galleries
    Route::get('/admin/gallery', 'index')->name('all.gallery');

    // Add gallery form
    Route::get('/admin/add/gallery', 'create')->name('add.gallery');

    // Store new gallery
    Route::post('/add/gallery', 'store')->name('add.gallery.store');

    // Edit gallery form
    Route::get('/admin/edit/gallery/{id}', 'edit')->name('edit.gallery');

    // Update gallery
    Route::post('/edit/gallery', 'update')->name('edit.gallery.store');

    // Delete gallery
    Route::get('/delete/gallery/{id}', 'destroy')->name('delete.gallery');

    // Delete single photo from gallery
    Route::get('/gallery/photo/delete/{id}', 'deletePhoto')->name('delete.gallery.photo');
});


Route::controller(HomeSliderController::class)->middleware(['checkUserRole','auth'])->group(function () {
    Route::get('/admin/home-sliders', 'allHomeSliders')->name('all.home_sliders');
    Route::get('/admin/add/home-slider', 'addHomeSlider')->name('add.home_slider');
    Route::post('/add/home-slider', 'storeHomeSlider')->name('add.home_slider.store');
    Route::get('/admin/edit/home-slider/{id}', 'editHomeSlider')->name('edit.home_slider');
    Route::post('/edit/home-slider', 'updateHomeSliderStore')->name('edit.home_slider.store');
    Route::get('/delete/home-slider/{id}', 'deleteHomeSlider')->name('delete.home_slider');
});


Route::controller(CategoryController::class)->middleware(['checkUserRole','auth'])->group(function () {
    Route::get('/admin/category', 'category')->name('all.category');

    Route::get('/admin/add/category', 'addCategory')->name('add.category');


    Route::post('/add/category' , 'storeCategory')->name('add.category.store');

    Route::get('/admin/edit/category/{id}', 'editCategort')->name('edit.category');

    Route::post('/edit/category' , 'editCategortStore')->name('edit.category.store');


    Route::get('/delete/category/{id}' , 'deleteCategory')->name('delete.category');

    Route::get('/category/inactive/{id}', 'categoryInactive')->name('inactive.category');


    Route::get('/category/active/{id}', 'categoryActive')->name('active.category');



});

Route::controller(AdminNewsEyeController::class)->middleware(['checkUserRole','auth'])->group(function () {
    Route::get('/admin/news-eye', 'index')->name('admin.news_eye.index');
    Route::post('/admin/news-eye/update-status', 'updateStatus')->name('admin.news_eye.update_status');
    Route::get('/admin/news-eye/delete/{id}', 'destroy')->name('admin.news_eye.delete');
});

Route::controller(UserController::class)->middleware(['checkUserRole','auth'])->group(function () {
    Route::get('/users/all', 'getAllUsers')->name('all.users');

        Route::get('/owners/all', 'getAllOwners')->name('all.owners');
        Route::get('/admin/all', 'getAllAdmin')->name('all.admin');

    Route::get('/user/add', 'addUser')->name('add.user');

    Route::post('/user/add', 'addUserStore')->name('add.user.store');




    Route::get('/user/edit/{id}', 'editUser')->name('edit.user');

    Route::post('/user/edit', 'editUserStore')->name('edit.user.store');



    Route::get('/user/inactive/{id}', 'userInactive')->name('inactive.user');


    Route::get('/user/active/{id}', 'userActive')->name('active.user');


    Route::get('/user/delete/{id}', 'deleteUser')->name('delete.user');









});




Route::controller(CamalController::class)->middleware(['checkUserRole','auth'])->group(function () {
    Route::get('/camal/all', 'getAllCamal')->name('all.camal');


    Route::get('/camal/add', 'addCamal')->name('add.camal');

    Route::post('/camal/add', 'addCamalStore')->name('add.camal.store');




    Route::get('/camal/edit/{id}', 'editCamal')->name('edit.camal');

        Route::get('/camal/all/edit/{owner_id}', 'editAllCamal')->name('edit.all.camal');
        Route::post('/camal/all/edit/store', 'editAllCamalStore')->name('edit.all.camal.store');


    Route::post('/camal/edit', 'editCamalStore')->name('edit.camal.store');



    Route::get('/camal/inactive/{id}', 'camalInactive')->name('inactive.camal');


    Route::get('/camal/active/{id}', 'camalActive')->name('active.camal');


    Route::get('/camal/delete/{id}', 'deleteCamal')->name('delete.camal');









});






Route::controller(GameController::class)->middleware(['checkUserRole','auth'])->group(function () {

    Route::get('/games/all', 'allGames')->name('all.games');

    Route::get('/games/details/{id}', 'detailsGames')->name('details.games');
    Route::get('/games/delete/{id}', 'deleteGame')->name('delete.games');


});




Route::controller(AdsController::class)->middleware(['checkUserRole','auth'])->group(function(){

    Route::get('/add/ads' , 'addAds')->name('add.ads');

    // addAds
});

 // Report All Route
 Route::controller(ReportController::class)->middleware(['checkUserRole','auth'])->group(function(){

    Route::get('/report/view' , 'ReportView')->name('report.view');


    Route::post('/search/by/date' , 'SearchByDate')->name('search-by-date');

    Route::post('/search/by/month' , 'SearchByMonth')->name('search-by-month');
    Route::post('/search/by/year' , 'SearchByYear')->name('search-by-year');

    Route::get('/order/by/user' , 'OrderByUser')->name('order.by.user');
    Route::post('/search/by/user' , 'SearchByUser')->name('search-by-user');


});

Route::controller(QuestionController::class)->middleware(['checkUserRole','auth'])->group(function () {

    Route::get('/admin/add/question', 'addQuestion')->name('add.question');
    Route::post('/admin/add/question', 'addQuestionStore')->name('add.question.store');


    Route::get('/admin/all/question', 'allQuestion')->name('all.question');


    Route::get('/admin/edit/question/{id}', 'editQuestion')->name('edit.question');


    Route::post('/admin/edit/question', 'editQuestionStore')->name('edit.question.store');


    Route::get('/question/delete/{id}', 'deleteQuestion')->name('delete.question');









});


// Coupon controller

 Route::controller(CouponController::class)->middleware(['checkUserRole','auth'])->group(function(){




    ///

         Route::get('/all/coupon', 'AllCoupon')->name('all.coupon');
        Route::get('/add/coupon', 'AddCoupon')->name('add.coupon');
        Route::post('/store/coupon', 'StoreCoupon')->name('store.coupon');

        Route::get('/edit/coupon/{id}', 'EditCoupon')->name('edit.coupon');
        Route::post('/update/coupon', 'UpdateCoupon')->name('update.coupon');
        Route::get('/delete/coupon/{id}', 'DeleteCoupon')->name('delete.coupon');


});


/// price

 Route::controller(PriceController::class)->middleware(['checkUserRole','auth'])->group(function(){




    ///

         Route::get('/all/price', 'allPrice')->name('all.price');
        Route::get('/add/price', 'addPrice')->name('add.price');
        Route::post('/add/price', 'addPriceStore')->name('add.price.store');

                Route::get('/delete/price/{id}', 'deletePrice')->name('delete.price');
        Route::get('/edit/price/{id}', 'editPrice')->name('edit.price');



        Route::post('/edit/price', 'editPriceStore')->name('edit.price.store');


});





Route::controller(ServiceController::class)->middleware(['checkUserRole','auth'])->group(function () {
    Route::get('/all/service', 'allService')->name('all.service');

    Route::get('/add/service', 'addService')->name('add.service');


    Route::post('/add/service' , 'storeService')->name('add.service.store');

    Route::get('/edit/service/{id}', 'editService')->name('edit.service');

    Route::post('/edit/service' , 'editServiceStore')->name('edit.service.store');


    Route::get('/delete/service/{id}' , 'deleteService')->name('delete.service');

    Route::get('/service/inactive/{id}', 'serviceInactive')->name('inactive.service');


    Route::get('/service/active/{id}', 'serviceActive')->name('active.service');



});




Route::controller(CompanyWorkController::class)->middleware(['checkUserRole','auth'])->group(function () {
    Route::get('/all/work', 'allWork')->name('all.work');

    Route::get('/add/work', 'addWork')->name('add.work');


    Route::post('/add/work' , 'storeWork')->name('add.work.store');

    Route::get('/edit/work/{id}', 'editWork')->name('edit.work');

    Route::post('/edit/work' , 'editWorkStore')->name('edit.work.store');


    Route::get('/delete/work/{id}' , 'deleteWork')->name('delete.work');

    Route::get('/work/inactive/{id}', 'workInactive')->name('inactive.work');


    Route::get('/work/active/{id}', 'workActive')->name('active.work');



});





Route::controller(AboutAdminController::class)->middleware(['checkUserRole','auth'])->group(function () {
    Route::get('/all/about', 'allAbout')->name('all.about');

    Route::get('/add/about', 'addAbout')->name('add.about');


    Route::post('/add/about' , 'storeAbout')->name('add.about.store');

    Route::get('/edit/about/{id}', 'editAbout')->name('edit.about');

    Route::post('/edit/about' , 'editAboutStore')->name('edit.about.store');


    Route::get('/delete/about/{id}' , 'deleteAbout')->name('delete.about');

    // Route::get('/work/inactive/{id}', 'workInactive')->name('inactive.work');


    // Route::get('/work/active/{id}', 'workActive')->name('active.work');



});


Route::controller(ContactInfoController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {
        Route::get('/contact/info', 'index')->name('contact.info');
        Route::post('/contact/info/update', 'update')->name('contact.info.update');
    });


Route::controller(SiteColorController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {
        Route::get('/site/colors', 'index')->name('site.colors');
        Route::post('/site/colors/update', 'update')->name('site.colors.update');
    });


Route::controller(PlanneController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {

        Route::get('/all/plans', 'allPlans')->name('all.plans');

        Route::get('/add/plan', 'addPlan')->name('add.plan');

        Route::post('/add/plan', 'storePlan')->name('add.plan.store');

        Route::get('/edit/plan/{id}', 'editPlan')->name('edit.plan');

        Route::post('/edit/plan', 'editPlanStore')->name('edit.plan.store');

        Route::get('/delete/plan/{id}', 'deletePlan')->name('delete.plan');

        Route::get('/plan/inactive/{id}', 'planInactive')->name('inactive.plan');

        Route::get('/plan/active/{id}', 'planActive')->name('active.plan');


         Route::get('/all/user/plans', 'allUserPlans')->name('all.user.plans');

                 Route::get('/delete/user/plan/{id}', 'deleteUserPlans')->name('delete.user.plan');



});







Route::controller(TeamWorkController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {

        Route::get('/all/teamworks', 'allTeamworks')->name('all.teamworks');

        Route::get('/add/teamwork', 'addTeamwork')->name('add.teamwork');

        Route::post('/add/teamwork', 'storeTeamwork')->name('add.teamwork.store');

        Route::get('/edit/teamwork/{id}', 'editTeamwork')->name('edit.teamwork');

        Route::post('/edit/teamwork', 'editTeamworkStore')->name('edit.teamwork.store');

        Route::get('/delete/teamwork/{id}', 'deleteTeamwork')->name('delete.teamwork');

        Route::get('/teamwork/inactive/{id}', 'teamworkInactive')->name('inactive.teamwork');

});


Route::controller(ArticleController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {
        Route::get('/all/articles', 'allArticles')->name('all.articles');
        Route::get('/add/article', 'addArticle')->name('add.article');
        Route::post('/add/article', 'storeArticle')->name('add.article.store');
        Route::get('/edit/article/{id}', 'editArticle')->name('edit.article');
        Route::post('/edit/article', 'updateArticleStore')->name('edit.article.store');
        Route::get('/delete/article/{id}', 'deleteArticle')->name('delete.article');
    });



Route::controller(NewsController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {

        // عرض كل الأخبار
        Route::get('/all/news', 'allNews')->name('all.news');

        // صفحة إضافة خبر جديد
        Route::get('/add/news', 'addNews')->name('add.news');

        // تخزين خبر جديد
        Route::post('/add/news', 'storeNews')->name('add.news.store');

        // صفحة تعديل الخبر
        Route::get('/edit/news/{id}', 'editNews')->name('edit.news');

        // تحديث الخبر
        Route::post('/edit/news', 'editNewsStore')->name('edit.news.store');

        // حذف الخبر
        Route::get('/delete/news/{id}', 'deleteNews')->name('delete.news');

        // جعل الخبر غير نشط
        Route::get('/news/inactive/{id}', 'newsInactive')->name('inactive.news');

        // جعل الخبر نشط
        Route::get('/news/active/{id}', 'newsActive')->name('active.news');

});


Route::controller(App\Http\Controllers\AiNewsGeneratorController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {
        // صفحة توليد الأخبار بالذكاء الاصطناعي
        Route::get('/admin/ai-news/generator', 'index')->name('admin.ai_news.generator');
        // توليد الأخبار بالذكاء الاصطناعي
        Route::post('/admin/ai-news/generate', 'generate')->name('admin.ai_news.generate');
        // حفظ الخبر المولد
        Route::post('/admin/ai-news/store', 'store')->name('admin.ai_news.store');
    });


Route::controller(App\Http\Controllers\NewsCategoryController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {
        // عرض كل التصنيفات
        Route::get('/all/news/categories', 'allNewsCategories')->name('all.news.categories');
        // صفحة إضافة تصنيف جديد
        Route::get('/add/news/category', 'addNewsCategory')->name('add.news.category');
        // تخزين تصنيف جديد
        Route::post('/add/news/category', 'storeNewsCategory')->name('add.news.category.store');
        // صفحة تعديل التصنيف
        Route::get('/edit/news/category/{id}', 'editNewsCategory')->name('edit.news.category');
        // تحديث التصنيف
        Route::post('/edit/news/category', 'editNewsCategoryStore')->name('edit.news.category.store');
        // حذف التصنيف
        Route::get('/delete/news/category/{id}', 'deleteNewsCategory')->name('delete.news.category');
    });


Route::controller(App\Http\Controllers\SoundLibraryController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {
        // Sound Categories
        Route::get('/all/sound/categories', 'allSoundCategories')->name('all.sound.categories');
        Route::get('/add/sound/category', 'addSoundCategory')->name('add.sound.category');
        Route::post('/add/sound/category', 'storeSoundCategory')->name('store.sound.category');
        Route::get('/edit/sound/category/{id}', 'editSoundCategory')->name('edit.sound.category');
        Route::post('/edit/sound/category', 'updateSoundCategory')->name('update.sound.category');
        Route::get('/delete/sound/category/{id}', 'deleteSoundCategory')->name('delete.sound.category');

        // Sound Authors
        Route::get('/all/sound/authors', 'allSoundAuthors')->name('all.sound.authors');
        Route::get('/add/sound/author', 'addSoundAuthor')->name('add.sound.author');
        Route::post('/add/sound/author', 'storeSoundAuthor')->name('store.sound.author');
        Route::get('/edit/sound/author/{id}', 'editSoundAuthor')->name('edit.sound.author');
        Route::post('/edit/sound/author', 'updateSoundAuthor')->name('update.sound.author');
        Route::get('/delete/sound/author/{id}', 'deleteSoundAuthor')->name('delete.sound.author');

        // Sounds
        Route::get('/all/sounds', 'allSoundLibraries')->name('all.sound.libraries');
        Route::get('/add/sound', 'addSoundLibrary')->name('add.sound.library');
        Route::post('/add/sound', 'storeSoundLibrary')->name('store.sound.library');
        Route::get('/edit/sound/{id}', 'editSoundLibrary')->name('edit.sound.library');
        Route::post('/edit/sound', 'updateSoundLibrary')->name('update.sound.library');
        Route::get('/delete/sound/{id}', 'deleteSoundLibrary')->name('delete.sound.library');
    });


Route::controller(App\Http\Controllers\HmakHelpController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {
        // Categories
        Route::get('/all/help/categories', 'allHelpCategories')->name('all.help.categories');
        Route::get('/add/help/category', 'addHelpCategory')->name('add.help.category');
        Route::post('/store/help/category', 'storeHelpCategory')->name('store.help.category');
        Route::get('/edit/help/category/{id}', 'editHelpCategory')->name('edit.help.category');
        Route::post('/update/help/category', 'updateHelpCategory')->name('update.help.category');
        Route::get('/delete/help/category/{id}', 'deleteHelpCategory')->name('delete.help.category');

        // Help Requests
        Route::get('/all/help/requests', 'allHelpRequests')->name('all.help.requests');
        Route::post('/update/help/request/status', 'updateRequestStatus')->name('update.help.request.status');
        Route::get('/delete/help/request/{id}', 'deleteHelpRequest')->name('delete.help.request');
    });


Route::controller(App\Http\Controllers\SocialmediaController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {

        Route::get('/all/social_media', 'allSocialMedia')->name('all.social_media');

        Route::get('/add/social_media', 'addSocialMedia')->name('add.social_media');
        Route::post('/add/social_media', 'storeSocialMedia')->name('add.social_media.store');

        Route::get('/edit/social_media/{id}', 'editSocialMedia')->name('edit.social_media');
        Route::post('/edit/social_media', 'updateSocialMedia')->name('edit.social_media.store');

        Route::get('/delete/social_media/{id}', 'deleteSocialMedia')->name('delete.social_media');

    });




Route::controller(CompanyClientController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {

        Route::get('/all/company_clients', 'allCompanyClients')->name('all.company_clients');

        Route::get('/add/company_client', 'addCompanyClient')->name('add.company_client');

        Route::post('/add/company_client', 'storeCompanyClient')->name('add.company_client.store');

        Route::get('/edit/company_client/{id}', 'editCompanyClient')->name('edit.company_client');

        Route::post('/edit/company_client', 'editCompanyClientStore')->name('edit.company_client.store');

        Route::get('/delete/company_client/{id}', 'deleteCompanyClient')->name('delete.company_client');

        Route::get('/company_client/inactive/{id}', 'clientInactive')->name('inactive.company_client');

        Route::get('/company_client/active/{id}', 'clientActive')->name('active.company_client');
});



Route::controller(CompanyJourneyController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {

    Route::get('/all/journeys', 'allJourney')->name('all.journeys');

    Route::get('/add/journey', 'addJourney')->name('add.journey');
    Route::post('/add/journey', 'storeJourney')->name('add.journey.store');

    Route::get('/edit/journey/{id}', 'editJourney')->name('edit.journey');
    Route::post('/edit/journey', 'editJourneyStore')->name('edit.journey.store');

    Route::get('/delete/journey/{id}', 'deleteJourney')->name('delete.journey');

    Route::get('/journey/inactive/{id}', 'journeyInactive')->name('inactive.journey');
    Route::get('/journey/active/{id}', 'journeyActive')->name('active.journey');
});




Route::controller(ServiceCommentController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {


});


// Route::controller(UserServiceController::class)
//     ->middleware(['checkUserRole','auth'])
//     ->group(function () {

//         // List all user services
//         Route::get('/all/user_services', 'allUserServices')->name('all.user_services');

//         // Add new user service
//         Route::get('/add/user_service', 'addUserService')->name('add.user_service');
//         Route::post('/store/user_service', 'storeUserService')->name('store.user_service');

//         // Edit user service
//         Route::get('/edit/user_service/{id}', 'editUserService')->name('edit.user_service');
//         Route::post('/update/user_service', 'updateUserService')->name('update.user_service');

//         // Delete user service
//         Route::get('/delete/user_service/{id}', 'deleteUserService')->name('delete.user_service');

//         // Admin attach final file
//         Route::post('/user_service/attach_final', 'attachFinalFile')->name('user_service.attach_final');
// });

Route::controller(UserServicePaymentController::class)
    ->middleware(['auth','checkUserRole'])
    ->group(function () {
        Route::post('/user-service-payment/update-status', 'updatePaymentStatus')->name('update.payment.status');
    });




// Route::controller(UserServiceController::class)
//     ->middleware(['checkUserRole','auth'])
//     ->group(function () {

//         Route::get('/all/user_services', 'allUserServices')->name('all.user_services');

//         Route::get('/add/user_service', 'addUserService')->name('add.user_service');

//         Route::post('/store/user_service', 'storeUserService')->name('store.user_service');

//         Route::get('/edit/user_service/{id}', 'editUserService')->name('edit.user_service');

//         Route::post('/update/user_service', 'updateUserService')->name('update.user_service');

//         Route::get('/delete/user_service/{id}', 'deleteUserService')->name('delete.user_service');
//         Route::get('/update/payment/status', 'updatePaymentStatus')->name('update.payment.status');


// });

Route::controller(UserServiceController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {

        Route::get('/all/user_services', 'allUserServices')->name('all.user_services');

        Route::get('/add/user_service', 'addUserService')->name('add.user_service');

        Route::post('/store/user_service', 'storeUserService')->name('store.user_service');

        Route::get('/edit/user_service/{id}', 'editUserService')->name('edit.user_service');

        Route::post('/update/user_service', 'updateUserService')->name('update.user_service');

        Route::get('/delete/user_service/{id}', 'deleteUserService')->name('delete.user_service');



        Route::get('/all/user/chat/admin/{id}', 'allChatAdminMessage')->name('all.chat.admin.message');

                Route::post('/all/user/chat/admin/store', 'addChatAdminMessageStore')->name('add.chat.admin.store');



                ///Ajax
Route::get('/admin/messages/fetch/{id}','fetchUserMessages')->name('fetch.admin.messages');
Route::post('/admin/messages/add-ajax','addUserMessagesAjax')->name('add.admin.messages.ajax');

// Ajax



        // ✅ هنا الغي GET واستعمل POST
        Route::post('/update/payment/status', 'updatePaymentStatus')->name('update.payment.status');

});




 Route::controller(SponsorController::class)->middleware(['checkUserRole','auth'])->group(function(){

    Route::get('/add/sponsor/home/cate' , 'addSponsorHomeCate')->name('sponsor.add.cate');
        Route::get('/add/sponsor/question' , 'addSponsorQuestion')->name('sponsor.add.question');


        Route::post('/edit/sponsor/home/cate', 'editHomeCateStore')->name('edit.home.cate.store');

    // Route::post('/search/by/date' , 'SearchByDate')->name('search-by-date');

    // Route::post('/search/by/month' , 'SearchByMonth')->name('search-by-month');
    // Route::post('/search/by/year' , 'SearchByYear')->name('search-by-year');

    // Route::get('/order/by/user' , 'OrderByUser')->name('order.by.user');
    // Route::post('/search/by/user' , 'SearchByUser')->name('search-by-user');


});




 Route::controller(HeaderController::class)->middleware(['checkUserRole','auth'])->group(function(){




    Route::get('/edit/header/home' , 'editSHeaderHomeCate')->name('home.edit.header');
        // Route::get('/edit/sponsor/question' , 'addSponsorQuestion')->name('sponsor.add.question');


        Route::post('/edit/header/home', 'editHomeHeaderStore')->name('edit.home.header.store');

    // Route::post('/search/by/date' , 'SearchByDate')->name('search-by-date');

    // Route::post('/search/by/month' , 'SearchByMonth')->name('search-by-month');
    // Route::post('/search/by/year' , 'SearchByYear')->name('search-by-year');

    // Route::get('/order/by/user' , 'OrderByUser')->name('order.by.user');
    // Route::post('/search/by/user' , 'SearchByUser')->name('search-by-user');


});



 Route::controller(HomeController::class)->middleware(['checkUserRole','auth'])->group(function(){


                 Route::get('/all/home', 'allHome')->name('all.home');

    Route::get('/edit/home/{id}' , 'editHome')->name('edit.home');
        // Route::get('/edit/sponsor/question' , 'addSponsorQuestion')->name('sponsor.add.question');


        Route::post('/edit/home', 'editHomeStore')->name('edit.home.store');




    Route::get('/home/inactive/{id}', 'homeInactive')->name('inactive.home');

    Route::get('/home/active/{id}', 'homeActive')->name('active.home');


    // Route::post('/search/by/date' , 'SearchByDate')->name('search-by-date');

    // Route::post('/search/by/month' , 'SearchByMonth')->name('search-by-month');
    // Route::post('/search/by/year' , 'SearchByYear')->name('search-by-year');

    // Route::get('/order/by/user' , 'OrderByUser')->name('order.by.user');
    // Route::post('/search/by/user' , 'SearchByUser')->name('search-by-user');


});




 Route::controller(CounterController::class)->middleware(['checkUserRole','auth'])->group(function(){


                 Route::get('/all/counter', 'allCounter')->name('all.counter');

    Route::get('/edit/counter/{id}' , 'editCounter')->name('edit.counter');


        Route::post('/edit/counter', 'editCounterStore')->name('edit.counter.store');




    Route::get('/counter/inactive/{id}', 'counterInactive')->name('inactive.counter');

    Route::get('/counter/active/{id}', 'counterActive')->name('active.counter');


    // Route::post('/search/by/date' , 'SearchByDate')->name('search-by-date');

    // Route::post('/search/by/month' , 'SearchByMonth')->name('search-by-month');
    // Route::post('/search/by/year' , 'SearchByYear')->name('search-by-year');

    // Route::get('/order/by/user' , 'OrderByUser')->name('order.by.user');
    // Route::post('/search/by/user' , 'SearchByUser')->name('search-by-user');


});





Route::controller(QuestionAIController::class)->middleware(['checkUserRole','auth'])->group(function () {

    Route::get('/admin/add/question/ai', 'addQuestionAi')->name('add.question.ai');
    Route::post('/admin/add/question/to/game/ai', 'addQuestionToGameAi')->name('add.question.to.game.ai');


    Route::post('/admin/get/question/ai', 'getdQuestionStoreAi')->name('get.question.store.ai');


    Route::get('/admin/all/question/ai', 'allQuestionAi')->name('all.question.ai');


    Route::get('/admin/edit/question/ai/{id}', 'editQuestionAi')->name('edit.question.ai');


    Route::post('/admin/edit/question/ai', 'editQuestionStoreAi')->name('edit.question.store.ai');


    Route::get('/question/delete/ai/{id}', 'deleteQuestionAi')->name('delete.question.ai');









});


Route::get('/payment', [PayMentController::class, 'showPaymentPage']);

Route::controller(MarketCategoryController::class)->middleware(['checkUserRole','auth'])->group(function () {
    // الفئات الرئيسية للسوق
    Route::get('/admin/market/main-categories', 'mainIndex')->name('market.main_categories.index');
    Route::get('/admin/market/main-categories/create', 'mainCreate')->name('market.main_categories.create');
    Route::post('/admin/market/main-categories/store', 'mainStore')->name('market.main_categories.store');
    Route::get('/admin/market/main-categories/edit/{id}', 'mainEdit')->name('market.main_categories.edit');
    Route::post('/admin/market/main-categories/update', 'mainUpdate')->name('market.main_categories.update');
    Route::get('/admin/market/main-categories/delete/{id}', 'mainDelete')->name('market.main_categories.delete');

    // الفئات الفرعية للسوق
    Route::get('/admin/market/sub-categories', 'subIndex')->name('market.sub_categories.index');
    Route::get('/admin/market/sub-categories/create', 'subCreate')->name('market.sub_categories.create');
    Route::post('/admin/market/sub-categories/store', 'subStore')->name('market.sub_categories.store');
    Route::get('/admin/market/sub-categories/edit/{id}', 'subEdit')->name('market.sub_categories.edit');
    Route::post('/admin/market/sub-categories/update', 'subUpdate')->name('market.sub_categories.update');
    Route::get('/admin/market/sub-categories/delete/{id}', 'subDelete')->name('market.sub_categories.delete');

    // الفئات الفرعية المتفرعة
    Route::get('/admin/market/sub-sub-categories', 'subSubIndex')->name('market.sub_sub_categories.index');
    Route::get('/admin/market/sub-sub-categories/create', 'subSubCreate')->name('market.sub_sub_categories.create');
    Route::post('/admin/market/sub-sub-categories/store', 'subSubStore')->name('market.sub_sub_categories.store');
    Route::get('/admin/market/sub-sub-categories/edit/{id}', 'subSubEdit')->name('market.sub_sub_categories.edit');
    Route::post('/admin/market/sub-sub-categories/update', 'subSubUpdate')->name('market.sub_sub_categories.update');
    Route::get('/admin/market/sub-sub-categories/delete/{id}', 'subSubDelete')->name('market.sub_sub_categories.delete');

    // إدارة المنتجات المضافة من المستخدمين
    Route::get('/admin/market/items', 'itemsIndex')->name('market.items.index');
    Route::get('/admin/market/items/delete/{id}', 'itemsDelete')->name('market.items.delete');
    Route::get('/admin/market/items/toggle-status/{id}', 'itemsToggleStatus')->name('market.items.toggle_status');
});

require __DIR__.'/auth.php';
