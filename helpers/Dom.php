<?php

    /*******************************************************************************************************************
     *     ╔═══╗ ╔══╗ ╔═══╗ ╔════╗ ╔═══╗ ╔══╗        ╔══╗  ╔═══╗ ╔╗╔╗ ╔═══╗ ╔╗   ╔══╗ ╔═══╗ ╔╗  ╔╗ ╔═══╗ ╔╗ ╔╗ ╔════╗
     *     ║╔══╝ ║╔╗║ ║╔═╗║ ╚═╗╔═╝ ║╔══╝ ║╔═╝        ║╔╗╚╗ ║╔══╝ ║║║║ ║╔══╝ ║║   ║╔╗║ ║╔═╗║ ║║  ║║ ║╔══╝ ║╚═╝║ ╚═╗╔═╝
     *     ║║╔═╗ ║╚╝║ ║╚═╝║   ║║   ║╚══╗ ║╚═╗        ║║╚╗║ ║╚══╗ ║║║║ ║╚══╗ ║║   ║║║║ ║╚═╝║ ║╚╗╔╝║ ║╚══╗ ║╔╗ ║   ║║
     *     ║║╚╗║ ║╔╗║ ║╔╗╔╝   ║║   ║╔══╝ ╚═╗║        ║║─║║ ║╔══╝ ║╚╝║ ║╔══╝ ║║   ║║║║ ║╔══╝ ║╔╗╔╗║ ║╔══╝ ║║╚╗║   ║║
     *     ║╚═╝║ ║║║║ ║║║║    ║║   ║╚══╗ ╔═╝║        ║╚═╝║ ║╚══╗ ╚╗╔╝ ║╚══╗ ║╚═╗ ║╚╝║ ║║    ║║╚╝║║ ║╚══╗ ║║ ║║   ║║
     *     ╚═══╝ ╚╝╚╝ ╚╝╚╝    ╚╝   ╚═══╝ ╚══╝        ╚═══╝ ╚═══╝  ╚╝  ╚═══╝ ╚══╝ ╚══╝ ╚╝    ╚╝  ╚╝ ╚═══╝ ╚╝ ╚╝   ╚╝
     *------------------------------------------------------------------------------------------------------------------
     *
     * @author     Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date       05.04.2021 21:59
     * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
     * @license    GNU General Public License version 2 or later;
     ******************************************************************************************************************/

    namespace MenuCategoriesShop\Helpers;
    defined('_JEXEC') or die; // No direct access to this file

    use DOMNode;
    use Exception;
    use JDatabaseDriver;
    use Joomla\CMS\Application\CMSApplication;
    use Joomla\CMS\Factory;
    use Joomla\Registry\Registry;

    /**
     * Class Dom
     *
     * @package MenuCategoriesShop
     * @since   3.9
     * @auhtor  Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
     * @date    05.04.2021 21:59
     *
     */
    class Dom
    {

        /**
         * @var \GNZ11\Document\Dom
         * @since 3.9
         */
        private static $dom;

        /**
         * Высота колонки
         * @var int
         * @since 3.9
         */
        public static $ColumnHeight = 500 ;

        private static $bestHits = [] ;

        private $counterLevel0 = 0 ;

        protected $Html ;

        /**
         * Array to hold the object instances
         *
         * @var Dom
         * @since  1.6
         */
        public static $instance;
        /**
         * @var array|object
         * @since 3.9
         */
        private $params;
        /**
         * @var array
         * @since 3.9
         */
        private $data_banners;
        /**
         * Html банера главной категории
         * @var mixed
         * @since 3.9
         */
        private $bannerHtml;
        /**
         * HTML - для футера
         * @var array
         * @since 3.9
         */
        private $footerHtml;

        /**
         * Dom constructor.
         *
         * @param $params array|object
         *
         * @throws Exception
         * @since 3.9
         */
        public function __construct( $params = [] )
        {
            $this->params = $params ;
            $this->prepareBanners();
            return $this;
        }

        /**
         * @param array $options
         *
         * @return Dom
         * @throws Exception
         * @since 3.9
         */
        public static function instance( $options = array() )
        {
            if( self::$instance === null )
            {
                self::$instance = new self($options);
            }
            return self::$instance;
        }

        /**
         * Подготовить параметры баннеров
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 16:52
         *
         */
        private function prepareBanners(){





            $data_banners_from = $this->params->get('data_banners_from' , false ) ;
            if( !$data_banners_from ) return ; #END IF
            $this->data_banners = [] ;
            foreach ( $data_banners_from as $item)
            {
                $this->data_banners[$item->category_id] = $item->html;
            }#END FOREACH

            # HTML для футера
            $data_footer_from = $this->params->get('data_footer_from' , false ) ;
            $this->data_footer = [] ;
            foreach ( $data_footer_from as $item)
            {
                $this->data_footer[$item->category_id][] = $item->html;
            }#END FOREACH
        }



        /**
         * Создать ссылку 0 Уровня
         * @param $name
         * @param $category_link
         *
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   05.04.2021 23:37
         *
         */
        public function addLevel0 ( $item ){
            $name =  $item->name  ;
            $category_link = $item->category_link ;



            self::$ColumnHeight = 500 ;
            self::$dom = new \GNZ11\Document\Dom();

            $hovered = 'menu-categories__item'  ;
            $hovered .= $this->counterLevel0 == 0 ? ' menu-categories__item_state_hovered' : '' ;

            $hoveredLink = 'menu-categories__link js-menu-categories__link' ;
            $hoveredLink .= $this->counterLevel0 == 0 ? ' menu-categories__link_state_hovered' : '' ;
            $this->counterLevel0 ++ ;



            $elementLi = self::$dom->createElement('li', null );
            $elementLi->setAttribute( 'class' , $hovered );

            $elementA = self::$dom->createElement('a', $name );
            $elementA->setAttribute( 'href' , $category_link );
            $elementA->setAttribute( 'class' , $hoveredLink );

            $Chevron =  '<svg aria-hidden="true" class="menu-categories__link-chevron" height="9" width="6">
                                <use href="#icon-fat-chevron"></use>
                            </svg>' ;
            // Добавить шеврон
            $this->appendHTML( $elementA , $Chevron );

            $elementLi->appendChild( $elementA );

            self::$dom->appendChild( $elementLi );
            #Сохраняем банер для категории 0 уровня для установки перед изданием листа с категориями
            $this->setBanner( $item );
            $this->setLinkAllCategory( $item );

        }

        private $ElementAllCatLink  ;

        /**
         * Установить ссылку все категории
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 18:44
         *
         */
        private function setLinkAllCategory($item){

            $divBottom = self::$dom->createElement('div', null );
            $divBottom->setAttribute( 'class' , 'menu__main-cats menu__main-cats_type_bottom' );

            $divColumn = self::$dom->createElement('div', null );
            $divColumn->setAttribute( 'class' , 'menu__hidden-column' );

            $aTitle = self::$dom->createElement('a', 'Все категории' );
            $aTitle->setAttribute( 'class' , 'menu__hidden-title' );
            $aTitle->setAttribute( 'href' , $item->category_link );

            $divColumn->appendChild($aTitle);
            $divBottom->appendChild($divColumn) ;
            $this->ElementAllCatLink = $divBottom ;




//


        }

        /**
         * Добавить категорию 1 уровня
         *
         * @param $name
         * @param $category_link
         * @param $countChild
         *
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 02:21
         */
        public function addLevel1( $item   ){
            $name =  $item->name  ;
            $category_link = $item->category_link ;

            # Если у категории есть хит - отбираем его для популярных
            if( $item->hits > 0  )
            {
                self::$bestHits[] = $item ;
            }#END IF

            /**
             * Проверяем у ссылки 0 уровня наличие листа для ссылок 1-2 уровня
             * Проверить и если нет установить .menu__hidden-content
             */
            $this->addHiddenContent();

            /**
             * Проверяем есть ли в листе созданная колонка для ссылок 1-2 уровня
             * а также если есть проверяем на заполненность ее ссылками и если колонка заполнена
             * - создаем еще одну колонку
             */
            $this->addHiddenColumn() ;


            $ul = self::$dom->createElement('ul', '');
            $ul->setAttribute( 'class' , 'menu__hidden-list' );

            $li = self::$dom->createElement('li' );

            $a = self::$dom->createElement('a' , $name );
            $a->setAttribute( 'class' , 'menu__hidden-title' );
            $a->setAttribute( 'href' , $category_link );
            $li->appendChild($a);

            # Создаем пустой список <ul /> для ссылок второго уровня
            $ulEmpty = self::$dom->createElement('ul', '');
            $li->appendChild($ulEmpty);

            $ul->appendChild($li);

            $xpathQuery = '//div[contains(@class,"menu__hidden-column")] ';
            $xpath = new \DOMXPath( self::$dom );
            # Найденные узлы
            $Nodes =  $xpath->query( $xpathQuery );
            $Nodes->item($Nodes->length - 1 )->appendChild( $ul );
            # Отнимаем от высоты колонки высоту ссылки первого уровня
            self::$ColumnHeight -= 27.5 ;




        }

        /**
         * Добавить ссылку на категорию 2 уровня
         * @param $name
         * @param $category_link
         *
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 04:30
         *
         */
        public function addLevel2( $item  ){
            $name =  $item->name  ;
            $category_link = $item->category_link ;

            # Если у категории есть хит - отбираем его для популярных
            if( $item->hits > 0  )
            {
                self::$bestHits[] = $item ;
            }#END IF

            self::$ColumnHeight -= 20 ;


            $xpathQuery = '//div[contains(@class,"menu__main-cats-inner")]/div[last()]/ul[last()]//ul';
            $xpath = new \DOMXPath( self::$dom );
            # Найденные узлы
            $Nodes =  $xpath->query( $xpathQuery );

            $elementLi = self::$dom->createElement('li');

            $elementLI_A = self::$dom->createElement('a' , $name);
            $elementLI_A->setAttribute('class' , 'menu__link');
            $elementLI_A->setAttribute('href' , $category_link );

            $elementLi->appendChild($elementLI_A) ;
            $Nodes->item(0)->appendChild($elementLi) ;
        }



        /**
         * Проверяем есть ли в листе созданная колонка для ссылок 1-2 уровня
         * а также если есть проверяем на заполненность ее ссылками и если колонка заполнена
         * - создаем еще одну колонку
         *
         * @param bool $forse принудительно добавить новую колону
         *
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 01:42
         *
         */
       protected function addHiddenColumn( $forse = false ){

           $resCheck = $this->checkElement( '//div[contains(@class,"menu__hidden-column")]');
           if( !$resCheck || self::$ColumnHeight < 28 )
           {
               $elementDiv_Hiddencolumn = self::$dom->createElement('div', '');
               $elementDiv_Hiddencolumn->setAttribute( 'class' , 'menu__hidden-column' );

               $xpathQuery = '//div[contains(@class,"menu__main-cats-inner")] ';
               $xpath = new \DOMXPath( self::$dom );
               # Найденные узлы
               $Nodes =  $xpath->query( $xpathQuery );
               $Nodes->item(0)->appendChild($elementDiv_Hiddencolumn);
               self::$ColumnHeight = 500 ;
           }#END IF
       }

        /**
         * Проверяем у ссылки 0 уровня наличие листа для ссылок 1-2 уровня
         * Проверить и если нет установить .menu__hidden-content
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 01:17
         *
         */
        protected function addHiddenContent(){
            $resCheck = $this->checkElement( '//div[contains(@class,"menu__hidden-content")]');
            if( !$resCheck )
            {
                $xpathQuery = '//li[contains(@class,"menu-categories__item")] ';
                $xpath = new \DOMXPath( self::$dom );
                # Найденные узлы
                $Nodes =  $xpath->query( $xpathQuery );

                $elementDiv_HiddenContent = self::$dom->createElement('div', '');
                $elementDiv_HiddenContent->setAttribute( 'class' , 'menu__hidden-content' );

                $elementDiv_MainCats = self::$dom->createElement('div', '');
                $elementDiv_MainCats->setAttribute( 'class' , 'menu__main-cats' );

                $elementDiv_CatsInner = self::$dom->createElement('div', '');
                $elementDiv_CatsInner->setAttribute( 'class' , 'menu__main-cats-inner' );

                $elementDiv_CatsInner = self::$dom->createElement('div', '');
                $elementDiv_CatsInner->setAttribute( 'class' , 'menu__main-cats-inner' );

                $elementDiv_MainCats->appendChild($elementDiv_CatsInner);
                $elementDiv_HiddenContent->appendChild($elementDiv_MainCats);
                $Nodes->item(0)->appendChild($elementDiv_HiddenContent);
            }#END IF
        }

        /**
         * Сохраняем банер для категории 0 уровня для установки перед изданием листа с категориями
         * @param $item
         *
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 17:24
         *
         */
        private function setBanner( $item ){

            if( !isset( $this->data_banners[ $item->category_id ] ) ) return ; #END IF
            $this->bannerHtml = $this->data_banners[ $item->category_id ] ;
            $this->footerHtml = $this->data_footer[ $item->category_id ] ;



        }

        /**
         * Добавить баннер главной категории
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 17:28
         *
         */
        private function addBanner(){

            # создать ссылку "Все категории"
            $xpath = new \DOMXPath( self::$dom );
            $Nodes =  $xpath->query( '//div[contains(@class,"menu__main-cats")]' );
            if( $Nodes->length )
            {
                $Nodes->item(0 )->appendChild( $this->ElementAllCatLink );
            }#END IF


            if( $this->bannerHtml ){
                $div = self::$dom->createElement('div');
                $div->setAttribute('class' , 'menu__hidden-column menu__hidden-column_no_padding' );
                $this->appendHTML( $div , $this->bannerHtml );

                $xpath = new \DOMXPath( self::$dom );
                $catsInner =  $xpath->query( '//div[contains(@class,"menu__main-cats-inner")]' );
                $catsInner->item(0)->appendChild( $div ) ;

                $this->bannerHtml = false ;
            } #END IF

            if( isset( $this->footerHtml ) && $this->footerHtml && count($this->footerHtml) ){

                $ul = self::$dom->createElement('ul');
                $ul->setAttribute('class' , 'menu__main-brands' );

                $this->footerHtml = array_slice( $this->footerHtml , 0 , 11 );

                foreach ( $this->footerHtml as $item)
                {
                    $li = self::$dom->createElement('li');
                    $li->setAttribute('class' , 'menu__main-brand' );
                    $this->appendHTML( $li , $item );
                    $ul->appendChild( $li );
                }#END FOREACH
                $this->footerHtml = false ;
                $xpath = new \DOMXPath( self::$dom );
                $Nodes =  $xpath->query( '//div[contains(@class,"menu__main-cats_type_bottom")]' );
                if( $Nodes->length )
                {
                    $Nodes->item(0 )->appendChild( $ul );
                }#END IF
            }



        }

        /**
         * Создать список "Популярные категории"
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 14:55
         *
         */
        private function addbestHits(){
            if( !count( self::$bestHits ) ) return ; #END IF

            $Registry = new \Joomla\Registry\Registry() ;
            $Registry->loadArray(self::$bestHits) ;
            self::$bestHits = $Registry->toArray();
            # Сортируем массив
            usort(self::$bestHits , array( 'self' , 'cmp' ));
            # Переворачиваем массив
            self::$bestHits = array_reverse( self::$bestHits ) ;
            # Обрезаем до нужной длины ( 13 )
            self::$bestHits = array_slice( self::$bestHits , 0, 26);


            $div = self::$dom->createElement('div');
            $div->setAttribute('class' , 'menu__hidden-column menu__hidden-column_color_gray' );

            $p = self::$dom->createElement('p' , 'Популярные категории');
            $p->setAttribute('class' , 'menu__hidden-title menu__hidden-title_color_gray');
            $div->appendChild($p);

            $ul = self::$dom->createElement('ul');
            $ul->setAttribute('class' , 'menu__hidden-list' );

            # Перебираем категории с хитам
            foreach ( self::$bestHits as $bestHit)
            {
                $li = self::$dom->createElement('li');
                $a = self::$dom->createElement('a' , $bestHit['name'] );
                $a->setAttribute('class' , 'menu__link menu__link_background_gray' );
                $a->setAttribute('href' , $bestHit['category_link'] );
                $li->appendChild($a);
                $ul->appendChild( $li );
            }#END FOREACH
            $div->appendChild($ul);

            $xpath = new \DOMXPath( self::$dom );

            # Найденные узлы
            $content =  $xpath->query( '//div[contains(@class,"menu__hidden-content")]' );
            $beforeElement  =  $xpath->query( '//div[contains(@class,"menu__main-cats")]' )->item(0);


            $content->item(0)->insertBefore($div , $beforeElement );



            # Очищаем
            self::$bestHits = [] ;



        }

        /**
         * Выгрузить разметку категории
         * @return false|string
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   05.04.2021 23:34
         *
         */
        public function saveDomElem(){

            #Создать список "Популярные категории"
            $this->addbestHits();

            $this->addBanner();






            return  self::$dom->saveHTML();
        }

        /**
         * Проверка наличия элемента
         * @param string $selector XPath || Css селектор
         *
         * @return int
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 01:38
         *
         */
        protected function checkElement( $selector): int
        {

            if (strpos( $selector , '/') !== false) {
                $xpathQuery = $selector ;
            }else{
                /**
                 * Конвертируем jQuery Селектор в  XPath
                 */
                $Translator = new \GNZ11\Document\Dom\Translator( $selector );
                $xpathQuery = $Translator->asXPath();
            }

            $xpath = new \DOMXPath( self::$dom );
            $Nodes =  $xpath->query( $xpathQuery );
            return $Nodes->length; #END IF
        }

        /**
         * Добавить html в объект DOMNode
         *
         * @param DOMNode $parent - объект в котором открыть
         * @param string  $source - html разметка
         *
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 02:03
         */
        protected function appendHTML( DOMNode $parent, string $source ) {
            $tmpDoc = new \GNZ11\Document\Dom();
            $tmpDoc->loadHTML($source);
            foreach ($tmpDoc->getElementsByTagName('body')->item(0)->childNodes as $node) {
                $node = $parent->ownerDocument->importNode($node, true);
                $parent->appendChild($node);
            }
        }

        /**
         * Сортируем по хитам
         * @param $a
         * @param $b
         *
         * @return mixed
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 15:10
         *
         */
        private static function cmp($a, $b) {
            return ($a['hits'] - $b['hits']);
        }

    }



























