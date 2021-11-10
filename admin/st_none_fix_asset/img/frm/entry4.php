<input type="hidden" name="typeform" id="typeform" value="4">
<input type="hidden" name="last_id" value="0" id="last_id">
<input type="hidden" name="isedit" value="0" id="isedit">
<input type="hidden" name="ass_id" value="0" id="ass_id">  <!--store when user edit data-->
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
<br>
<!-- list -->
<div class="row">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-stripped" id="form2list">
            <tr>
                <th>Assign Date</th>
                <th>Condition</th>
                <th>Assigned To</th>
                <th>Position</th>
                <th>Adjusment</th>
            </tr>
        </table>
    </div>
</div>
<!-- end list -->