<?php
  $fname = 'nums.dat';

  $max = getrandmax();

  $fh = fopen( $fname, "wb+" );

  $arr_num = 1.2*pow(2,20);
  $data_str = '';
  for( $i=0; $i<$arr_num; $i++ ) {
    $d = rand(-$max,$max);
    $data_str .= pack( "l", $d );

    if( $i%pow(2,20)==0 ) {
      fwrite( $fh, $data_str );
      $data_str = '';
    }
  }
  fwrite( $fh, $data_str );

  fclose( $fh );
?>
