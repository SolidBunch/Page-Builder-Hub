
(function($){

    "use strict";

    $(document).ready(function() {

        console.log(wp);




    });


})( window.jQuery );


wp.domReady( function() {

    wp.blocks.registerBlockStyle( 'core/quote', {
        name: 'my-quote',
        label: 'My Quote',
        isDefault: true
    } );
    //wp.blocks.unregisterBlockStyle( 'core/quote', 'default' );
    wp.blocks.unregisterBlockStyle( 'core/quote', 'large' );


    /* ?????????????????????
    wp.hooks.addFilter(
        'blocks.registerBlockType',
        'core/quote',
        addListBlockClassName
    );
    function addListBlockClassName( settings, name ) {
        console.log(settings);
        console.log(name);


        if ( name !== 'core/quote' ) {
            return settings;
        }

        return lodash.assign( {}, settings, {
            supports: lodash.assign( {}, settings.supports, {
                className: true
            } ),
        } );
    }
    */



    /*
    // Modify element when saving
    wp.hooks.addFilter(
        'blocks.getSaveElement',
        'core/quote',
        function(element, blockType, attributes) {
            console.log(element);
            console.log(blockType);
            console.log(attributes);

            return element;
        }
    );

    // Add extra props when saving
    wp.hooks.addFilter(
        'blocks.getSaveContent.extraProps__',
        'core/quote',
        function( props ) {
            return lodash.assign( props, { style: { backgroundColor: 'red' } } );
        }
    );

    // Add extra class name
    wp.hooks.addFilter(
        'blocks.getBlockDefaultClassName',
        'core/quote',
        function( className, blockName ) {
            return blockName === 'core/quote' ?
                'quote-extra-class' :
                className;
        }
    );

    // Add extra class name
    wp.hooks.addFilter(
        'blocks.getBlockAttributes',
        'core/quote',
        function( ...args ) {
            console.log(args);
        }
    );
    */

    /****** Filters *******/
    /*
    editor.BlockEdit
    blocks.switchToBlockType.transformedBlock
    blocks.getBlockAttributes
    editor.BlockListBlock


     */

    //wp.blocks.unregisterBlockType( 'core/quote' );
    //wp.blocks.unregisterBlockType( 'core/audio' );

    // Get block types
    console.log(wp.blocks.getBlockTypes());


});



