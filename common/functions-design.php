<?
function color(){
	$color[0] = "00";
	$color[1] = "33";
	$color[2] = "66";
	$color[3] = "99";
	$color[4] = "cc";
	$color[5] = "ff";
	$a = rand(2,5);
	$b = rand(1,5);
	$c = rand(1,5);
	$color = $color[$a].$color[$b].$color[$c];
	return $color;
}
function row_color($i){
    $bg1 = "#FFFFFF"; // color one   
    $bg2 = "#cc99ff"; // color two
    if ( $i%2 ) {
        return $bg1;
    } else {
        return $bg2;
    }
}
function row_color_red($i){
    $bg1 = "#FF0000"; // color one   
    $bg2 = "#FF6600"; // color two
    if ( $i%2 ) {
        return $bg1;
    } else {
        return $bg2;
    }
}
function row_color_light($i){
    $bg1 = "#FFFFCC"; // color one lightest yellow
    $bg2 = "#CCFFFF"; // color two lightest blue
    if ( $i%2 ) {
        return $bg1;
    } else {
        return $bg2;
    }
}
function row_color_light2($i){
    $bg1 = "#99FF66"; // color one lightest green
    $bg2 = "#FFCCFF"; // color two lightest red
    if ( $i%2 ) {
        return $bg1;
    } else {
        return $bg2;
    }
}
function row_color_new($i){
    $bg1 = "#8CE88C"; // color one   
    $bg2 = "#008900"; // color two
    if ( $i%2 ) {
        return $bg1;
    } else {
        return $bg2;
    }
}
function row_color_blue($i){
    $bg1 = "#CCFFFF"; // color one   
    $bg2 = "#99FFFF"; // color two
    if ( $i%2 ) {
        return $bg1;
    } else {
        return $bg2;
    }
}
?>