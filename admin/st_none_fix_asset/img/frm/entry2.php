<input type="hidden" name="typeform" id="typeform" value="2">
<input type="hidden" name="last_id" value="0" id="last_id"> <!--last for Asset ID-->
<input type="hidden" name="isedit" value="0" id="isedit">
<input type="hidden" name="ass_id" value="0" id="ass_id">  <!--store when user edit data-->
<input type="hidden" name="cdt" id="cdt" value="" placeholder="h">
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
    <b>ASSIGN INFO</b>
</div>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6">
            <label for="colFormLabel" class="col-sm-4 col-form-label" style="color: black;">Assigned To</label>
            <select name="assign_to" class="" id="assign_to">
                
            </select>
        </div>

        <div class="col-lg-6">
            <label for="colFormLabel" class="col-sm-4 col-form-label" style="color: black;">Assign Date</label>
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                <input autocomplete="off" name="assign_date" value="" id="assign_date" type="text" class="form-control" placeholder="Date From ....">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<!-- list -->
<div class="row">
    <!-- <div class="table-responsive"> -->
        <table class="table table-bordered table-hover table-stripped" id="form2list">
            <tr><th>Date</th><th>Condition</th><th>Adjusment</th><th>Remark</th></tr>
        </table>
    <!-- </div> -->
</div>
<!-- end list -->