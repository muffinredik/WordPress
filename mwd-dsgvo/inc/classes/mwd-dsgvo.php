<?php



class MWD_DSGVO {

    private $sections;
    private $versions;
    private $useOldData = false;

    public function __construct() {
	    $this->sections = mwd_dsgvo_get_custom_table_entries( 'mwd_dsgvo_sections' );
	    $this->versions = mwd_dsgvo_get_custom_table_entries( 'mwd_dsgvo_versions' );

        add_action( 'admin_menu', array( $this, 'create_plugin_settings_page' ) );
        add_action( 'admin_init', array( $this, 'setup_sections' ) );
        add_action( 'admin_init', array( $this, 'setup_fields' ) );
    }
    
    public function create_plugin_settings_page() {
	    if( isset( $_POST['mwd_dsgvo_version_confirmation'] ) ) {
	        $this->useOldData = true;
		    unset( $_POST['mwd_dsgvo_version_confirmation'] );
	    }
	    if ( !$this->useOldData ) {
		    $this->sections = mwd_dsgvo_get_custom_table_entries( 'mwd_dsgvo_sections' );
        }
        else {
	        $this->sections = mwd_dsgvo_get_custom_table_entries( 'mwd_dsgvo_temp_sections' );
        }
	    if ( !$this->useOldData ) $this->versions = mwd_dsgvo_get_custom_table_entries( 'mwd_dsgvo_versions' );

        $page_title = __('Settings', 'mwd-dsgvo');
        $menu_title = __('Datenschutzrichtlinien', 'mwd-dsgvo');
        $capability = 'manage_options';
        $slug = 'mwd-dsgvo';
        $callback = array( $this, 'plugin_settings_page_content' );
        $icon = 'dashicons-editor-ol';
        $position = 100;

        add_options_page( $page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
    }
    
    public function plugin_settings_page_content() { ?>
        <div class="wrap">
            <?php
            if ( $this->useOldData ) {
	            echo '<div class="notice notice-warning is-dismissible"><p>';
                _e( 'Version vom ', 'mwd-dsgvo' );
	            if ( isset( $_POST['mwd-dsgvo-version-date'] ) ) echo $_POST['mwd-dsgvo-version-date'];
	            echo '</p></div>';
            }
            ?>
            <h2><?php echo(__('Datenschutzrichtlinien Einstellungen', 'mwd-dsgvo')) ?></h2>
            <form method="post" id="mwd-dsgvo-form">
                <input type='hidden' name='option_page' value='mwd-dsgvo' />
                <?php
                    if ( !$this->useOldData ) wp_nonce_field( 'mwd_dsgvo_settings_page', '_wp_nonce' );
                    do_settings_sections( 'mwd-dsgvo' );
                    if ( !$this->useOldData ) submit_button(__('speichern', 'mwd-dsgvo'), 'primary', 'mwd_dsgvo_save_settings');
                ?>
            </form>
        </div><?php
    }
    
    public function setup_sections() {
        add_settings_section( 'mwd_dsgvo_general_settings_section', __('</h2><div class="mwd-dsgvo-general-settings-section"><h2>Allgemeine Einstellungen', 'mwd-dsgvo'), array( $this, 'section_callback' ), 'mwd-dsgvo' );
        foreach ($this->sections as $section) {
	        add_settings_section( 'mwd_dsgvo_sections_' . $section['slug'] . '_section', '</div></h2><hr/><div class="mwd-dsgvo-single-section"><h2>' . $section['title'], array( $this, 'section_callback' ), 'mwd-dsgvo' );
        }
	    if ( !$this->useOldData ) {
		    add_settings_section( 'mwd_dsgvo_history_section', __('</div></h2></hr><h2>Alte Versionen ansehen', 'mwd-dsgvo'), array( $this, 'section_callback' ), 'mwd-dsgvo' );
	    }
	    else {
            if ( isset( $_POST['mwd-dsgvo-version-date'] ) ) {
                $date = $_POST['mwd-dsgvo-version-date'];
            }
            else {
	            $date = '';
            }
		    add_settings_section( 'mwd_dsgvo_history_section', __('</div></h2></hr><h2>Diese Version wurde am ' . $date . ' erstellt.', 'mwd-dsgvo'), array( $this, 'section_callback' ), 'mwd-dsgvo' );
	    }
    }
    
    public function section_callback( $arguments ) {
        switch( $arguments['id'] ){
            case 'mwd_dsgvo_general_settings_section':
                _e('Shortcode für die DSGVO Seite: [mwd-dsgvo]<br />' , 'mwd-dsgvo');
                _e('Ein Visual Composer Shortcode ist ebenfalls verfügbar.' , 'mwd-dsgvo');
                break;
            case 'mwd_dsgvo_history_section':
	            if ( $this->useOldData ) break;
                echo '<div id="mwd-dsgvo-versions">';
                if ( count( $this->versions ) == 0 ) {
                    _e( 'Es wurden noch keine Versionen erstellt', 'mwd-dsgvo' );
	                echo '</div>';
                    break;
                }
                foreach ( $this->versions as $version ) {
                    echo '<input type="radio" name="mwd_dsgvo_version_id" value="' . $version['id'] . '"> ' . $version['username'] . '&nbsp;&nbsp;' . $version['created'] . '<br />';
                }
                echo '</div>';
	            echo '<input type="checkbox" name="mwd_dsgvo_version_confirmation" id="mwd_dsgvo_version_confirmation"> ' . __( 'Ja, ich will die ausgewählte Version ansehen', 'mwd-dsgvo' );
                break;
        }
    }
    
    public function setup_fields() {

        $fields = array(
            array(
                    'id' => 'mwd_dsgvo_general_settings_company_name',
                    'label' => __('Firmenname<br />[mwd-firmenname]', 'mwd-dsgvo'),
                    'sectionId' => 'mwd_dsgvo_general_settings_section',
                    'htmlId' => 'mwd-dsgvo-general-settings-company-name',
                    'class' => '',
                    'inputType' => 'text',
                    'customTable' => null,
                    'customValue' => null
            ),
            array(
                    'id' => 'mwd_dsgvo_general_settings_company_adress',
                    'label' => __('Anschrift<br />[mwd-anschrift]', 'mwd-dsgvo'),
                    'sectionId' => 'mwd_dsgvo_general_settings_section',
                    'htmlId' => 'mwd-dsgvo-general-settings-company-adress',
                    'class' => '',
                    'inputType' => 'text',
                    'customTable' => null,
                    'customValue' => null
            ),
        );

	    $fields = array_merge ( $fields, get_section_fields( $this->sections ) );

        foreach ($fields as $field) {
	        add_settings_field(
	                $field['id'],
                    $field['label'],
                    array( $this, 'field_callback'),
                    'mwd-dsgvo',
                    $field['sectionId'],
                    array(
                        'id'            => $field['id'],
                        'htmlId'        => $field['htmlId'],
                        'class'         => $field['class'],
                        'inputType'     => $field['inputType'],
                        'customTable'   => $field['customTable'],
                        'customValue'   => $field['customValue']
                    )
            );
	        register_setting( 'mwd-dsgvo', $field['id'], array( 'sanitize_callback' => array( $this, 'sanitize_setting' ) ) );
        }
    }
    
    public function field_callback( $args ) {

        if($args['customTable'] == null) {
	        if ( !$this->useOldData ) {
                $fieldValue = get_option( $args['id'] );
	        }
	        else {
		        $fieldValue = mwd_dsgvo_get_temp_general_setting( $args['id'] );
            }
	        $class = $args['class'];
        }
        else {
            $fieldValue = $args['customValue'];
	        $class = 'mwd-dsgvo-custom-table-field ' . $args['class'];
        }

	    switch( $args['inputType'] ) {

            case 'checkbox':
	            echo '<input name="' . $args['id'] . '" id="' . $args['htmlId'] . '" class="' . $class . '" type="hidden" value="'. $fieldValue . '"/>';
                if ( $fieldValue == '1' ) {
                    $fieldValue = 'checked';
                }
                else {
	                $fieldValue = '';
                }
	            echo '<input class="mwd-dsgvo-section-checkbox" type="' . $args['inputType'] . '" value="'. $fieldValue . '" ' . $fieldValue . '/>';
	            break;

            case 'wysiwyg':
	            wp_editor( $fieldValue, $args['id'], $settings = array( 'textarea_rows'=> '10' ) );
                break;

            case 'defaulttext-button':
	            echo '<input class="mwd-dsgvo-reset-text button button-secondary" type="button" value="'. __('anzeigen', 'mwd-dsgvo') . '" />';
	            echo '<input class="mwd-dsgvo-copy-default-text button button-secondary hidden" type="button" value="'. __('kopieren', 'mwd-dsgvo') . '" />';
	            echo '<p id="' . $args['htmlId'] . '" class="' . $class . ' hidden">'. $fieldValue . '</p>';
	            break;

            default:
	            echo '<input name="' . $args['id'] . '" id="' . $args['htmlId'] . '" ' . $class . ' type="' . $args['inputType'] . '" value="'. $fieldValue . '" size="35" />';
	            break;
        }
    }

    public function sanitize_setting ( $value ) {
        $type = gettype( $value );
        switch ( $type ) {
            case "string":
                sanitize_text_field( $value );
                break;
        }
        return $value;
    }
}

?>