<?php

Breadcrumbs::register('admin.dashboard', function ($breadcrumbs) {
    $breadcrumbs->push(__('navs.backend.dashboard'), route('admin.dashboard'));
});

require __DIR__.'/Search.php';
require __DIR__.'/Access/User.php';
require __DIR__.'/Access/Role.php';
require __DIR__.'/Access/Permission.php';
require __DIR__.'/Page.php';
require __DIR__.'/Setting.php';
require __DIR__.'/Blog_Category.php';
require __DIR__.'/Blog_Tag.php';
require __DIR__.'/Blog_Management.php';
require __DIR__.'/Faqs.php';
require __DIR__.'/Menu.php';
require __DIR__.'/LogViewer.php';
require __DIR__.'/StandardPackingList.php';
require __DIR__.'/Country.php';
require __DIR__.'/Customer.php';
require __DIR__.'/Plant.php';
require __DIR__.'/WorldWideZoneChart.php';
require __DIR__.'/ExpressSaver.php';
require __DIR__.'/AirlineSlab.php';
require __DIR__.'/Estimate.php';
require __DIR__.'/Quotation.php';
require __DIR__.'/Cargo.php';
require __DIR__.'/Courier.php';
require __DIR__.'/Partner.php';
require __DIR__.'/Partnerfaq.php';
require __DIR__.'/Policy.php';
require __DIR__.'/Vehicle.php';
require __DIR__.'/UserPricing.php';
require __DIR__.'/PartnerPricing.php';
require __DIR__.'/PromoCode.php';
require __DIR__.'/RewardsTC.php';
require __DIR__.'/LoudHailer.php';

require __DIR__.'/PartnerRedemption.php';
require __DIR__.'/UserList.php';
require __DIR__.'/Revenue.php';
require __DIR__.'/Liability.php';
require __DIR__.'/Expenditure.php';