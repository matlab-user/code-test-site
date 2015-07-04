<?PHP

  echo sum( 1000 )."\r\n";

  function sum( $num ) {
    if( $num==1 )
      return 1;

    return $num+sum( $num-1 );
  }
?>
