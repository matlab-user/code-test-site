<?php
  $fname = 'nums.dat';

  $max = getrandmax();

  $fh = fopen( $fname, "wb+" );

  $arr_num = 0.25*pow(2,30);
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
