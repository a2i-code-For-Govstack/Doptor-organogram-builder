<div class="card custom-card round-0 shadow-sm">
    <div class="card-header">
        <h4>বর্তমান পদবি</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered custom-table-border">
                <thead class="table-head-color">
                    <tr>
                        <th>অফিস</th>
                        <th>শাখা</th>
                        <th>পদবি</th>
                        <th>শেষ কার্যদিবস</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $employee_office_info->office_name_bn }}</td>
                        <td>{{ $employee_office_info->office_unit->unit_name_bng }}</td>
                        <td>{{ $employee_office_info->designation }}</td>
                        <td>
                            @if (Auth::user()->current_office_id() == $employee_office_info->office_id)
                                <div class="input-group">
                                    <input class="form-control rounded-0 date" type="text" name="last_office_date"
                                        placeholder="দিন-মাস-বছর" aria-label="Recipient's"
                                        id="last_office_date_{{ $employee_office_info->id }}">
                                    <div class="input-group-append rounded-0">
                                        <button id="disable_designation"
                                            data-employee_record_id="{{ $employee_office_info->employee_record_id }}"
                                            data-office_id="{{ $employee_office_info->id }}" type="button"
                                            class="btn  btn-outline-danger btn-icon disable_designation">
                                            <i class="fas fa-trash-alt" style="color: red"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
