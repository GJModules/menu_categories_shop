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
         * Dom constructor.
         *
         * @param $params array|object
         *
         * @throws Exception
         * @since 3.9
         */
        public function __construct( $params = [] )
        {

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
         * Создать ссылку 0 Уровня
         * @param $name
         * @param $category_link
         *
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   05.04.2021 23:37
         *
         */
        public function addLevel0 ( $name , $category_link ){
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
//            $this->Html = self::$dom->saveHTML();

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
        public function addLevel2( $name , $category_link ){


            self::$ColumnHeight -= 20 ;


            $xpathQuery = '//div[contains(@class,"menu__main-cats-inner")]/div[last()]/ul[last()]//ul';
            $xpath = new \DOMXPath( self::$dom );
            # Найденые узлы
            $Nodes =  $xpath->query( $xpathQuery );

            $elementLi = self::$dom->createElement('li');

            $elementLI_A = self::$dom->createElement('a' , $name);
            $elementLI_A->setAttribute('class' , 'menu__link');
            $elementLI_A->setAttribute('href' , $category_link );

            $elementLi->appendChild($elementLI_A) ;
            $Nodes->item(0)->appendChild($elementLi) ;


            return ;








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
        public function addLevel1( $name , $category_link   ){

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
         * Найти в последнем столбце последнюю категорию 1 уровня
         * и в ней список для категорий второго уровня
         *
         * @return \DOMNodeList|false
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   06.04.2021 03:43
         *
         */
        private function getLastColumnAndList(){
            $Translator = new \GNZ11\Document\Dom\Translator( '.menu__main-cats-inner .menu__hidden-column' );
            $xpathQuery = $Translator->asXPath();
            $xpathQuery = '//div[contains(@class,"menu__main-cats-inner")]/div[last()]/ul[last()]//ul';
            $xpath = new \DOMXPath( self::$dom );
            # Найденые узлы
            $Nodes =  $xpath->query( $xpathQuery );

            return $Nodes  ;
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
               # Найденые узлы
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
            #
            $resCheck = $this->checkElement( '//div[contains(@class,"menu__hidden-content")]');
            if( !$resCheck )
            {
                $xpathQuery = '//li[contains(@class,"menu-categories__item")] ';
                $xpath = new \DOMXPath( self::$dom );
                # Найденые узлы
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
         * Выгрузить разметку категории
         * @return false|string
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   05.04.2021 23:34
         *
         */
        public function saveDomElem(){
//            self::$dom = new \GNZ11\Document\Dom();
//            self::$dom->loadHTML($this->Html);

            $html = self::$dom->saveHTML();
//
//            return self::$dom ;
//            $html = $this->Html  ;
//            $this->Html = '' ;
            return $html ;
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



    }



























