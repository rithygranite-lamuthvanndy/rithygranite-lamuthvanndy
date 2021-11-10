<div class="page-sidebar-wrapper">
   <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-sidebar-menu-closed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" id="my_scroll">
            <li class="heading">
                <h3 style="font-family: 'Khmer'; text-decoration: underline;"><i class="fa fa-star" style="color: red;"></i>ទំនាក់ទំនងការងារ</h3>
            </li>
            <li class="nav-item start <?= (@$left_menu_active=='1')?'active':'' ?>">
                <a href="../dev_top_menu_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">មើលប្រវត្តិរូបអ្នកផ្សេង</span>
                </a>
            </li>
            <li class="nav-item start <?= (@$left_menu_active=='2')?'active':'' ?>">
                <a href="../dev_left_menu_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">ទ៉នាក់ទំនងអ្នកផ្សេង</span>
                </a>
            </li>
            <li class="heading">
                <h3 style="font-family: 'Khmer'; text-decoration: underline;"><i class="fa fa-star" style="color: red;"></i>ស្នើសុំ (ទំរង)</h3>
            </li>
            <li class="nav-item start <?= (@$left_menu_active=='1')?'active':'' ?>">
                <a href="../dev_top_menu_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">ស្នើសុំឈប់សម្រាក</span>
                </a>
            </li>
            <li class="nav-item start <?= (@$left_menu_active=='2')?'active':'' ?>">
                <a href="../dev_left_menu_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">ស្នើសុំចុះបេសកកម្ម</span>
                </a>
            </li>
            <li class="nav-item start <?= (@$left_menu_active=='2')?'active':'' ?>">
                <a href="../dev_left_menu_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">ស្នើសុំធ្វើការថើមម៉ោង</span>
                </a>
            </li>
            <li class="nav-item start <?= (@$left_menu_active=='2')?'active':'' ?>">
                <a href="../dev_left_menu_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">ស្នើសុំ ផ្សេងៗ</span>
                </a>
            </li>
            <li class="heading">
                <h3 style="font-family: 'Khmer'; text-decoration: underline;"><i class="fa fa-star" style="color: red;"></i>របាយការណ៍ផ្សេង</h3>
            </li>
            <li class="nav-item start <?= (@$left_menu_active=='1')?'active':'' ?>">
                <a href="../dev_top_menu_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">របាយការណ៍ការងារប្រចាំថ្ងៃ (ការងារអទិភាព)</span>
                </a>
            </li>
            <li class="nav-item start <?= (@$left_menu_active=='2')?'active':'' ?>">
                <a href="../dev_left_menu_list/" class="nav-link nav-toggle">
                    <i class="fa fa-list"></i>
                    <span class="title">របាយការណ៍ការងារ ទទួលការងារពីអ្នកផ្សេង</span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- 
            <li class="nav-item <?= (@$dropdown)?'active':'' ?>">

                <a href="" class="nav-link nav-toggle">
                    <i class="fa fa-money"></i> <span class="title">Data List</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item start <?= (@$left_menu_active==96)?'active':'' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_counter_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Counter List</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active==97)?'active':'' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_color_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Color List</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active==98)?'active':'' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_floor_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Floor List</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active==99)?'active':'' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_location_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Location List</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active==100)?'active':'' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_grade_type_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Grade Type List</span>
                        </a>
                    </li>
                    <li class="nav-item start  <?= (@$left_menu_active==101)?'active':'' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_category_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Inventory Category List</span>
                        </a>
                    </li>
                    <li class="nav-item start  <?= (@$left_menu_active==102)?'active':'' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_feature_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Inventory Feature List</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active==103)?'active':'' ?>">
                        <a href="../inv_branch_location_list/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Branch Location</span>
                        </a>
                    </li>
                    <li class="nav-item start <?= (@$left_menu_active==103)?'active':'' ?>" style="font-family: 'khmer os';">
                        <a href="../inv_product_step/" class="nav-link nav-toggle">
                            <i class="fa fa-list"></i>
                            <span class="title">Production Step</span>
                        </a>
                    </li>
                </ul>
            </li> -->