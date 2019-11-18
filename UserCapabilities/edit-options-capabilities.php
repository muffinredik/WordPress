<?php

  function wpse_310606_setting_capability( $capability ) {
    return 'edit_pages';
}
add_filter( 'option_page_capability_wpse_310606_setting_group', 'wpse_310606_setting_capability' );
