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
                <h3 class="uppercase">Features</h3>
            </li>
            <li class="nav-item start <?= (@$left_menu_active == 1) ? 'active' : '' ?>">
                <a href="../prod_quotation" class="nav-link nav-toggle">
                    <i class="fa fa-diamond"></i>
                    <span class="title">តារាងតម្លៃ / Quotation</span>
                </a>
            </li>
            <li class="nav-item start <?= (@$left_menu_active == 2) ? 'active' : '' ?>">
                <a href="../prod_rubber_tree" class="nav-link nav-toggle">
                    <i class="fa fa-diamond"></i>
                    <span class="title">ចំនួនដើមកៅស៊ូតាមបាំងនីមួយៗ</span>
                </a>
            </li>
            <li class="nav-item start <?= (@$left_menu_active == 3) ? 'active' : '' ?>">
                <a href="../prod_delivery_n" class="nav-link nav-toggle">
                    <i class="fa fa-diamond"></i>
                    <span class="title">តារាងដឹកជញ្ជូន / DELIVERY NOTE</span>
                </a>
            </li>
            <li class="nav-item start <?= (@$left_menu_active == 4) ? 'active' : '' ?>">
                <a href="../prod_invoice" class="nav-link nav-toggle">
                    <i class="fa fa-diamond"></i>
                    <span class="title">តារាងវិក័យបត្រ / Invoice</span>
                </a>
            </li>
            <li class="heading">
                <h3 class="uppercase">Data List</h3>
            </li>
            <li class="nav-item start <?= (@$left_menu_active == 5) ? 'active' : '' ?>">
                <a href="../prod_price_list" class="nav-link nav-toggle">
                    <i class="fa fa-diamond"></i>
                    <span class="title">តារាងតម្លៃផលិតផល / Price List</span>
                </a>
            </li>

            <li class="nav-item <?= (@$left_menu_active == 6) ? 'active' : '' ?>  ">
                <a href="../prod_customer" class="nav-link nav-toggle">
                    <i class="fa fa-diamond"></i>
                    <span class="title">តារាងអតិថិជន/ Customer</span>
                </a>
            </li>
            <li class="nav-item <?= (@$left_menu_active == 8) ? 'active' : '' ?>">
                <a href="../prod_type_make_list" class="nav-link nav-toggle">
                    <i class="fa fa-diamond"></i>
                    <span class="title">ប្រភេឈ្មោះ (កែច្នៃថ្ម)</span>
                </a>
            </li>
            <li class="nav-item <?= (@$left_menu_active == 9) ? 'active' : '' ?>">
                <a href="../prod_items_list" class="nav-link nav-toggle">
                    <i class="fa fa-diamond"></i>
                    <span class="title">ផលិតផលកែច្នៃ</span>
                </a>
            </li>
            <li class="nav-item <?= (@$left_menu_active == 10) ? 'active' : '' ?>">
                <a href="../prod_estimate" class="nav-link nav-toggle">
                    <i class="fa fa-diamond"></i>
                    <span class="title">Custom Estimate</span>
                </a>
            </li>
            <li class="nav-item <?= (@$left_menu_active == 11) ? 'active' : '' ?>">
                <a href="../prod_sale_order" class="nav-link nav-toggle">
                    <i class="fa fa-diamond"></i>
                    <span class="title">Sale Order</span>
                </a>
            </li>
            <li class="nav-item <?= (@$left_menu_active == 12) ? 'active' : '' ?>">
                <a href="../prod_type_dv" class="nav-link nav-toggle">
                    <i class="fa fa-diamond"></i>
                    <span class="title">Type Deliveiry Note</span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>