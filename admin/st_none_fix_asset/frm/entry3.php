<input type="hidden" name="typeform" id="typeform" value="3">
<input type="hidden" name="last_id" value="0" id="last_id">
<input type="hidden" name="isedit" value="0" id="isedit">   <!-- 1= edit; 0= new -->
<input type="hidden" name="adj_id" value="0" id="adj_id">  <!--- store adj id when click list for edit-->
<input type="hidden" name="ass_id" value="0" id="ass_id">  <!--store when user edit data-->
<input type="hidden" name="cdt" id="cdt" value="" placeholder="h">  <!-- store condition from page 1 -->
<div class="row">
    <div class="col-lg-6">
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label" style="color: black;">Description</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="des1" placeholder="">
            </div>
        </div>
    
        <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label" style="color: black;">Cost</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="cost" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label" style="color: black;">Acquired Date</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="acq" placeholder="">
            </div>
        </div>
    </div>
    <!-- end genernal information -->

    <!-- general information -->

    <!-- location information -->
    <div class="col-lg-6">
        <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label" style="color: black;">Model</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="model" placeholder="">
            </div>
        </div>
    
        <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label" style="color: black;">Serial#</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="serial" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label" style="color: black;">Section</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="section" placeholder="">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <b style="color: blue; text-decoration: underline;">WRITTEN OFF INFO</b>
</div>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6">
            <label for="colFormLabel" class="col-sm-4 col-form-label" style="color: black;">Written off</label>
            <select name="adj" id="adj">
                <option value="It is very old">Broken</option>
                <option value="Not see">Loss</option>
            </select>
        </div>

        <div class="col-lg-6">
            <label for="colFormLabel" class="col-sm-4 col-form-label" style="color: black;">Remark</label>
            <input type="text" name="remark" id="remark" class="form-control" placeholder="">
        </div>
    </div>
</div>
<br>
<div class="row" style="text-align: center;">
    <b style="color: blue; text-decoration: underline; font-size: 14px;">Transaction</b>
</div>
<!-- list -->
<div class="row">
    <!-- <div class="table-responsive"> -->
        <table class="table table-bordered table-hover table-stripped" id="form2list">
            <tr><th>Date</th><th>Condition</th><th>Adjusment</th><th>Remark</th></tr>
                
        </table>
    <!-- </div> -->
</div>
<!-- end list -->