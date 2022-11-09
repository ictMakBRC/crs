<div class="card ">
    <div class="card-body">
        <div class="row">
            <div class="mb-3 col-md-3">
                <label for="lab_no" class="form-label">lab no<span class="text-danger">*</span></label>
                <input type="text" id="lab_no" class="form-control" name="lab_no" required value="{{ old('lab_no', '') }}">
            </div>

            <div class="mb-3 col-md-3">
                <label for="date_recieved" class="form-label">Date recieved<span class="text-danger">*</span></label>
                <input type="date" id="date_recieved" class="form-control" name="date_recieved" required value="{{ old('date_recieved', '') }}">
            </div>

            <div class="mb-3 col-md-3">
                <label for="sample_type" class="form-label">Receipt no<span class="text-danger">*</span></label>
                <input type="text" id="receipt_no" class="form-control" name="receipt_no" required value="{{ old('receipt_no', '') }}">
            </div>

            <div class="mb-3 col-md-3">
                <label>Test arm<font color="red"><b>*</b></font></label>
                <select name="test_arm" id="test_arm" onchange="vaccinated()" class="form-control myselect" style="width: 100%;" required>
                  <option value="" selected disabled>Select option</option>
                <option value="X">X</option>
                <option value="Y">Y</option>
                </select>
              </div>


            <div class="mb-3 col-md-3">
                <label for="worksheet_no" class="form-label">Worksheet no<span class="text-danger">*</span></label>
                <input type="text" id="worksheet_no" class="form-control" name="worksheet_no" required value="{{ old('worksheet_no', '') }}">
            </div>

            <div class="mb-3 col-md-3">
                <label for="test_type" class="form-label">Test type<span class="text-danger">*</span></label>
                <input type="text" id="test_type" class="form-control" name="test_type" required value="{{ old('test_type', '') }}">
            </div>

            <div class="mb-3 col-md-3">
                <label for="test_kit" class="form-label">Test kit<span class="text-danger">*</span></label>
                <input type="text" id="test_kit" class="form-control" name="test_kit" required value="{{ old('test_kit', '') }}">
            </div>

            <div class="mb-3 col-md-3">
                <label for="ct_value" class="form-label">CT value<span class="text-danger">*</span></label>
                <input type="text" id="ct_value" class="form-control" name="ct_value" required value="{{ old('ct_value', '') }}">
            </div>

            <div class="mb-3 col-md-3">
                <label for="target1" class="form-label">Target 1<span class="text-danger">*</span></label>
                <input type="text" id="target2" class="form-control" name="target1" required value="{{ old('target1', '') }}">
            </div>
            <div class="mb-3 col-md-3">
                <label for="target2" class="form-label">Target 2<span class="text-danger">*</span></label>
                <input type="text" id="target2" class="form-control" name="target2" required value="{{ old('target2', '') }}">
            </div>
            <div class="mb-3 col-md-3">
                <label for="target3" class="form-label">Target 3<span class="text-danger">*</span></label>
                <input type="text" id="target3" class="form-control" name="target3" required value="{{ old('target3', '') }}">
            </div>

            <div class="mb-3 col-md-3">
                <label for="target2" class="form-label">Target 4<span class="text-danger">*</span></label>
                <input type="text" id="target4" class="form-control" name="target4" required value="{{ old('target4', '') }}">
            </div>


            <div class="mb-3 col-md-3">
                <label>Platform<font color="red"><b>*</b></font></label>
                <select name="platform" id="platform" class="form-control myselect" style="width: 100%;" required>
                  <option value="" selected disabled>Select option</option>
                <option value="X">Platform X</option>
                <option value="Y">Platform Y</option>
                </select>
              </div>

            <div class="mb-3 col-md-3">
                <label for="platform_range" class="form-label">Platform range<span class="text-danger">*</span></label>
                <input type="text" id="platform_range" class="form-control" name="platform_range" required value="{{ old('platform_range', '') }}">
            </div>

            <div class="mb-3 col-md-3">
                <label for="igg_result" class="form-label">IGG result<span class="text-danger">*</span></label>
                <input type="text" id="igg_result" class="form-control" name="igg_result" required value="{{ old('igg_result', '') }}">
            </div>

            <div class="mb-3 col-md-3">
                <label for="igm_result" class="form-label">IGM result<span class="text-danger">*</span></label>
                <input type="text" id="igm_result" class="form-control" name="igm_result" required value="{{ old('igm_result', '') }}">
            </div>

            <div class="mb-3 col-md-3">
                <label for="tat" class="form-label">TAT<span class="text-danger">*</span></label>
                <input type="text" id="tat" class="form-control" name="tat" required value="{{ old('tat', '') }}">
            </div>

            <div class="mb-3 col-md-3">
                <label for="comment" class="form-label">Comment<span class="text-danger">*</span></label>

                <textarea id="comment" class="form-control" name="comment">{{ old('comment', '') }}</textarea>
            </div>

         </div>
    </div>

</div>
