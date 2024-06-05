<?php

function getHW() {
    return 'Hello World!';
}

function getStore() {
    return \App\Models\StoreSettings::where('uuid', config('constants.store_uuid'))->firstOrFail();
}

function getTheme() {
    $file = file_get_contents(resource_path('/settings/default.json'));
    return json_decode($file, true);
}

function rgbToHsl( $rgb ) {
    $r = $rgb[0];
    $g = $rgb[1];
    $b = $rgb[2];
    $oldR = $r;
    $oldG = $g;
    $oldB = $b;

    $r /= 255;
    $g /= 255;
    $b /= 255;

    $max = max( $r, $g, $b );
    $min = min( $r, $g, $b );

    $h = null;
    $s = null;
    $l = ( $max + $min ) / 2;
    $d = $max - $min;

    if( $d == 0 ){
        $h = $s = 0; // achromatic
    } else {
        $s = $d / ( 1 - abs( 2 * $l - 1 ) );

        switch( $max ){
            case $r:
                $h = 60 * fmod( ( ( $g - $b ) / $d ), 6 );
                if ($b > $g) {
                    $h += 360;
                }
                break;

            case $g:
                $h = 60 * ( ( $b - $r ) / $d + 2 );
                break;

            case $b:
                $h = 60 * ( ( $r - $g ) / $d + 4 );
                break;
        }
    }

    return array( round( $h ), round( $s * 100) , round( $l * 100) );
}

//function hslToRgb( $h, $s, $l ){
function hslToRgb( $hsl ){
    $h = floatval($hsl['h']);
    $s = floatval($hsl['s']) / 100;
    $l = floatval($hsl['l']) / 100;
    $r = null;
    $g = null;
    $b = null;

    $c = ( 1 - abs( 2 * $l - 1 ) ) * $s;
    $x = $c * ( 1 - abs( fmod( ( $h / 60 ), 2 ) - 1 ) );
    $m = $l - ( $c / 2 );

    if ( $h < 60 ) {
        $r = $c;
        $g = $x;
        $b = 0;
    } else if ( $h < 120 ) {
        $r = $x;
        $g = $c;
        $b = 0;
    } else if ( $h < 180 ) {
        $r = 0;
        $g = $c;
        $b = $x;
    } else if ( $h < 240 ) {
        $r = 0;
        $g = $x;
        $b = $c;
    } else if ( $h < 300 ) {
        $r = $x;
        $g = 0;
        $b = $c;
    } else {
        $r = $c;
        $g = 0;
        $b = $x;
    }

    $r = ( $r + $m ) * 255;
    $g = ( $g + $m ) * 255;
    $b = ( $b + $m  ) * 255;

    return array( intval( $r ), intval( $g ), intval( $b ) );
}

function hslToHslStr( $hsl ):string {
    return $hsl['h'].' '.$hsl['s'].'% '.$hsl['l'].'%';
}

function hslToRgbStr( $hsl ):string {
//    dd($hsl);
    if (gettype($hsl) == 'string') {
        $hsl = explode(' ', $hsl);
        $hsl = array('h' => $hsl[0], 's' => $hsl[1], 'l' => $hsl[2]);
    }
    $array = hslToRgb($hsl);
    return $array[0].' '.$array[1].' '.$array[2];
}
