<?php

  function dl_set_capability( $capability ) {
    return 'edit_pages';
  }
  add_filter( 'option_page_capability_[option-id]', 'dl_set_capability' );
