<?PHP
  $num_arr = array();

  $fname = 'nums.dat';
  list($min_v, $max_v) = find_min_max( $fname );
  return;

/*
  $arr_num = 10000;
  for( $i=0; $i<$arr_num; $i++ )
    $num_arr[$i] = rand( -10000, 20000 );
*/
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

function read_out_arr( $fh ) {

  $data_str = '';
  $data_arr = array();

  while( 1 ) {
    $data_str = fread( $fh, 2*pow(2,20) );
    if( empty($data_str) )
      break;

      $slen = strlen( $data_str );
      $i = 0;
      while( 1 ) {
        if( ($i*4)>=$slen )
          break;
        $data_arr[] = unpack( "l", substr($data_str,$i*4,4) )[1];
        $i++;
      }
      echo count($data_arr)."\r\n";
      $data_str = '';
  }

  return $data_arr;
}

function find_min_max( $fname ) {

  $fh = fopen( $fname, "rb" );
  $res = [ 0, 0 ];

  while( 1 ) {
    $data_str = '';
    $data_str = fread( $fh, 2*pow(2,20) );
    if( empty($data_str) )
      break;

      $slen = strlen( $data_str );
      $i = 0;
      while( 1 ) {
        if( ($i*4)>=$slen )
          break;
        $mid = unpack( "l", substr($data_str,$i*4,4) );
        if( $mid[1]<$res[0] ) {
          $res[0] = $mid[1];
          $i++;
          continue;
        }

        if( $mid[1]>$res[1] )
          $res[1] = $mid[1];

        $i++;
      }
  }

  fclose( $fh );
  //var_dump( $res );
  return $res;
}
?>
