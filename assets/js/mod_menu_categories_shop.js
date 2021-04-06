/*******************************************************************************************************************
 *     ╔═══╗ ╔══╗ ╔═══╗ ╔════╗ ╔═══╗ ╔══╗        ╔══╗  ╔═══╗ ╔╗╔╗ ╔═══╗ ╔╗   ╔══╗ ╔═══╗ ╔╗  ╔╗ ╔═══╗ ╔╗ ╔╗ ╔════╗
 *     ║╔══╝ ║╔╗║ ║╔═╗║ ╚═╗╔═╝ ║╔══╝ ║╔═╝        ║╔╗╚╗ ║╔══╝ ║║║║ ║╔══╝ ║║   ║╔╗║ ║╔═╗║ ║║  ║║ ║╔══╝ ║╚═╝║ ╚═╗╔═╝
 *     ║║╔═╗ ║╚╝║ ║╚═╝║   ║║   ║╚══╗ ║╚═╗        ║║╚╗║ ║╚══╗ ║║║║ ║╚══╗ ║║   ║║║║ ║╚═╝║ ║╚╗╔╝║ ║╚══╗ ║╔╗ ║   ║║
 *     ║║╚╗║ ║╔╗║ ║╔╗╔╝   ║║   ║╔══╝ ╚═╗║        ║║─║║ ║╔══╝ ║╚╝║ ║╔══╝ ║║   ║║║║ ║╔══╝ ║╔╗╔╗║ ║╔══╝ ║║╚╗║   ║║
 *     ║╚═╝║ ║║║║ ║║║║    ║║   ║╚══╗ ╔═╝║        ║╚═╝║ ║╚══╗ ╚╗╔╝ ║╚══╗ ║╚═╗ ║╚╝║ ║║    ║║╚╝║║ ║╚══╗ ║║ ║║   ║║
 *     ╚═══╝ ╚╝╚╝ ╚╝╚╝    ╚╝   ╚═══╝ ╚══╝        ╚═══╝ ╚═══╝  ╚╝  ╚═══╝ ╚══╝ ╚══╝ ╚╝    ╚╝  ╚╝ ╚═══╝ ╚╝ ╚╝   ╚╝
 *------------------------------------------------------------------------------------------------------------------
 * @author Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
 * @date 04.04.2021 22:21
 * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 ******************************************************************************************************************/
/* global jQuery , Joomla   */
window.mod_menu_categories_shop = function () {
    var $ = jQuery;
    var self = this;
    // Домен сайта
    var host = Joomla.getOptions( 'GNZ11' ).Ajax.siteUrl;
    // Медиа версия
    var __v = '';

    this.__type = false;
    this.__plugin = false;
    this.__name = false;
    this._params = {};
    // Параметры Ajax по умолчвнию
    this.AjaxDefaultData = {
        group  : null ,
        plugin : null ,
        module : null ,
        method : null ,
        option : 'com_ajax' ,
        format : 'json' ,
        task   : null ,
    };
    // Default object parameters
    this.ParamsDefaultData = {
        // Медиа версия
        __v : '1.0.0' ,
        // Режим разработки 
        development_on : false ,
    }

    this.menuStatus = false ;
    wgnz11.load.svg( ['#icon-fat-chevron'] );
    //

    /**
     * Start Init
     * @constructor
     */
    this.Init = function () {
        this._params = Joomla.getOptions( 'mod_menu_categories_shop' , this.ParamsDefaultData );
        __v = self._params.development_on ? '' : '?v=' + self._params.__v;
        // Параметры Ajax Default
        this.setAjaxDefaultData();
        // Добавить слушателей событий
        this.addEvtListener();

        console.log( this._params )
        console.log( this.AjaxDefaultData );
    }
    this.reload = function (  ){
        // Добавить слушателей событий
        this.addEvtListener();
    }
    /**
     * Установить размеры меню
     */
    this.getMenuSize = function (){
        // Шрина экрана
        var wSizeW = window.screen.width  ;
        var wSizeHL = document.querySelector(".header-layout").offsetWidth  ;
        var delta  = wSizeW - wSizeHL ;

        $('.menu__hidden-content').css({
           width : (wSizeHL - 3)  + 'px'
        })
    }

    /**
     * Показать меню
     */
    this.menuShow = function (){
        // Установить размеры меню
        self.getMenuSize();
        $('.menu-wrapper').css({ display : 'block' });
        // Добавить оверлей
        $('body').append('<div aria-hidden="true" class="page-overlay page-overlay_state_visible"></div>')
        setTimeout(function (  ){
            $('body').on('click.menuHide' , self.menuHide ) ;
        },1000)
    }
    /**
     * Скрыть меню
     * @param event
     */
    this.menuHide = function ( event ){
        var $elem = $(event.target);
        var $rootMenu = $elem.closest('.menu-wrapper') ;
        if ( !$rootMenu[0] ){
            $('.menu-wrapper').css({ display : 'none' });
            $('body').off('click.menuHide');
            // Убрать  оверлей
            $('.page-overlay').remove();
        }
    }

    this.menuMouseOver = function (  ){
        var $el = $(this);
        var $block = $('.menu-categories');
        $block.find('.menu-categories__item_state_hovered').removeClass('menu-categories__item_state_hovered')
        $block.find('.menu-categories__link_state_hovered').removeClass('menu-categories__link_state_hovered')

        $el.addClass('js-menu-categories__link menu-categories__link_state_hovered')
            .parent().addClass('menu-categories__item_state_hovered')
    }


    /**
     * Добавить слушателей событий
     */
    this.addEvtListener = function () {
        $(  self._params.selector_key ).on('click' , self.menuShow );
        $(  '.menu-categories__link' ).on('mouseover' , self.menuMouseOver );
    };





    /**
     * Отправить запрос
     * @param Data - отправляемые данные
     * Должен содержать Data.task = 'taskName';
     * @returns {Promise}
     * @constructor
     */
    this.AjaxPost = function ( Data ) {
        var data = $.extend( true , this.AjaxDefaultData , Data );
        return new Promise( function ( resolve , reject ) {
            self.getModul( "Ajax" ).then( function ( Ajax ) {
                // Не обрабатывать сообщения
                Ajax.ReturnRespond = true;
                // Отправить запрос
                Ajax.send( data , self._params.__name ).then( function ( r ) {
                    resolve( r );
                } , function ( err ) {
                    console.error( err );
                    reject( err );
                } )
            } );
        } );
    };
    /**
     * Параметры Ajax Default
     */
    this.setAjaxDefaultData = function () {
        this.AjaxDefaultData.group = this._params.__type;
        this.AjaxDefaultData.plugin = this._params.__name;
        this.AjaxDefaultData.module = this._params.__module;
        this._params.__name = this._params.__name || this._params.__module;
    }
    this.Init();
};
document.addEventListener('GNZ11Loaded', function() {
    window.mod_menu_categories_shop.prototype = new GNZ11();
    window.menu_categories_shop = new window.mod_menu_categories_shop();
})

