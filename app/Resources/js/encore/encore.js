/**
 * borderMenu.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */


    function init() {

    var eventtype = 'click';
        var menu = document.getElementById( 'bt-menu' ),
            trigger = menu.querySelector( 'a.bt-menu-trigger' ),
        // triggerPlay only for demo 6
            triggerPlay = document.querySelector( 'a.bt-menu-trigger-out' ),
        // event type (if mobile use touch events)
            resetMenu = function() {
                classie.remove( menu, 'bt-menu-open' );
                classie.add( menu, 'bt-menu-close' );
            },
            closeClickFn = function( ev ) {
                resetMenu();
                overlay.removeEventListener( eventtype, closeClickFn );
            };

        var overlay = document.createElement('div');
        overlay.className = 'bt-overlay';
        menu.appendChild( overlay );

        trigger.addEventListener( eventtype, function( ev ) {
            ev.stopPropagation();
            ev.preventDefault();

            if( classie.has( menu, 'bt-menu-open' ) ) {
                resetMenu();
            }
            else {
                classie.remove( menu, 'bt-menu-close' );
                classie.add( menu, 'bt-menu-open' );
                overlay.addEventListener( eventtype, closeClickFn );
            }
        });

        if( triggerPlay ) {
            triggerPlay.addEventListener( eventtype, function( ev ) {
                ev.stopPropagation();
                ev.preventDefault();

                classie.remove( menu, 'bt-menu-close' );
                classie.add( menu, 'bt-menu-open' );
                overlay.addEventListener( eventtype, closeClickFn );
            });
        }

    }
