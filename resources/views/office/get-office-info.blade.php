@if($office_info)

<div class="col-md-6">
	<div class="card custom-card round-0 shadow-sm">
		<div class="card-header">
			<h4>অফিসের তথ্য</h4>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<td>নাম </td>
						<td>{{$office_info->name_bng}}</td>
					</tr>
					<tr>
						<td>ডিজিটাল নথি কোড</td>
						<td>{{ enTobn($office_info->digital_nothi_code) }}</td>
					</tr>
					<tr>
						<td>ইমেল:</td>
						<td>{{$office_info->office_email}}</td>
					</tr>
					<tr>
						<td>ফোন:</td>
						<td>{{ enTobn($office_info->office_phone) }}</td>
					</tr>
					<tr>
						<td>অবস্থা</td>
						<td>{{$office_info->active_status ? 'সক্রিয়' : 'নিষ্ক্রিয়'}}</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="col-md-6">
	<div class="card custom-card round-0 shadow-sm">
		<div class="card-header">
			<h4>অন্যান্য তথ্য</h4>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<td>মোট শাখা</td>
						<td>মোট পদবি</td>
						<td>ব্যবহারকারী নিযুক্ত পদবি</td>
						
					</tr>
					<tr>
						<td>{{ enTobn($office_info->office_units()->count()) }}</td>
						<td>{{ enTobn($office_info->office_unit_organograms()->count()) }}</td>
						<td>{{ enTobn($office_info->assigned_employees()->count()) }}</td>
					</tr>
				</table>
				<table class="table table-bordered">
					<tr>
						<td>অফিস প্রধান</td>
						@php($office_head = $office_info->office_unit_organograms()->where('is_office_head', 1)->first())
						<td>{!! $office_head ? ($office_head->assigned_user && $office_head->assigned_user->user ? "<b>ইউজার নেমঃ </b>".@$office_head->assigned_user->user->username." <br>" : "[ইউজার তথ্য পাওয়া যায় নাই] <br>") . ($office_head->assigned_user->employee_record ? "<b>ব্যবহারকারী নামঃ </b>" . $office_head->assigned_user->employee_record->name_bng."<br>" : "") . "<b>পদবিঃ </b>" . $office_head['designation_bng'] . '<br>' . "<b>শাখাঃ </b>" . $office_head->office_unit['unit_name_bng'] : 'অফিস প্রধান নির্বাচন করা হয় নাই' !!}</td>
					</tr>
					<tr>
						<td>অফিস এডমিন</td>
						@php($office_admin = $office_info->office_unit_organograms()->where('is_admin', 1)->first())
						<td>{!! $office_admin ? ($office_admin->assigned_user && $office_admin->assigned_user->user ? "<b>ইউজার নেমঃ </b>".@$office_admin->assigned_user->user->username." <br>" : "[ইউজার তথ্য পাওয়া যায় নাই] <br>") . ($office_admin->assigned_user->employee_record ? "<b>ব্যবহারকারী নামঃ </b>" . $office_admin->assigned_user->employee_record->name_bng."<br>" : "") . "<b>পদবিঃ </b>" . $office_admin['designation_bng'] . '<br>' . "<b>শাখাঃ </b>" . $office_admin->office_unit['unit_name_bng'] : 'অফিস এডমিন নির্বাচন করা হয় নাই' !!}</td>
					</tr>
					<tr>
						<td>অফিস ফ্রন্টডেস্ক</td>
						@php($office_front_desk = $office_info->office_front_desk)
						<td>{!! $office_front_desk ? ($office_front_desk->user ? "<b>ইউজার নেমঃ </b>".@$office_front_desk->user->username." <br>" : "[ইউজার তথ্য পাওয়া যায় নাই] <br>") . "<b>ব্যবহারকারী নামঃ </b>" . $office_front_desk['officer_name'] . '<br>' . "<b>পদবিঃ </b>" . $office_front_desk['designation_label'] . '<br>' . "<b>শাখাঃ </b>" . $office_front_desk['office_unit_name'] : 'অফিস ফ্রন্টডেস্ক নির্বাচন করা হয় নাই' !!}</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>

@else
<div class="col-md-6">
	<div class="card custom-card round-0 shadow-sm">
		<div class="card-body">
			<h4>কোন তথ্য পাওয়া যায়নি</h4>
		</div>
	</div>
</div>
@endif
<script type="text/javascript">
	function changeToCadre(form, url) {
		var data = $(form).serialize();
		var datatype = 'json';
		ajaxCallAsyncCallback(url, data, datatype, 'POST', function(responseDate) {
			if (responseDate.status === 'success') {
				toastr.success(responseDate.msg);
				// $('#cadre_id').text(responseData.identity_no);
				$('#username').val(responseDate.username);
				$('#search').trigger('click');
			} else {
				toastr.error(responseDate.msg);
			}
		});
	}

	function changeToNonCadre(form, url) {
		var data = $(form).serialize();
		var datatype = 'json';
		ajaxCallAsyncCallback(url, data, datatype, 'POST', function(responseDate) {
			if (responseDate.status === 'success') {
				toastr.success(responseDate.msg);
				$('#username').val(responseDate.username);
				$('#search').trigger('click');
			} else {
				toastr.error(responseDate.msg);
			}
		});
	}
</script>