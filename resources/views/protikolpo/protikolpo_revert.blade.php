@extends('master')
@section('content')
    <div class="modal fade modal-purple height-auto" id="protikolpoSetting" role="dialog" aria-hidden="true"
         data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">প্রতিকল্প ব্যবস্থাপনা</h3>
                    @if ($is_logout_button)
                        <a style="color: #fff"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                           class="btn btn-danger btn-sm pull-left"><i class="fas fa-sign-out-alt"></i> লগ আউট</a>
                    @else
                        <button type="button" data-dismiss="modal" aria-hidden="true">×</button>
                    @endif

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4><b><?= $protikolpo_list['user_name'] ?></b> আপনার পদসমূহ</h4>
                            <table class="table table-bordered custom-table-border">
                                <thead class="table-head-color">
                                <tr>
                                    <th>ক্রম</th>
                                    <th>পদের নাম</th>
                                    <th>প্রতিকল্প অবস্থা</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($protikolpo_list['data'] as $key => $protikolpo): ?>
                                <tr>
                                    <td><?=enTobn($key + 1)?></td>
                                    <td><?=$protikolpo['protikolpo']['office_unit_organogram_name']?></td>
                                    <td>
                                        <?=$protikolpo['protikolpo']['employee_name']?>,
                                        <?=$protikolpo['protikolpo']['office_unit_name']?>,
                                        <?=$protikolpo['protikolpo']['office_name']?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            প্রতিকল্প কার্যকরঃ
                            <?=enTobn(date('m-d-Y', strtotime($protikolpo_list['data'][0]['start_date']))) ?> থেকে
                            <?=enTobn(date('m-d-Y', strtotime($protikolpo_list['data'][0]['end_date']))) ?>
                            <input type="hidden" name="employee_record_id"
                                   value="<?=$protikolpo_list['employee_record_id']?>"/>
                            <hr/>
                            <fieldset style="    border: solid 1px #582071;padding: 10px">
                                <legend
                                    style="width: auto !important;padding: 5px 10px;border: solid 1px #582071;margin-bottom: 5px;color: #000;">
                                    প্রতিকল্প ব্যবস্থাপনা পরিবর্তন
                                </legend>
                                <div class="row">
                                    <div class="col-md-4">প্রতিকল্প শেষ তারিখ</div>
                                    <div class="col-md-4"><input type="text" name="protikolpo_end_date"
                                                                 class="form-control date-picker date"
                                                                 value="<?=date('d-m-Y',strtotime($protikolpo_list['data'][0]['end_date']))?>"
                                                                 data-date-start-date="+0d"/></div>
                                    <div class="col-md-4">
                                        <button onclick="changeProtikolpoEndDate(this)" class="btn btn-info"><i
                                                class="fa fa-cog"></i> পরিবর্তন করুন
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                            <hr/>
                            <div class="text-center">
                                <button class="btn btn-danger" onclick="stopProtikolpo(this)"><i
                                        class="fa fa-trash"></i> প্রতিকল্প স্থগিত
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $("#protikolpoSetting").modal('show');
        });

        function changeProtikolpoEndDate(element) {
            $(element).html('<i class="fa fa-cog fa-spin"></i> হালনাগাদ হচ্ছে...');
            $(element).addClass('disabled');
            if ($("input[name=protikolpo_end_date]").val() == '') {
                toastr.error('দয়া করে প্রতিকল্পের শেষ তারিখ নির্বাচন করুন');
                return false;
            }
            var endDate = $("input[name=protikolpo_end_date]").val();
            var employeeRecordId = $("input[name=employee_record_id]").val();
            $.ajax({
                type: 'POST',
                url: '{{url('update_protikolpo_by_user')}}',
                data: {"end_date": endDate, 'employee_record_id': employeeRecordId},
                async: true,
                success: function (response) {
                    if (response.status == 'success') {
                        toastr.success(response.msg);
                        $(element).html('<i class="fa fa-cog"></i> পরিবর্তন করুন');
                        $(element).removeClass('disabled');
                        window.location.reload();
                    } else {
                        toastr.error(response.msg);
                        $(element).html('<i class="fa fa-cog"></i> পরিবর্তন করুন');
                        $(element).removeClass('disabled');
                    }
                }
            });
        }

        function stopProtikolpo(element) {
            $(element).html('<i class="fa fa-cog fa-spin"></i> প্রতিকল্প হালনাগাদ হচ্ছে...');
            $(element).addClass('disabled');
            toastr.success('প্রতিকল্প হালনাগাদ হচ্ছে...');
            var employeeRecordId = $("input[name=employee_record_id]").val();
            $.ajax({
                type: 'POST',
                url: '{{url('cancel_protikolpo_by_user')}}',
                data: {'employee_record_id': employeeRecordId},
                async: true,
                success: function (response) {
                    if (response.status == 'success') {
                        window.location.href = 'login';
                    }
                }
            });
        }
    </script>
@endsection
