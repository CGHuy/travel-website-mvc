<?php
return [
    'user.edit' => ['controller' => 'UserController', 'action' => 'edit'],
    'user.update' => ['controller' => 'UserController', 'action' => 'update'],
    'admin.tour' => ['controller' => 'AdminController', 'action' => 'tour'],
    'admin.itinerary' => ['controller' => 'AdminController', 'action' => 'itinerary'],
    'admin.booking' => ['controller' => 'AdminController', 'action' => 'booking'],
    'admin.user' => ['controller' => 'AdminController', 'action' => 'user'],
    'admin.service' => ['controller' => 'AdminController', 'action' => 'service'],
    'tour.store' => ['controller' => 'TourController', 'action' => 'storeTour'],
    'tour.update' => ['controller' => 'TourController', 'action' => 'updateTour'],
    'tour.delete' => ['controller' => 'TourController', 'action' => 'deleteTour'],
    'tour.get' => ['controller' => 'TourController', 'action' => 'getTour'],
    'itinerary.store' => ['controller' => 'ItineraryController', 'action' => 'storeItinerary'],
    'itinerary.update' => ['controller' => 'ItineraryController', 'action' => 'updateItinerary'],
    'itinerary.delete' => ['controller' => 'ItineraryController', 'action' => 'deleteItinerary'],
    'itinerary.get' => ['controller' => 'ItineraryController', 'action' => 'getItinerary'],
];
?>
