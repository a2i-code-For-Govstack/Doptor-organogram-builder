<table class="table table-striped- table-bordered table-hover table-checkable tapp_table custom-table-border">
    <thead class="table-head-color">
     <tr class="text-center">
            <th>ক্রমিক সংখ্যা</th>
            <th>অফিসের নাম (বাংলা)</th>
            <th>অফিসের নাম (ইংরেজি)</th>
            <!-- <th>কার্যক্রম</th> -->
        </tr>
        </thead>
        <tbody>
        @foreach($offices as $office)
            <tr class="text-center">
                <td>{{$loop->iteration}}</td>
                <td>{{$office->office_name_bng}}</td>
                <td>{{$office->office_name_eng}}</td>

               <!--  <td>
                    <button type="button"
                            data-content="{{$office->id}},{{$office->office_name_bng}}"
                            data-dismiss="modal"
                            class="btn btn-warning btn-icon btn-square btntableDataEdit"><i
                            class="fas fa-pencil-alt"></i></button>
                </td> -->
            </tr>
        @endforeach
        </tbody>
    </table>
<script type="text/javascript">
    tapp_table_init();
</script>
