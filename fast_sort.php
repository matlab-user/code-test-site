<?PHP
  $num_arr = array();

  $arr_num = 10000;
  for( $i=0; $i<$arr_num; $i++ )
    $num_arr[$i] = rand( -10000, 20000 );

  echo "start sorting!\r\n";
  $stime = microtime_float();
  fsort( 0, $arr_num-1 );
  $etime = microtime_float();

  $check_stime = microtime_float();
  $res = sort_check( $num_arr );
  $check_etime = microtime_float();

  if( $res==true ) {
    show_arr( $num_arr );
    echo "\r\nUse ".($etime-$stime)."s to sort\r\n";
    echo "\r\nUse ".($check_etime-$check_stime)."s to check\r\n";
  }
  else
    echo "Sort failed!\r\n";

//==============================================================================
  function fsort( $sid, $eid ) {

    global $num_arr;

    if( $sid==$eid || $eid<$sid )
      return;

     $res_arr = classify( $sid, $eid );
     if( count($res_arr)<=0 )
      return;

     list( $l_sid, $l_eid, $r_sid, $r_eid ) = $res_arr;

     fsort( $l_sid, $l_eid );
     fsort( $r_sid, $r_eid );
  }

  function classify( $sid, $eid ) {

    global $num_arr;

    if( $sid==$eid || $sid>$eid )
      return [];

    $base = $num_arr[$eid];
    //echo "base: $base\r\n";
    $left_a = array();
    $right_a = array();
    for( $i=$sid; $i<$eid; $i++ ) {
        if( $num_arr[$i]<=$base )
          $left_a[] = $num_arr[$i];
        else
          $right_a[] = $num_arr[$i];
    }

    $mid_a = array_merge( $left_a, [$base], $right_a );
    array_splice( $num_arr, $sid, $eid-$sid+1, $mid_a );

    $l_sid = $sid;
    $l_eid = $l_sid + count($left_a) - 1;
    $r_sid = $l_eid + 2;
    $r_eid = $r_sid + count($right_a) - 1;

    return [ $l_sid, $l_eid, $r_sid, $r_eid ];
  }

  function show_arr( $arr ) {
    $i = 0;
    echo "The elements in array is:\r\n";
    foreach( $arr as $v ) {
      echo "$v ";
      $i++;
      if( $i==10 ) {
        echo "\r\n";
        $i = 0;
      }
    }
  }

  function sort_check( $arr ) {

    $eid = count( $arr ) - 1;
    $i = 0;

    foreach( $arr as $v1 ) {
      if( $i>=$eid )
        break;

      $c_arr = array_slice( $arr, $i+1 );

      foreach( $c_arr as $v2 ) {
        if( $v1>$v2 )
          return false;
      }
      $i++;
    }

    return true;
  }

  function microtime_float() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
  }

?>
