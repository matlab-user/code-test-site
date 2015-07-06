<?PHP
  $num_arr = array();
  $fname = 'nums.dat';

  echo "start sorting!\r\n";
  $stime = microtime_float();

  echo "STEP 1: find_min_max--------\r\n";
  list($min_v, $max_v) = find_min_max( $fname );
  $rd = range( $min_v, $max_v-1, 1024 );
  $rd[] = $max_v;
  $len = count( $rd );

  foreach( $rd as $k => $v ) {
    if( $k>=($len-1) )
      break;

    echo "STEP 2: get_range--------\r\n";
    $num_arr = get_range( $v, $rd[$k+1], $fname );

    echo "STEP 3: fast_sort--------\r\n";
    fsort( 0, count($num_arr)-1 );
    show_arr( $num_arr );
  }

  $etime = microtime_float();

  $check_stime = microtime_float();
  $res = sort_check( $num_arr );
  $check_etime = microtime_float();

  if( $res==true ) {
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

    echo "\r\n\r\n";
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

function get_range( $min_v, $max_v, $fname ) {

  $fh = fopen( $fname, "rb" );
  $res = [];

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
        if( $mid[1]>=$min_v && $mid[1]<$max_v )
          $res[] = $mid[1];

        $i++;
      }
  }

  fclose( $fh );
  return $res;
}

?>
