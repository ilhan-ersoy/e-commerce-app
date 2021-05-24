<?php

function presentPrice($price){
    return ('$'.number_format( $price / 10, 2));
}


