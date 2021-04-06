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
     * @date       04.04.2021 15:37
     * @copyright  Copyright (C) 2005 - 2021 Open Source Matters, Inc. All rights reserved.
     * @license    GNU General Public License version 2 or later;
     ******************************************************************************************************************/

    use Joomla\CMS\Uri\Uri;

    defined('_JEXEC') or die; // No direct access to this file

    /**
     * @var \Joomla\Registry\Registry   $params         - Параметры модуля
     * @var ModMenuCategoriesShopHelper $Helper         - объект Helper модуля
     * @var array                       $categories_arr - массив категорий
     */

    try
    {
        $HelperDom = \MenuCategoriesShop\Helpers\Dom::instance($params) ;
    } catch ( Exception $e )
    {
    }

?>

<div class="menu-wrapper menu-wrapper_state_animated" style="display: none;"><!---->
    <ul class="menu-categories"><!---->

        <?php
            $oldLevel = 0 ;
            $openLevel1 = false ;
            $openLevel2 = false ;

            $countColumn = 0 ;                                          # Счетчик количества столбцов
            $countColumnMax = $params->get( 'count_column_max' , 3 ) ;  # Максимальное количества столбцов в меню
            $openColumn = false ;                                       # открытая колонка
            $counterElementInCol = 0 ;                                  # Количество элементов столбце
            $waitLevel0 = false ;                                       # Ждать уровень 0 ( для ограничения количества столбцов )
            $categories__item = '';
            foreach ($categories_arr as $a => $item)
            {
                $item->category_link =  SEFLink('index.php?option=com_jshopping&controller=category&task=view&category_id='.$item->category_id ,1 ) ;

                if( $item->level == 0 )
                {








                    $HelperDom->addLevel0( $item->name , $item->category_link );

                }

                if( $item->level == 1 )
                {
//                    $countChild = $Helper::countHasChild( $item , $a , $categories_arr ) ;

                    $HelperDom->addLevel1( $item->name , $item->category_link   );

                }#END IF

                if( $item->level == 2 )
                {
                    $HelperDom->addLevel2( $item->name , $item->category_link );
                }#END IF

                # Если следующи уровень 0 - Закрываем список с суб категориями
                if( $categories_arr[$a + 1]->level == 0 )
                {
                    echo $HelperDom->saveDomElem();
                }






            }#END FOREACH
//            die(__FILE__ .' '. __LINE__ );

