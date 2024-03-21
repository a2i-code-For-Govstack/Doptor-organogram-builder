<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
       <tr class="text-center">
            <th  class="" width="10%">কর্মকর্তার নাম</th>
            <th  class="" width="10%">মোবাইল নম্বর</th>
            <th class="" width="10%">আইপি (IP)</th>
            <th class="" width="10%">ব্রাউজার</th>
            <th class="" width="10%">ডিভাইস</th>
            <th class="" width="10%">ডিভাইস আইডি</th>
            <th class="" width="10%">লগইন সময়</th>
            <th class="no-sort" width="10%">লগআউট সময়</th>
            <th class="" width="10%">ইউজার এজেন্ট</th>
        </tr>
    </thead>
    <tbody>
        @foreach($histories as $key => $history)
        @php
            $network = json_decode($history->network_information, true);
        @endphp
        <tr class="text-center">
            <td>{{$history->employee_name}}</td>
            <td>{{$history->mobile_number}}</td>
            <td>{{$history->client_ip}}</td>
            <td>{{$network['Browser']}}</td>
            <td>{{$network['Device']}}</td>
            <td>{{$network['DeviceId']}}</td>
            <td>{{enTobn($history->login_time)}}</td>
            <td>{{enTobn($history->logout_time)}}</td>
            <td>{{$network['UserAgent']}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<script type="text/javascript">
    tapp_table_init();
    $(".table tbody").on('click','.view_modal',function () {
        var id = $(this).data("id");
        $.ajax({
            method: "GET",
            url: "get_office_designation/" + id,
            data: id,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                $("#modal_body").html(data);
                $("#editModal").modal("show");
            }
        });
    });
</script>
