<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Auth::routes(['verify' => true]);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/TestNotification', 'NotificationController@TestNotification')->name('TestNotification');
Route::get('/TestIosNotification', 'NotificationController@TestIosNotification')->name('TestIosNotification');
Route::get('/TestAndroidNotification', 'NotificationController@TestAndroidNotification')->name('TestAndroidNotification');
Route::post('register', 'AuthApiController@register');
Route::post('login', 'AuthApiController@login');
Route::post('logintest', 'AuthApiController@googleloginfun');
Route::post('recover', 'AuthApiController@recover');
Route::get('passwordotp', 'AuthApiController@passowordsendOTP');
Route::post('verifyPasswordResetOtp', 'AuthApiController@verifyPasswordResetOtp');
Route::post('sendPasswordResetMail', 'AuthApiController@passowordResetMail');
Route::post('validate_password', 'AuthApiController@validatechangeOTP');

Route::get('faq'           , 'FAQController@getFAQ');
Route::get('brands'           , 'AppController@getBrand');
Route::post('models'          , 'AppController@getModel');
Route::get('bank_list', 'BankController@banklist');
Route::get('get_car_wash_price', 'AppController@getCarWashPrice');
Route::get('rewards'         , 'RewardController@rewardlists');


Route::group(['middleware' => ['jwt.auth:api']], function() {    
	Route::get('vehicle_color', 'ApiVehicleColor@get_colors');
	Route::get('vehicle_type', 'VehicleColorController@type');
	Route::get('profile_info', 'UserController@profileinfo');
	Route::post('update_info', 'UserController@editprofileinfo');
	Route::post('editEmail', 'UserController@editEmail');
	Route::post('verifyEmailOtp', 'UserController@verifyEmailOtp');
	Route::post('verifyMobileOtp', 'UserController@verifyMobileOtp');
	Route::post('editMobileNumber', 'UserController@editMobileNumber');

	Route::get('account_settings', 'UserApiController@accountsetting');
	Route::post('account_settings', 'UserApiController@editaccountsetting');

    Route::get('logout', 'AuthApiController@logout');
	Route::post('change_password', 'AuthApiController@change_password');
	Route::get('otp', 'AuthApiController@sendOTP');
	Route::post('validate_otp', 'AuthApiController@validateOTP');
	Route::post('validate_otp', 'AuthApiController@validateOTP');

	Route::get('promocode', 'PromoController@validatePromoCode');
	Route::post('complaint'       , 'AppController@Complaintraise');
	Route::post('support'         , 'AppController@Support');

	// Route::post('wallet_balance'         , 'WalletController@getBalance');
	Route::post('washer_request'         , 'UserController@washerRequest');
	Route::get('available_washes'         , 'WasherController@availableWashes');
	Route::get('washer_history'         , 'WasherController@availableWashes');
	Route::get('accepted_wash'         , 'WasherController@acceptedWash');
	Route::get('accepted_wash_info'         , 'WasherController@acceptedWashInfo');
	Route::get('vehicle_details'         , 'WasherController@vehicle_pic');
	Route::post('accept_wash'         , 'WasherController@acceptWash');
	Route::post('start_wash'         , 'WasherController@startWash');
	Route::post('complete_wash'         , 'WasherController@completeWash');
	Route::post('cancel_wash'         , 'WasherController@cancelWash');
	Route::get('wash_date_list'         , 'WasherController@washListDate');
	Route::get('wash_week_list'         , 'WasherController@washListweek');
	Route::get('washer_bank_details'         , 'WasherController@bank_details');
	Route::post('washer_bank_details'         , 'WasherController@savebank_details');
	Route::get('washer_details'         , 'WasherController@bank_details');
	Route::post('wash_list_by_date'         , 'WasherController@washListByDate');
	Route::post('wash_list_by_week'         , 'WasherController@washListByWeek');
	Route::post('wash_list'         , 'WasherController@acceptWash');
	Route::post('redeem_history'         , 'RedeemController@redeemList');


	Route::get('reward_points'         , 'RewardController@rewards');
	Route::get('user_rewards'         , 'RewardController@userrewards');
	// Route::post('user_rewards_redeem'         , 'RewardController@redeemrewards');
	Route::get('my_rewards'         , 'RewardController@myrewards');

	Route::post('primary_selection'         , 'UserController@viewmyprimary');

	Route::post('edit_car'         , 'UserController@editMyCar');
	Route::post('delete_car'         , 'UserController@deleteMyCar');
	Route::post('my_car'         , 'UserController@addMyCar');
	Route::post('set_primary_car'         , 'UserController@setPrimaryCar');
	Route::get('my_car'         , 'UserController@viewMycar');


	Route::post('edit_card'         , 'PaymentCardController@editMyCard');
	Route::post('delete_card'         , 'PaymentCardController@deleteMyCard');
	Route::post('my_card'         , 'PaymentCardController@addMyCard');
	Route::post('set_primary_card'         , 'PaymentCardController@setPrimaryCard');
	Route::get('my_card'         , 'PaymentCardController@viewMycard');


	Route::post('create_epin', 'UserApiController@create_epin');
	Route::post('validate_otp', 'AuthApiController@validateOTP');
	Route::get('otp', 'AuthApiController@sendOTP');
	// Route::get('my_transactions'         , 'WalletController@getTransactions');
	Route::get('package', 'AppController@get_package');
	Route::get('my_orders'         , 'UserController@viewMyorders');
	Route::get('my_pending_orders'         , 'UserController@viewPendingOrder');



	//promo code validation

	Route::post('carwash_request_create', 'AppController@carWashrequestcreate');
	Route::get('notifications'         , 'UserController@notifications');
	Route::get('notifications/delete'         , 'UserController@deletenotification');
	Route::get('notifications/deleteall'         , 'UserController@deleteallnotification');
	Route::get('orders', 'UserController@myorders');
	Route::get('promocodelist', 'PromoController@promocodelist');
	Route::get('promocode', 'PromoController@validatePromoCode');
	// Route::post('get_hash', 'WalletController@createHash');
	Route::post('request_callback', 'UserController@request_callback');
	Route::post('profile_pic', 'UserController@profilepic');


	// Route::post('payment/status', 'PayTMController@paymentCallback');
	// Route::post('paytm/generatechecksum', 'PaytmAppController@generatechecksum');
	// Route::post('paytm/verifychecksum', 'PaytmAppController@verifychecksum');
	// Route::post('paytm/verifytransaction', 'PaytmAppController@verifytransaction');



	Route::get('check_washer', 'WasherController@checkstatus');
	Route::post('book_car_wash', 'CarWashBookingController@addcarwashbooking');
	Route::post('car_wash_detail', 'CarWashBookingController@carWashDetail');
	Route::get('request_date_list'         , 'CarWashBookingController@washListDate');
	Route::get('request_week_list'         , 'CarWashBookingController@washListweek');
	Route::post('request_list_by_date'         , 'CarWashBookingController@washListByDate');
	Route::post('request_list_by_week'         , 'CarWashBookingController@washListByWeek');
	Route::get('book_car_wash_list', 'CarWashBookingController@viewMyCarWashBooking');
	Route::get('scheduled_car_wash_list', 'CarWashBookingController@viewMyCarWashScheduleBooking');
	Route::post('cancel_car_wash', 'CarWashBookingController@cancelcarwashbooking');
	Route::get('redeemStamp', 'PromoStampsController@redeemStamp');
	Route::post('redeemPromo', 'PromoStampsController@redeemPromo');
	Route::post('validate_promo', 'PromoStampsController@validatePromoCode');
	Route::post('irredeemPromo', 'PromoStampsController@iredeemPromo');
	Route::get('promoList', 'PromoStampsController@promoList');
	Route::get('user_rewards_redeem', 'PromoStampsController@userRewardsRedeem');
	Route::get('promoHistory', 'PromoStampsController@promoHistory');
	Route::get('washer_reward_data', 'WasherController@washerRewardData');
	Route::post('redeem_washer_reward', 'WasherController@redeemWasherReward');
	Route::get('history_washer_reward', 'WasherController@historyWasherReward');
	Route::post('rate_washer', 'CarWashBookingController@rateWasher');
	Route::post('set_notification_token',"PushNotificationController@store");
	Route::post('sendMessage',"BookingChatController@store");
	Route::post('getMessages',"BookingChatController@getMessages");
	Route::post('getPushList',"NotificationController@getPushList");
	Route::post('deletePushList',"NotificationController@deletePushList");
	Route::post('deletePush',"NotificationController@deletePush");
	Route::post('washerAccountDetail',"WasherBankDetailController@store");

	Route::get('getFaq',"FaqVoteController@index");
	Route::post('voteFaq',"FaqVoteController@store");

	Route::get('startedWash', 'WasherController@startedWash');
	Route::post('readPush', 'NotificationController@readPush');
	Route::post('unread_counter', 'NotificationController@unread_counter');
	Route::post('checkVerification', 'WasherController@checkVerification');
	Route::post('edit_address', 'UserController@editAddress');

}); 

?>