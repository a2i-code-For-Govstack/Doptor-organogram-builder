<table class="table mt-2">
    <thead class="thead-light">
    <tr class="datatable-row" style="left: 0px; ">
        <th class="datatable-cell datatable-cell-sort">
            #
        </th>
        <th class="datatable-cell datatable-cell-sort">
            তারিখ
        </th>
        <th class="datatable-cell datatable-cell-sort">
            দেখুন
        </th>
    </tr>
    </thead>
    <tbody style="" class="datatable-body">
    @forelse($geo_location_logs as $log)
        @php
            $content = $log['content'];
        @endphp
        <tr id="row_{{$log['id']}}" class="datatable-row" style="left: 0px;">
            <td class="datatable-cell"><span>{{enTobn($loop->iteration)}}</span></td>

            <td class="datatable-cell">
                {{enTobn(date('Y/m/d H:i:s',strtotime($log['created_at'])))}}
                <br>
                আপডেট
                করেছেন: {{$log['modifier_name']}}
            </td>
            <td class="datatable-cell">
                <button title="Show Log"
                        class="btn btn-icon btn-square btn-sm btn-light btn-hover-icon-danger btn-icon-primary show_log"
                        data-log-table-id="log_table_{{$log['id']}}" onclick="showLogTable($(this))">
                    <i class="fa fa-eye"></i>
                </button>
            </td>
        </tr>
        <tr class="memo_log_row bg-white" id="log_table_{{$log['id']}}" style="display: none">
            <td colspan="3">
                <div class="memo_log_info">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="" style="left: 0px; ">
                            <th>
                                ফিল্ড
                            </th>
                            <th>
                                পুরাতন
                            </th>
                            <th>
                                নতুন
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($content as $key => $item)
                            <tr>
                                <td>
                                    {{$item['field']}}
                                </td>
                                <td>
                                    {{enTobn($item['old'])}}
                                </td>
                                <td>
                                    {{enTobn($item['new'])}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    @empty
        <tr data-row="0" class="datatable-row" style="left: 0px;">
            <td colspan="4" class="datatable-cell text-center"><span>তথ্য পাওয়া যায়নি।</span></td>
        </tr>
    @endforelse
    </tbody>
</table>

<script>
    function showLogTable(element) {
        log_table_id = element.data('log-table-id');
        $("#" + log_table_id).toggle();
    }
</script>
