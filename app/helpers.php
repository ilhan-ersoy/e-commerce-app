<?php

function presentPrice($price){
    return ('$'.number_format( $price / 10, 2));
}

function setActiveCategory($category,$output = 'active') {
    return request()->category === $category ? $output : '';
}





