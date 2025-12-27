<?php
return [
    'user.edit' => ['controller' => 'UserController', 'action' => 'edit'],
    'user.update' => ['controller' => 'UserController', 'action' => 'update'],
    'user.index' => ['controller' => 'UserController', 'action' => 'index'],
    'tour.index' => ['controller' => 'TourController', 'action' => 'index'],
    'tour.create' => ['controller' => 'TourController', 'action' => 'create'],
    'tour.update' => ['controller' => 'TourController', 'action' => 'update'],
    'tour.delete' => ['controller' => 'TourController', 'action' => 'delete'],
    'itinerary.index' => ['controller' => 'ItineraryController', 'action' => 'index'],
    'itinerary.edit' => ['controller' => 'ItineraryController', 'action' => 'edit'],
    'itinerary.getDetails' => ['controller' => 'ItineraryController', 'action' => 'getDetails'],
    'itinerary.save' => ['controller' => 'ItineraryController', 'action' => 'save'],
    'itinerary.delete' => ['controller' => 'ItineraryController', 'action' => 'delete'],
    'BookingAdmin.index' => ['controller' => 'BookingAdminController', 'action' => 'index'],
    'admin.bookingDetail' => ['controller' => 'BookingAdminController', 'action' => 'detail'],
    'service.index' => ['controller' => 'ServiceController', 'action' => 'index'],
];
?>