//            echo $HelperDom->saveDomElem();

        ?>

        <li class="menu-categories__item">
            <a apprzroute="" class="menu-categories__link js-menu-categories__link "
               href="https://rozetka.com.ua/computers-notebooks/c80253/" target="">
                <span class="menu-categories__icon">
                    <svg height="24" width="24">
                        <use href="#icon-fat-2416"></use>
                    </svg>
                </span>Ноутбуки и компьютеры
                <svg aria-hidden="true" class="menu-categories__link-chevron" height="9" width="6">
                    <use href="#icon-fat-chevron"></use>
                </svg>
            </a>

            <!-- Вложенные категории -->
            <div class="menu__hidden-content" style=""><!---->

                <!-- Популярные категории -->
                <!--  <div class="menu__hidden-column menu__hidden-column_color_gray">
                      <p class="menu__hidden-title menu__hidden-title_color_gray"> Популярные категории </p>
                      <ul class="menu__hidden-list">
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://rozetka.com.ua/notebooks/c80004/"> Ноутбуки </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://rozetka.com.ua/tablets/c130309/"> Планшеты </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/videocards/c80087/"> Видеокарты </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/hdd/c80084/"> Жесткие диски и дисковые массивы </a>
                          </li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/monitors/c80089/"> Мониторы </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/computers/c80095/"> Компьютеры, неттопы, моноблоки </a>
                          </li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/processors/c80083/"> Процессоры </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/ssd/c80109/"> SSD </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://rozetka.com.ua/consoles/c80020/platforma=playstation-5;producer=playstation/">
                                  PlayStation 5 </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://rozetka.com.ua/printers-mfu/c80007/"> МФУ/Принтеры </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/memory/c80081/"> Память </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/motherboards/c80082/"> Материнские платы </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/mouses/c80172/"> Мыши </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://rozetka.com.ua/routers/c80193/"> Маршрутизаторы </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/speakers/c80100/"> Акустические системы </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/keyboards/c80171/"> Клавиатуры </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/psu/c80086/"> Блоки питания </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/cases/c80090/"> Корпуса </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://rozetka.com.ua/projector/c80012/"> Проекторы </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://rozetka.com.ua/usb-flash-memory/c80045/"> Флеш память USB </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/ups/c80108/"> Источники бесперебойного питания </a>
                          </li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://hard.rozetka.com.ua/coolers/c80099/"> Системы охлаждения </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://rozetka.com.ua/consoles/c80020/"> Игровые консоли и детские приставки </a>
                          </li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://rozetka.com.ua/notebook-bags/c80036/"> Сумки, рюкзаки и чехлы для
                                  ноутбуков </a></li>
                          <li><a apprzroute="" class="menu__link menu__link_background_gray"
                                 href="https://rozetka.com.ua/stabilizatori-napryageniya/c4649424/rekomenduemoe-primenenie=dlya-kompyuterov/">
                                  Стабилизаторы напряжения </a></li>
                      </ul>
                  </div>-->


                <div class="menu__main-cats">
                    <div class="menu__main-cats-inner"><!---->
                        <!-- Первая колонка -->
                        <div class="menu__hidden-column"><!----><!---->
                            <ul class="menu__hidden-list">
                                <li>
                                    <a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/notebooks/c80004/">Ноутбуки</a><!----><!---->
                                    <ul><!---->
                                        <li>
                                            <a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/notebooks/c80004/producer=asus/"> Asus </a>
                                        </li>

                                        <li>
                                            <a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/notebooks/c80004/producer=acer/"> Acer </a>
                                        </li>
                                        <li>
                                            <a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/notebooks/c80004/producer=hp-hewlett-packard/">
                                                HP (Hewlett Packard) </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/notebooks/c80004/producer=lenovo/">
                                                Lenovo </a></li>
                                        <li>
                                            <a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/notebooks/c80004/producer=dell/"> Dell </a>
                                        </li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/notebooks/c80004/producer=apple/">
                                                Apple </a></li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li>
                                    <a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/computers-notebooks-accessories/c80256/">Аксессуары
                                        для ноутбуков и ПК</a><!----><!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/usb-flash-memory/c80045/"> Флеш память
                                                USB </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/notebook-bags/c80036/"> Сумки и рюкзаки для
                                                ноутбуков </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/notebook_stands/c183690/"> Подставки и
                                                столики для ноутбуков </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/web_cameras/c180143/"> Веб-камеры </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/universalnye-mobilnye-batarei/c387969/40239=72874/">
                                                Универсальные мобильные батареи для ноутбуков </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/tv-cables/c80073/"> Кабели и
                                                переходники </a></li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li>
                                    <a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/tablets/c130309/">Планшеты</a><!----><!---->
                                    <ul><!----></ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li>
                                    <a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/tablet_covers/c305219/">Аксессуары к планшетам</a>
                                    <!----><!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/tablet_covers/c305219/"> Чехлы и клавиатуры
                                                для планшетов </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/protect_skin/c146202/23448=72894/"> Защитные
                                                пленки и стекла </a></li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li>
                                    <a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/grafic-tablets/c83199/">Графические планшеты</a>
                                    <!----><!---->
                                    <ul><!----></ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li>
                                    <a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/e-books/c80023/">Электронные книги</a><!----><!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/ereader_accessories/c195851/"> Аксессуары
                                                для электронных книг </a></li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li>
                                    <a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/rasprodaja/c83850/">Уцененные товары</a><!---->
                                    <!---->
                                    <ul><!----></ul>
                                </li>
                            </ul>
                        </div><!---->
                        <!-- Вторая колонка -->
                        <div class="menu__hidden-column"><!----><!---->
                            <ul class="menu__hidden-list">
                                <li>
                                    <a apprzroute="" class="menu__hidden-title" href="https://hard.rozetka.com.ua/">Комплектующие</a>
                                    <!----><!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/videocards/c80087/"> Видеокарты </a>
                                        </li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/hdd/c80084/"> Жесткие диски и дисковые
                                                массивы </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/processors/c80083/"> Процессоры </a>
                                        </li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/ssd/c80109/"> SSD </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/memory/c80081/"> Память </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/motherboards/c80082/"> Материнские
                                                платы </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/psu/c80086/"> Блоки питания </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/cases/c80090/"> Корпуса </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/ups/c80108/"> Источники бесперебойного
                                                питания </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/coolers/c80099/"> Системы
                                                охлаждения </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/stabilizatori-napryageniya/c4649424/">
                                                Стабилизаторы напряжения </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/optical-drives/c80085/"> Оптические
                                                приводы </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/soundcards/c80088/"> Звуковые
                                                карты </a></li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li>
                                    <a apprzroute="" class="menu__hidden-title"
                                       href="https://hard.rozetka.com.ua/computers/c80095/">Компьютеры</a><!----><!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/monitors/c80089/"> Мониторы </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/mouses/c80172/"> Мыши </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/keyboards/c80171/"> Клавиатуры </a>
                                        </li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/keybords-kit/c80174/"> Комплект:
                                                клавиатура + мышь </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/nas/c80199/"> Сетевые хранилища (NAS) </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li>
                                    <a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/servernoe-oborudovanie/c4630100/">
                                        Серверное оборудование
                                    </a><!----><!---->
                                    <ul><!----></ul>
                                </li>
                            </ul>
                        </div><!---->
                        <!-- 3 колонка -->
                        <div class="menu__hidden-column"><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/office-equipment/c80254/">Оргтехника</a><!---->
                                    <!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/printers-mfu/c80007/"> МФУ/Принтеры </a>
                                        </li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/projector/c80012/"> Проекторы </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/snpc/c81224/"> Расходные материалы для
                                                принтеров </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/office-phones/c80029/"> Телефонные
                                                аппараты </a></li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/interaktivnoe-oborudovanie/c4643064/">Интерактивное
                                        оборудование</a><!----><!---->
                                    <ul><!----></ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title" href="https://soft.rozetka.com.ua/">Программное
                                        обеспечение</a><!----><!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://soft.rozetka.com.ua/os/c80063/"> Операционные системы </a>
                                        </li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://soft.rozetka.com.ua/ofisnye-prilojeniya/c80064/"> Офисные
                                                приложения </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://soft.rozetka.com.ua/antivirus/c80062/"> Антивирусы </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/game-zone/c80261/">Товары для геймеров</a><!---->
                                    <!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/playstation-store/c4668379/">
                                                PlayStation </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/consoles/c80020/"> Игровые консоли и
                                                приставки </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/djoysticks/c80173/"> Джойстики и
                                                аксессуары </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/games/c80066/"> Игры </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/gaming-surfaces/c80112/"> Игровые
                                                поверхности </a></li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/network-equipment/c80111/">Сетевое оборудование</a>
                                    <!----><!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/patch-kordi/c4631572/"> Патч-корды </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/routers/c80193/"> Маршрутизаторы </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/ip_cam/c156790/"> IP-камеры </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/switches/c80194/"> Коммутаторы </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/wireless-access-points/c80195/">
                                                Беспроводные точки доступа </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div><!---->

                        <?php require JModuleHelper::getLayoutPath('mod_menu_categories_shop' , 'default_content-modules'); ?>

                    </div>

                    <div class="menu__main-cats menu__main-cats_type_bottom">
                        <div class="menu__hidden-column">
                            <a class="menu__hidden-title"
                               href="https://rozetka.com.ua/computers-notebooks/c80253/">
                                Все категории </a>
                        </div><!---->


                        <!--                        --><?php //require JModuleHelper::getLayoutPath('mod_menu_categories_shop', 'default_brands' );  ?>


                    </div>
                </div>
            </div>
        </li>


        <li class="menu-categories__item">
            <a apprzroute="" class="menu-categories__link js-menu-categories__link"
               href="https://rozetka.com.ua/telefony-tv-i-ehlektronika/c4627949/"
               target="">
                <span class="menu-categories__icon">
                    <svg height="24" width="24">
                        <use href="#icon-fat-3361"></use>
                    </svg>
                </span>Смартфоны, ТВ и электроника<!----><!---->
                <svg aria-hidden="true" class="menu-categories__link-chevron" height="9" width="6">
                    <use href="#icon-fat-chevron"></use>
                </svg>
            </a><!---->
            <div class="menu__hidden-content" style=""><!---->
                <div class="menu__hidden-column menu__hidden-column_color_gray"><p
                            class="menu__hidden-title menu__hidden-title_color_gray"> Популярные категории </p>
                    <ul class="menu__hidden-list"><!---->
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/mobile-phones/c80003/"> Мобильные телефоны </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/all-tv/c80037/"> Телевизоры </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/photo/c80001/"> Фотоаппараты </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/headphones/c80027/"> Наушники </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/universalnye-mobilnye-batarei/c387969/40239=72869/">
                                Универсальные мобильные батареи </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/memory-cards/c80044/"> Карты памяти </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/mobile-phones/c80003/preset=smartfon;producer=apple/">
                                Смартфоны Apple </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/video/c80002/"> Видеокамеры </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/e-books/c80023/"> Электронные книги </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/smartwatch/c651392/producer=apple/"> Apple Watch </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/vdr/c153617/"> Видеорегистраторы </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/tv-mounts-stands/c80071/"> Подставки, крепления для ТВ </a>
                        </li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/muzykalnye-tsentry-i-magnitoly/c224329/"> Музыкальные центры
                                и магнитолы </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/home-theaters/c84535/"> Домашние кинотеатры </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/dvd-hd-players/c80011/"> Blu-ray/DVD/HD/-медиаплееры </a>
                        </li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/smartwatch/c651392/"> Смарт-часы </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/tv-cables/c80073/"> Кабели и переходники </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/lens/c80060/"> Объективы </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/gps-navigators/c80047/"> GPS навигаторы </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/monopody-dlia-selfi-i-aksessuary/c4625067/"> Моноподы для
                                селфи и аксессуары </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/baterries/c654239/"> Аккумуляторы и батарейки </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/mobile-cases/c146229/"> Чехлы для мобильных телефонов </a>
                        </li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/fitnes-trekery/c4627554/"> Фитнес-браслеты </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/hi-fi_speakers/c451989/"> Акустика Hi-Fi </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/protect_skin/c146202/23448=mobile/"> Защитные пленки и
                                стекла </a></li>
                        <li><a apprzroute="" class="menu__link menu__link_background_gray"
                               href="https://rozetka.com.ua/tv_antennas/c165692/"> ТВ-антенны и ресиверы </a></li>
                    </ul>
                </div>
                <div class="menu__main-cats">
                    <div class="menu__main-cats-inner"><!----><!---->
                        <div class="menu__hidden-column"><!----><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/mobile-phones/c80003/">Телефоны</a><!----><!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/mobile-phones/c80003/preset=smartfon/">
                                                Смартфоны </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/mobile-phones/c80003/preset=mob-phones/">
                                                Кнопочные телефоны </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/office-phones/c80029/"> Офисные
                                                телефоны </a></li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/mobile-smart-accessories/c80263/">Аксессуары для
                                        мобильных телефонов</a><!----><!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/universalnye-mobilnye-batarei/c387969/40239=72869/">
                                                Универсальные мобильные батареи </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/memory-cards/c80044/"> Карты памяти </a>
                                        </li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/mobile-cases/c146229/"> Чехлы для мобильных
                                                телефонов </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/protect_skin/c146202/23448=mobile/">
                                                Защитные пленки и стекла </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/monopody-dlia-selfi-i-aksessuary/c4625067/">
                                                Моноподы для селфи </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/headphones/c80027/21078=2726;23143=yes/">
                                                Гарнитуры </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/3d_glasses/c131143/"> 3D и VR очки </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/autoholders/c147913/29385=33065/">
                                                Держатели </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/data_cable/c146539/"> Кабели
                                                синхронизации </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/headsets/c80032/"> Гарнитуры Bluetooth </a>
                                        </li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/mobilnaya-svyaz-i-internet/c4626529/">
                                                Мобильная связь и интернет </a></li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/tv/c80015/">Телевизоры и аксессуары</a><!---->
                                    <!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/all-tv/c80037/"> Телевизоры </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/tv-mounts-stands/c80071/"> Подставки,
                                                крепления для ТВ </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/tv-cables/c80073/"> Кабели и
                                                переходники </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/tv_antennas/c165692/"> ТВ-антенны и
                                                ресиверы </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/universal-remote-control/c80070/">
                                                Универсальные пульты ДУ </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/tv_webcam/c221177/"> Аксессуары для ТВ </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/rasprodaja/c83850/">Уцененные товары</a><!---->
                                    <!---->
                                    <ul><!----></ul>
                                </li>
                            </ul>
                        </div><!---->
                        <div class="menu__hidden-column"><!----><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/tv-photo-video/c80258/">Фото и видео</a><!---->
                                    <!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/photo/c80001/"> Фотоаппараты </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/video/c80002/"> Видеокамеры </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/lens/c80060/"> Объективы </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/ekshn-kameri-i-aksessuari/c4630489/">
                                                Экшн-камеры и аксессуары </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/baterries/c654239/"> Аккумуляторы и
                                                батарейки </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/tripods/c80075/"> Штативы </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/zaryadnye-ustroystva-dlya-foto-i-videokamer/c83878/">
                                                Зарядные устройства </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/flashes/c80061/"> Вспышки </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/akkumulyatory-dlya-foto-i-videokamer/c83868/">
                                                Аккумуляторы для фото- и видеокамер </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/studijnoe-oborudovanie/c4625234/"> Студийное
                                                оборудование </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/cases-photo/c80041/"> Сумки и чехлы </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/2628092/c2628092/">Аудио и домашние кинотеатры</a>
                                    <!----><!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/dvd-hd-players/c80011/">
                                                DVD/HD-медиаплееры </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/muzykalnye-tsentry-i-magnitoly/c224329/">
                                                Музыкальные центры </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/home-theaters/c84535/"> Домашние
                                                кинотеатры </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/loudspeakers/c297932/"> Активные
                                                акустические системы </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/hi-fi_speakers/c451989/"> Акустика
                                                Hi-Fi </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/av_receivers/c283322/"> AV-ресиверы </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/proektsionnoe-oborudovanie/c4670651/">Проекционное
                                        оборудование</a><!----><!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/projector/c80012/"> Проекторы </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/projector-screens/c80021/"> Экраны </a></li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/uslugi/c153670/">Услуги</a><!----><!---->
                                    <ul><!----></ul>
                                </li>
                            </ul>
                        </div><!---->
                        <div class="menu__hidden-column"><!----><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/portativnaya-ehlektronika/c4627865/">Портативная
                                        электроника</a><!----><!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/tablets/c130309/"> Планшеты </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/headphones/c80027/"> Наушники </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/e-books/c80023/"> Электронные книги </a>
                                        </li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/smartwatch/c651392/"> Смарт-часы </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/fitnes-trekery/c4627554/">
                                                Фитнес-браслеты </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/mp3-pmp/c80016/"> MP3-плееры </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/dictophones/c80022/"> Диктофоны </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/sport_watch/c250809/"> Спортивные часы </a>
                                        </li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/tablet_covers/c305219/"> Аксессуары для
                                                планшетов </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/velokompyutery/c268129/">
                                                Велокомпьютеры </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/speakers/c80100/35704=45344/">
                                                Портативная акустика </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://hard.rozetka.com.ua/hdd/c80084/22680=external/"> Внешние
                                                жесткие диски </a></li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/280596/c280596/">Автоэлектроника</a><!----><!---->
                                    <ul><!---->
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/vdr/c153617/"> Видеорегистраторы </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/gps-navigators/c80047/"> GPS навигаторы </a>
                                        </li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/273291/c273291/"> Автозвук </a></li>
                                        <li><a apprzroute="" class="menu__link"
                                               href="https://rozetka.com.ua/car_alarms/c278818/"> Автосигнализации </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul><!---->
                            <ul class="menu__hidden-list">
                                <li><a apprzroute="" class="menu__hidden-title"
                                       href="https://rozetka.com.ua/playstation-store/c4668379/">PlayStation</a><!---->
                                    <!---->
                                    <ul><!----></ul>
                                </li>
                            </ul>
                        </div><!---->
                        <div class="menu__hidden-column menu__hidden-column_no_padding"><a
                                    href="https://rozetka.com.ua/news-articles-promotions/promotions/010421_galaxy_a11_sp.html">
                                <!----></a></div>
                    </div>
                    <div class="menu__main-cats menu__main-cats_type_bottom">
                        <div class="menu__hidden-column"><a class="menu__hidden-title"
                                                            href="https://rozetka.com.ua/telefony-tv-i-ehlektronika/c4627949/">
                                Все категории </a></div><!----></div>
                </div>
            </div>
        </li>

    </ul>
</div>