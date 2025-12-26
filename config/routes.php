<?php
return [
    'ListTour.index' => ['controller' => 'ListTourController', 'action' => 'index'],
    'ListTour.details' => ['controller' => 'ListTourController', 'action' => 'details'],
    'ListTour.addToWishlist' => ['controller' => 'ListTourController', 'action' => 'addToWishlist'],
    'BookingTour.index' => ['controller' => 'BookingTourController', 'action' => 'index'],
    'BookingTour.book' => ['controller' => 'BookingTourController', 'action' => 'book'],
    'settinguser.edit' => ['controller' => 'SettingUserController', 'action' => 'edit'],
    'settinguser.update' => ['controller' => 'SettingUserController', 'action' => 'update'],
    'settinguser.changePassword' => ['controller' => 'SettingUserController', 'action' => 'changePassword'],
    'settinguser.updatePassword' => ['controller' => 'SettingUserController', 'action' => 'updatePassword'],
    'settinguser.bookingHistory' => ['controller' => 'SettingUserController', 'action' => 'bookingHistory'],
    'settinguser.updateBookingHistory' => ['controller' => 'SettingUserController', 'action' => 'updateBookingHistory'],
    'settinguser.detailBookingHistory' => ['controller' => 'SettingUserController', 'action' => 'detailBookingHistory'],
    'settinguser.favoriteTour' => ['controller' => 'SettingUserController', 'action' => 'favoriteTour'],
    'settinguser.updateFavoriteTour' => ['controller' => 'SettingUserController', 'action' => 'updateFavoriteTour'],

];
