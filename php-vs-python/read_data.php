<?php
  $fname = 'nums.dat';

  $fh = fopen( $fname, "rb" );

  $data_str = '';
  $data_arr = array();

  while( 1 ) {
    $data_str = fread( $fh, 4*1024 );
    if( empty($data_str) )
      break;

      $slen = strlen( $data_str );
      $i = 0;
      while( 1 ) {
        if( ($i*4)>=$slen )
          break;
        $data_arr[] = unpack( "l", substr($data_str,$i*4,4) );
        $i++;
      }

      $data_str = '';
      var_dump( $data_arr );
  }

  fclose( $fh );
?>
