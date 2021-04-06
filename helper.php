<?php

    use Joomla\CMS\Factory;
    use Joomla\CMS\Filesystem\File;
    use Joomla\CMS\Layout\LayoutHelper;
    use Joomla\CMS\MVC\View\HtmlView;
    use Joomla\CMS\Table\Table;
    use Joomla\Registry\Registry;

    defined('_JEXEC') or die('Restricted access');

    require_once(JPATH_SITE . DS . 'components' . DS . 'com_jshopping' . DS . "lib" . DS . "factory.php");
    require_once(JPATH_SITE . DS . 'components' . DS . 'com_jshopping' . DS . "lib" . DS . "functions.php");

    class ModMenuCategoriesShopHelper
    {
        /**
         * @var \Joomla\CMS\Application\CMSApplication|null
         * @since 3.9
         */
        public $app;
        /**
         * @var \JDatabaseDriver|null
         * @since 3.9
         */
        private $db;
        public static $instance;

        private $params ;

        public static $viewConfig = [
            'name' => 'category' ,
            'charset' => 'UTF-8' ,
            'template_plath' => null ,
        ];
        /**
         * @var Object jshopConfig конфигурация jshop
         * @since 3.9
         */
        public $jshopConfig;
        /**
         * @var  string Имя шаблона
         * @since 3.9
         */
        private $template;




        /**
         * helper constructor.
         *
         * @param array $options
         *
         * @throws Exception
         * @since 3.9
         */
        private function __construct( $options = array() )
        {
            JLoader::registerNamespace( 'GNZ11' , JPATH_LIBRARIES . '/GNZ11' , $reset = false , $prepend = false , $type = 'psr4' );
            JLoader::registerNamespace( 'MenuCategoriesShop\Helpers' , __DIR__ . '/helpers' , $reset = false , $prepend = false , $type = 'psr4' );

            $this->params = $options ;
            $this->app = Factory::getApplication();
            $this->db = Factory::getDbo();

            $this->template = $this->app->getTemplate();


            $this->jshopConfig = JSFactory::getConfig();
            $this->jshopConfig->cur_lang = $this->jshopConfig->frontend_lang;

            $this->setOtions();

            return $this;
        }#END FN

        /**
         * @param array $options
         *
         * @return ModJshoppingRandomMHelper
         * @throws Exception
         * @since 3.9
         */
        public static function instance( $options = array() )
        {
            if ( self::$instance === null ){
                self::$instance = new self($options);
            }
            return self::$instance;
        }#END FN

        public function setOtions(){
            $doc = \Joomla\CMS\Factory::getDocument();
            $paramsData['selector_key'] = $this->params->get('selector_key' , '#fat-menu');
            $doc->addScriptOptions('mod_menu_categories_shop' , $paramsData );
        }

        /**
         * Получить верхний уровень категорий
         * @param     $order
         * @param     $ordering
         * @param     $category_id
         * @param     $categories_id
         * @param     $categories
         * @param int $level
         *
         * @since  3.9
         * @auhtor Gartes | sad.net79@gmail.com | Skype : agroparknew | Telegram : @gartes
         * @date   05.04.2021 07:13
         *
         */
        public static function getTreeCats($order, $ordering, $category_id, $categories_id, &$categories, $level=0){
            $cat = JTable::getInstance('category', 'jshop');
            $cat->category_parent_id = 0;
            $cats = $cat->getSisterCategories($order, $ordering);




            foreach($cats as $key=>$value){
                $cats[$key]->level = $level;
                $categories[] = $value;
                self::getTreeCats2($order, $ordering, $value->category_id, $categories_id, $categories, $level);
            }


        }

        public static function getTreeCats2($order, $ordering, $category_id, $categories_id, &$categories, $level){
            ++$level;
            $cat = JTable::getInstance('category', 'jshop');
            $cat->category_id = $category_id;
            $cats = $cat->getChildCategories($order, $ordering);

            foreach($cats as $key=>$value){
                $cats[$key]->level = $level;
                $categories[] = $value;
                self::getTreeCats2($order, $ordering, $value->category_id, $categories_id, $categories, $level);
            }
        }

        public static function getCatsArray($order, $ordering, $category_id, $categories_id = array()){
            $res_arr = array();
            self::getTreeCats($order, $ordering, $category_id, $categories_id, $res_arr, 0);

//            echo'<pre>';print_r( $res_arr );echo'</pre>'.__FILE__.' '.__LINE__ . PHP_EOL;

            return $res_arr;
        }



        public static function countHasChild($item , $i , $categories_arr ){
            $pId = $item->category_id ;

            if( $categories_arr[$i+1]->category_parent_id != $item->category_id )
            {
                return false;
            }#END IF
            
            
            $countChild = 0 ;
            for ($a = 1 ; $a < count( $categories_arr ); $a++ ){
                if( $categories_arr[$i+$a]->category_parent_id != $item->category_id )
                {
                    return $countChild;
                }#END IF
                $countChild++;

            }

            die(__FILE__ .' '. __LINE__ );


        }



    }











