<?php

function mainsite_section_menu_display( $selector, $content='' ) {
    $content = trim( $content );
    $list_items = $content ? trim( Section_Menus_Common::get_custom_menu_items( $content ) ) : '';
    $auto_select = $list_items ? 'false' : 'true';

    ob_start();
?>
    <nav class="sections-menu-wrapper" aria-label="Page section navigation" style="min-height: 60px;">
        <div class="navbar navbar-toggleable-md navbar-light bg-primary sections-menu">
            <div class="container">
                <button class="navbar-toggler collapsed ml-auto" type="button" data-toggle="collapse" data-target="#sections-menu" aria-controls="#sections-menu" aria-expanded="false">
                    <span class="navbar-toggler-text">Skip to Section</span>
                    <span class="navbar-toggler-icon" aria-hidden="true"></span>
                </button>
                <div class="navbar-collapse collapse" id="sections-menu" data-autoselect="<?php echo $auto_select; ?>" data-selector="<?php echo $selector; ?>">
                    <ul class="nav navbar-nav w-100 justify-content-between">
                        <?php if ( $list_items ) { echo $list_items; } ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
<?php
    return ob_get_clean();
}

add_filter( 'section_menus_display_justify-between', 'mainsite_section_menu_display', 10, 2 );
