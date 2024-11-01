<?php

function countries() {
    $countries = [];
    $available_countries = sprinque_get_available_countries();
    array_walk($available_countries, function ($country) use (&$countries) {
        $countries[$country['code']] = $country['name'];
    });

	return $countries;
}