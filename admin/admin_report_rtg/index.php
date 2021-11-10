<?php 
    $layout_title = "Welcome";
    $menu_active =44;
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12" style="text-align: center;">
            <h2 style="font-family: 'Khmer OS Moul';">របាយការណ៍ការងារប្រចាំថ្ងៃ</h2>
            <h2><b>BÁO CÁO CÔNG VIỆC HẰNG NGÀY</b></h2>
			<hr>
        </div>
        <div class="col-xs-12">
            <label class="col-md-6">ការដ្ឋានរ៉ែថ្មក្រានីត / NHÀ MÁY ĐÁ GRANITE</label><label class="col-md-6 text-right">ថ្ងៃទី <?= date("d")?>  ខែ <?= date("M")?> ឆ្នាំ  <?= date("Y")?> / Ngày <?= date("d")?>  tháng <?= date("m")?> năm <?= date("Y")?></label><br>
            <hr>
        </div>
        <div class="col-xs-12">
            <h4 style="font-family: 'Khmer OS Siemreap';"><b>I-<u>សង្វាក់ផលិតកម្ម (រណ្តៅរ៉ែ) HOẠT ĐỘNG TẠI KHU KHAI THÁC MỎ</u> </b></h4>

            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-family: 'Khmer OS Siemreap';">1-សកម្មភាពអារថាស់​/Cưa Mâm: </h3>

                  <div class="box-tools pull-right">
                                        <label>
                                          <input type="checkbox" class="minimal" checked>
                                          ថ្ងៃ (Ngày),
                                          <input type="checkbox" class="minimal">
                                          យប់ (Đêm)
                                        </label>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <label>Report Note: </label>
                        <textarea name="txt_note" id="input" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-xs-12 text-right">
                        <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Add</button>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>

            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-family: 'Khmer OS Siemreap';">2-សកម្មភាពអារ​ខ្សែរ/Cưa Dây : </h3>

                  <div class="box-tools pull-right">
                                        <label>
                                          <input type="checkbox" class="minimal" checked>
                                          ថ្ងៃ (Ngày),
                                          <input type="checkbox" class="minimal">
                                          យប់ (Đêm)
                                        </label>

                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <label>Report Note: </label>
                        <textarea name="txt_note" id="input" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-xs-12 text-right">
                        <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Add</button>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>

            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-family: 'Khmer OS Siemreap';">3-សកម្មភាពគាស់យកថ្ម/Thu đá BLOCK: </h3>

                  <div class="box-tools pull-right">
                                        <label>
                                          <input type="checkbox" class="minimal" checked>
                                          ថ្ងៃ (Ngày),
                                          <input type="checkbox" class="minimal">
                                          យប់ (Đêm)
                                        </label>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <label>Report Note: </label>
                        <textarea name="txt_note" id="input" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-xs-12 text-right">
                        <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Add</button>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>

            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-family: 'Khmer OS Siemreap';">4-ដឹកជញ្ជូនថ្មចេញពីរណ្តៅរ៉ែដើម្បីពិនិត្យគុណភាព: </h3>

                  <div class="box-tools pull-right">
                                        <label>
                                          <input type="checkbox" class="minimal" checked>
                                          ថ្ងៃ (Ngày),
                                          <input type="checkbox" class="minimal">
                                          យប់ (Đêm)
                                        </label>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        Vận chuyển đá khu khai thác mỏ để kiểm định chất lượng:
                                        <label><b>Report Note:</b> </label>
                        <textarea name="txt_note" id="input" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-xs-12 text-right">
                        <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Add</button>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>

            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-family: 'Khmer OS Siemreap';">5-សកម្មភាពអារបើកមុខ/ Cưa mở miệng: </h3>

                  <div class="box-tools pull-right">
                                        <label>
                                          <input type="checkbox" class="minimal" checked>
                                          ថ្ងៃ (Ngày),
                                          <input type="checkbox" class="minimal">
                                          យប់ (Đêm)
                                        </label>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                                        <label><b>Report Note:</b> </label>
                        <textarea name="txt_note" id="input" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-xs-12 text-right">
                        <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Add</button>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>

            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-family: 'Khmer OS Siemreap';">6-ប្រភេទម៉ាស៊ីន/ Máy móc :</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <label class="col-xs-12 text-center">អារថាស់/ Máy Cưa Mâm​</label>
                    <div class="col-md-4">
                        <label>អារ/Cưa 1:</label>
                        <input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label>អារ/Cưa 2:</label>
                        <input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label>អារ/Cưa 3:</label>
                        <input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label>អារ/Cưa 4:</label>
                        <input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label>អារ/Cưa 5:</label>
                        <input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label>អារ/Cưa 6:</label>
                        <input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off">
                    </div>
        
                    <hr class="col-xs-12">
                    <label class="col-xs-12 text-center">អារខ្សែ/  Máy Cưa Dây​</label>
                    <div class="col-md-4">
                        <label>អារ/Máy 1:</label>
                        <input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label>អារ/Máy 2:</label>
                        <input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label>អារ/Máy 3:</label>
                        <input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label>អារ/Máy 4:</label>
                        <input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label>អារ/Máy 5:</label>
                        <input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label>អារ/Máy 6:</label>
                        <input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off">
                    </div>
                    <hr class="col-xs-12">
                    <div class="col-xs-12 text-right">
                        <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Add</button>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>

            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-family: 'Khmer OS Siemreap';">ចំនួនកម្មករ ធ្វើការប្តូរវេន :</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-12">
                      <form action="index.php" oninput="txt_total8.value=parseInt(txt_name1.value)+parseInt(txt_name2.value)+parseInt(txt_name3.value)">
                      <table width="100%">
                        <tbody>
                          <tr style="background:  #00ffff;">
                            <td>8/ </td>
                            <td>ចំនួនកម្មករវេន ថ្ងៃ</td>
                            <td>Công nhân (ca ngày) :</td>
                            <td​><output type="number" for="txt_name1 txt_name2 txt_name3" class="form-control" name="txt_total8" id="txt_total8" placeholder=" " required="required" autocomplete="off" style="background:  #00ffff;"></output></td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off" style="background:  #00ffff;"></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td> - តៃកុង​</td>
                            <td>Tài xế  :</td>
                            <td><input type="number" class="form-control" name="txt_name1" id="txt_name1" placeholder=" " required="required" autocomplete="off" value="0"></td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off"></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td> - កម្មករ​អាថាស់</td>
                            <td>Công nhân cưa mâm :</td>
                            <td><input type="number" class="form-control" name="txt_name2" id="txt_name2" placeholder=" " required="required" autocomplete="off" value="0"></td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off"></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td> - កម្មករ​អាខ្សែ - ផ្សេង </td>
                            <td>Công nhân cưa  dây :</td>
                            <td><input type="number" class="form-control" name="txt_name3" id="txt_name3" placeholder=" " required="required" autocomplete="off" value="0"></td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off"></td>
                          </tr>
                          <tr style="background:  #00ffff;">
                            <td>9/ </td>
                            <td>ចំនួនកម្មករវេន យប់</td>
                            <td>Công nhân (ca đêm):</td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off" style="background:  #00ffff;"></td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off" style="background:  #00ffff;"></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td> - តៃកុង​</td>
                            <td>Tài xế  :</td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off"></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td> - កម្មករ​អាថាស់</td>
                            <td>Công nhân cưa mâm :</td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off"></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td> - កម្មករ​អាខ្សែ - ផ្សេង </td>
                            <td>Công nhân cưa  dây :</td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off"></td>
                          </tr>
                          <tr style="background:  #00ffff;">
                            <td>10/ </td>
                            <td>ចំនួនកម្មករប្រយោល</td>
                            <td>Công nhân khác  :</td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off" style="background:  #00ffff;"></td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off" style="background:  #00ffff;"></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td class="text-right"><b>សរុប​/Tổng cộng : </b></td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off"></td>
                            <td><input type="text" class="form-control" name="txt_name" placeholder=" " required="required" autocomplete="off"></td>
                          </tr>

                        </tbody>
                      </table>
                    </form>
                    </div>
                    
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>

            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-family: 'Khmer OS Siemreap';">* <u>បញ្ហាប្រឈម/ Các vướng mắc- khó khăn:</u></h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                                        <label><b>Report Note:</b> </label>
                        <textarea name="txt_note" id="input" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-xs-12 text-right">
                        <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Add</button>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>

            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-family: 'Khmer OS Siemreap';">* <u>សរុបសកម្មភាពផ្សេងៗនៅរណ្តៅរ៉ែ /​ Tổng các hoạt động khác tại khu mỏ:</u></h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                                        <label><b>Report Note:</b> </label>
                        <textarea name="txt_note" id="input" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-xs-12 text-right">
                        <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Add</button>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
        </div>
        <div class="col-xs-12">
        <h4 style="font-family: 'Khmer OS Siemreap';"><b>II-<u>សង្វាក់ផលិតកម្ម (រោងចក្រ) - HOẠT ĐỘNG NHÀ MÁY</u> </b></h4>

            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-family: 'Khmer OS Siemreap';">1-សកម្មភាពអារថ្ម/Cưa đá khối :</h3>

                  <div class="box-tools pull-right">
                                        <label>
                                          <input type="checkbox" class="minimal" checked>
                                          ថ្ងៃ (Ngày),
                                          <input type="checkbox" class="minimal">
                                          យប់ (Đêm)
                                        </label>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                                        <label><b>Report Note:</b> </label>
                        <textarea name="txt_note" id="input" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-xs-12 text-right">
                        <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Add</button>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>

            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-family: 'Khmer OS Siemreap';">2-សកម្មភាពដាប់ថ្ម (*)/ Đục đá :</h3>

                  <div class="box-tools pull-right">
                                        <label>
                                          <input type="checkbox" class="minimal" checked>
                                          ថ្ងៃ (Ngày),
                                          <input type="checkbox" class="minimal">
                                          យប់ (Đêm)
                                        </label>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                                        <label><b>Report Note:</b> </label>
                        <textarea name="txt_note" id="input" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-xs-12 text-right">
                        <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Add</button>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>

            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-family: 'Khmer OS Siemreap';">3-សកម្មភាពប៉ូលា​​ / Polea :</h3>

                  <div class="box-tools pull-right">
                                        <label>
                                          <input type="checkbox" class="minimal" checked>
                                          ថ្ងៃ (Ngày),
                                          <input type="checkbox" class="minimal">
                                          យប់ (Đêm)
                                        </label>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                                        <label><b>Report Note:</b> </label>
                        <textarea name="txt_note" id="input" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-xs-12 text-right">
                        <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Add</button>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>

            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-family: 'Khmer OS Siemreap';">4-សកម្មភាពកាត់ខ្នាត (*)/Cắt quy cách :</h3>

                  <div class="box-tools pull-right">
                                        <label>
                                          <input type="checkbox" class="minimal" checked>
                                          ថ្ងៃ (Ngày),
                                          <input type="checkbox" class="minimal">
                                          យប់ (Đêm)
                                        </label>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                                        <label><b>Report Note:</b> </label>
                        <textarea name="txt_note" id="input" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-xs-12 text-right">
                        <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Add</button>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>

            <div class="col-md-6">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-family: 'Khmer OS Siemreap';">5-សកម្មភាពបាញ់ខ្សាច់ (*)/ Bắn cát :</h3>

                  <div class="box-tools pull-right">
                                        <label>
                                          <input type="checkbox" class="minimal" checked>
                                          ថ្ងៃ (Ngày),
                                          <input type="checkbox" class="minimal">
                                          យប់ (Đêm)
                                        </label>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                  <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                                        <label><b>Report Note:</b> </label>
                        <textarea name="txt_note" id="input" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-xs-12 text-right">
                        <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Add</button>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>


        </div>
    </div>
</div>



<?php include_once '../layout/footer.php' ?>
