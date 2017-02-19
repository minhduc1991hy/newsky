<div class="row">
	<div class="col-md-3">
		<legend class="scheduler-border"><span class="text-primary">Cưa MDF</span></legend>
		<div class="form-group">
			<label for="PlanDate_Cua">Ngày cưa MDF</label>
			<input type="date" class="form-control" id="PlanDate_Cua" name="PlanDate_Cua" value="2017-02-19" onchange="ChangeMode()" required="">
		</div>
		<div class="form-group">
			<label for="Qty_Cua">Số lượng cưa MDF</label>
			<input type="text" class="form-control" id="Qty_Cua" name="Qty_Cua" placeholder="Số lượng tính theo tấm" onchange="CalQty()" required="">
		</div>
		<div id="Machine" class="form-group">
			 <label for="Machine_Cua">Máy cưa nhỏ</label>
			 <select class="form-control" id="Machine_Cua" name="Machine_Cua" onchange="ChangeMode()">
				
								<option value="MAY CUA VI TINH">MAY CUA VI TINH</option>
					 
			 </select>
		</div>
	</div>
	<div class="col-md-3">
		<legend class="scheduler-border"><span class="text-primary">Cưa MDF</span></legend>
	</div>
	<div class="col-md-3">
		<legend class="scheduler-border"><span class="text-primary">Cưa MDF</span></legend>
	</div>
	<div class="col-md-3">
		<legend class="scheduler-border"><span class="text-primary">Cưa MDF</span></legend>
	</div>
</div>