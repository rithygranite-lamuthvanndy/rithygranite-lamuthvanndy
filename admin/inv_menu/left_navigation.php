<script type="text/javascript" src="../inv_operation/JS/operation.js"></script>
<style type="text/css">
    /*Left Menu Scrolling*/
    #my_scroll {
        overflow-y: scroll;
        max-height: 800px !important;
        /*width: auto;*/

    }

    #my_scroll::-webkit-scrollbar {
        width: 10px;
    }

    /* Track */
    #my_scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    #my_scroll::-webkit-scrollbar-thumb {
        background: #888;
    }

    /* Handle on hover */
    #my_scroll::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /*Global Scrolling*/
    /* width */
    ::-webkit-scrollbar {
        width: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #CFC5C5;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-sidebar-menu-closed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" id="my_scroll">
            <li class="heading">
                <h3 style="font-family: 'Khmer'; text-decoration: underline;">
                    <i class="fa fa-star" style="color: red;"></i>
                    A. ផ្នែកថ្មប្លុក (វត្ថុធាតុដើម)
                </h3>
            </li>
            <li class="nav-item start <?= (@$left_menu_active == 1) ? 'active' : '' ?>">
                <a href="../inv_1_stock_block_stone/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">1-ស្តុកថ្មប្លុក</span>
                </a>
            </li>
            <li class="nav-item start <?= (@$left_menu_active == 2) ? 'active' : '' ?>">
                <a href="../inv_2_stock_slab/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">2-ស្តុកថ្មសន្លឹកដាក់</span>
                </a>
            </li>
            <li class="heading">
                <h3 style="font-family: 'Khmer'; text-decoration: underline;">
                    <i class="fa fa-star" style="color: red;"></i>
                    B.ផ្នែកផលិតផលសម្រេច
                </h3>
            </li>
            <li class="nav-item start <?= (@$left_menu_active == 3) ? 'active' : '' ?>">
                <a href="../inv_2_stock_slab_no_polish/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">3-ស្តុកថ្មសន្លឹកមិនទាន់ប៉ូលា</span>
                </a>
            </li>
            <li class="nav-item start <?= (@$left_menu_active == 4) ? 'active' : '' ?>">
                <a href="../inv_3_stock_slab_polish" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">4-ស្តុកថ្មសន្លឹកប៉ូលា</span>
                </a>
            </li>
            <li class="heading">
                <h3 style="font-family: 'Khmer'; text-decoration: underline;">
                    <i class="fa fa-star" style="color: red;"></i>
                    C.ផ្នែកកែឆ្នៃផ្សេងៗ
                </h3>
            </li>
            <li class="nav-item start <?= (@$left_menu_active == 5) ? 'active' : '' ?>">
                <a href=" ../inv_count_stone_cursed/" class="nav-link nav-toggle">
                <i class="fa fa-list"></i>
                <span class="title">5-ស្តុកកែឆ្នៃផ្សេងៗ </span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">5-ថ្មសន្លឹកកាត់ខ្នាត </span>
                </a>
            </li>

            <li class="nav-item start ">
                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">6-ថ្មដាប់ </span>
                </a>
            </li>

            <li class="heading">
                <h3 style="font-family: 'Khmer'; text-decoration: underline;">
                    <i class="fa fa-star" style="color: red;"></i>
                    D.ផ្នែកបញ្ចេញពីឃ្លាំង
                </h3>
            </li>
            <li class="nav-item start ">
                <a href="#" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">7-ស្តុកបញ្ចេញ </span>
                </a>
            </li>
            <li class="nav-item <?= (@$dropdown) ? 'active' : '' ?>">

                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-money"></i> <span class="title">E. Report Granite Inventory </span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start <?= (@$left_menu_active == 95) ? 'active' : '' ?>" style="font-family: 'khmer os';">
                        <a href="#" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">ggggg</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item <?= (@$dropdown == 1) ? 'dropdown' : '' ?> <?= (@$dropdown_tree ==1) ? 'active' : '' ?>">

                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-money"></i> <span class="title">Data List</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start <?= (@$left_menu_active == 95) ? 'active' : '' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_type_make_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">ថ្មកែច្នៃ</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active == 96) ? 'active' : '' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_counter_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Counter List</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active == 97) ? 'active' : '' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_color_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Color List</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active == 98) ? 'active' : '' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_floor_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Floor List</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active == 99) ? 'active' : '' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_location_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Location List</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active == 100) ? 'active' : '' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_grade_type_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Grade Type List</span>
                        </a>
                    </li>
                    <li class="nav-item start  <?= (@$left_menu_active == 101) ? 'active' : '' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_category_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Inventory Category List</span>
                        </a>
                    </li>
                    <li class="nav-item start  <?= (@$left_menu_active == 102) ? 'active' : '' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_feature_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Inventory Feature List</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active == 103) ? 'active' : '' ?>">
                        <a href="../inv_branch_location_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Branch Location</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active == 103) ? 'active' : '' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_product_step/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Production Step</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active == 104) ? 'active' : '' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_project_list" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Project List</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active == 105) ? 'active' : '' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_pro_name" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Inventory Name</span>
                        </a>
                    </li>

                </ul>
                <!-- <li class="nav-item start ">
                <a href="../inv_pro_name/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Inventory Out</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../inv_pro_name/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Inventory Adjust</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../inv_pro_name/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Inventory Transfer</span>
                </a>
            </li>
            <li class="nav-item start ">
                <a href="../inv_pro_name/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">Inventory Balance</span>
                </a>
            </li> -->


        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>