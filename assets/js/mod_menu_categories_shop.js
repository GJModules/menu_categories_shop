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
    this.__debug = false;
    this._params = {
        __mv : null ,
    };
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
    this.isMobile = false ;
    wgnz11.load.svg( ['#icon-fat-chevron'] );
    //

    /**
     * Start Init
     * @constructor
     */
    this.Init = function () {

        var clickEvent = (function() {
            if ('ontouchstart' in document.documentElement === true)
                return 'touchstart';
            else
                return 'click';
        })();

        this._params = Joomla.getOptions( 'mod_menu_categories_shop' , this.ParamsDefaultData );
        __v = self._params.development_on ? '' : '?v=' + self._params.__v;
        // Параметры Ajax Default
        this.setAjaxDefaultData();
        // Добавить слушателей событий
        this.addEvtListener();

        // Обновить счетчик хитов для категории
        this.updateCategoryHit();

        if ( !this.__debug ){
            self.load.css( host + 'modules/mod_menu_categories_shop/assets/css/mod_menu_categories_shop.css' + this._params.__mv );

        }

        if ( self.DEVICE.isMobile() ){
             this.InitMobile();
        }


    }
    /**
     * INI для мобильных устройств
     * @constructor
     */
    this.InitMobile = function (  ){
        self.isMobile = true ;
        self.load.svg(['#icon-close-modal','#icon-chevron-down'   ] );
        self.load.css( host + 'modules/mod_menu_categories_shop/assets/css/mod_menu_categories_shop.mobile.css' + this._params.__mv , 'only screen and (max-width:480px)' );

    }
    /**
     * Обновить счетчик хитов для категории
     */
    this.updateCategoryHit = function (  ){
        if ( typeof self._params.udpHits == "undefined" ) return ;
        var Data = {
            'module' : 'menu_categories_shop' ,
            'method' : 'updateHitsCategory' ,
            'upd' : self._params.udpHits ,
        }
        self.AjaxPost(Data)
    }
    /**
     * Переустановить обработчики события клик по элементам для появления меню
     * Запуск window.menu_categories_shop.reload();
     */
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

        if ( self.isMobile ) return ;
        $('.menu__hidden-content').css({
            width : (wSizeHL - 3)  + 'px'
        })
    }

    /**
     * Показать меню
     */
    this.menuShow = function (){

        wgnz11.Optimizing.fromTemplate('#mod_menu_categories_shop-Template' , '#mod_menu_categories_shop-Data' , true ).then(function (r){
            var $body = $('body') ;
            // Установить размеры меню
            self.getMenuSize();
            $('.menu-wrapper').css({ display : 'block' });
            // Добавить оверлей
            $body.append('<div aria-hidden="true" class="page-overlay page-overlay_state_visible"></div>');


            if ( self.isMobile ){
                $('ul.menu-categories').parent().addClass('mobile');

            }else{
                $(  '.menu-categories__link' ).on('mouseover.mod_menu_categories_shop' , self.menuMouseOver );
            }


            setTimeout(function (  ){
                $body.on('click.menuHide' , self.menuHide ) ;
            },1000)
        });


    }
    /**
     * Скрыть меню
     * @param event
     */
    this.menuHide = function ( event ){
        // Стереть историю страниц
        self.historyHeader = [] ;

        var $elem = $(event.target);
        var $rootMenu = $elem.closest('.menu-wrapper') ;


        if ( !$rootMenu[0]  || $elem.hasClass('modal__close') ){
            $('.menu-wrapper').css({ display : 'none' });
            $('body').off('click.menuHide');
            // Убрать  оверлей
            $('.page-overlay').remove();
            $(  '.menu-categories__link' ).off('mouseover.mod_menu_categories_shop' );
            $('#mod_menu_categories_shop-Data').empty();
        }
    }
    /**
     * Обработка hover мыши
     */
    this.menuMouseOver = function (  ){
        var $el = $(this);
        var $block = $('.menu-categories');
        $block.find('.menu-categories__item_state_hovered').removeClass('menu-categories__item_state_hovered')
        $block.find('.menu-categories__link_state_hovered').removeClass('menu-categories__link_state_hovered')

        $el.addClass('js-menu-categories__link menu-categories__link_state_hovered')
            .parent().addClass('menu-categories__item_state_hovered')
    }
    /**
     * Перелистывание меню вперед для мобильных устройств
     * @param event
     */
    this.slideMenu = function ( event ){

        var $el = $(event.target) ;
        var $menuWrapperMobile = $el.closest('.menu-wrapper.mobile');
        var $next =  $el.next() ;
        var $children = $next.children();

        if ( $el.hasClass( 'menu__all-product' ) ) return ;
        console.log('mod_menu_categories_shop:slideMenu->$el >>> ' , $el );

        
        /**
         * Если находимся в мобильно меню категорий
         * И следующий элемент(li) есть и он не пустой
         * и это не заголовок 1 уровня 
         */
        if ( $menuWrapperMobile[0] && ( typeof $el.next()[0] !== "undefined" && $children[0] ) && !$el.hasClass('menu__hidden-title') ){
            event.preventDefault();
            var $elem = $(event.target);
            $elem.next().addClass('active' ) ;
            self.setHead();
            return false ;
        }
        return true ;
    }
    /**
     * Обратное Перелистывание меню
     * @param event
     */
    this.backSlideMenu = function ( event ){
        var historyText = self.historyHeader[ self.historyHeader.length - 1 ];
        // удалить последнюю запись в истории
        self.historyHeader.splice(-1,1)


        var $header = $('.modal__header').removeClass('header--active')
            .find('.modal__heading').text(historyText);

        $('ul.menu-categories').find('.active').removeClass('active')
    }
    /**
     * История страниц мобильного меню
     * @type {*[]}
     */
    this.historyHeader = [];
    /**
     * Установка заголовка в мобильном меню
     */
    this.setHead = function (){
        var $active = $('.menu-categories').find('.active') ;
        var $header = $('.modal__header').addClass('header--active');
        var _$preA = $active.prev()
        var text = _$preA.text() ;
        var href = _$preA.attr('href') ;

        var $heading = $header.find('.modal__heading');

        console.log('mod_menu_categories_shop:setHead->$active >>> ' , $active );
        console.log('mod_menu_categories_shop:setHead->text >>> ' , text );
        console.log('mod_menu_categories_shop:setHead->text >>> ' , href );
        console.log('mod_menu_categories_shop:setHead->$header >>> ' , $header );
        console.log('mod_menu_categories_shop:setHead->$active >>> ' , $active );

        $('.menu__all-product').attr('href' , href ) ;
        
        self.historyHeader.push( $heading.text() )
        $heading.text( text );
    }

    /**
     * Добавить слушателей событий
     */
    this.addEvtListener = function () {
        var $body = $('body') ;
        $(  self._params.selector_key ).on('click' , self.menuShow );
        $body.on('click.menuHide' , '.menu-wrapper_state_animated.mobile .modal__close' ,  self.menuHide );


        document.addEventListener('click' , self.slideMenu ) ;




        // $body.on('click.menuHide' , '.menu-wrapper_state_animated.mobile ul.menu-categories > li > a' ,  self.slideMenu );
        $body.on('click.menuHide' , '.menu__back.button' ,  self.backSlideMenu );
        $body.on('click.menuHide' , '.page-overlay-protect' ,  function ( evt ){
            evt.preventDefault();
            return false ;
        });



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


        this.__debug = this._params.__debug || false ;
    }
    this.Init();
};

window.mod_menu_categories_shop.prototype = new GNZ11();
window.menu_categories_shop = new window.mod_menu_categories_shop();
