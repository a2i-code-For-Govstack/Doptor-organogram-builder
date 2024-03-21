<table class="table table-bordered table-striped thead-light">
    <thead>
    <tr>
        <th>ক্রম</th>
        <th>প্রতিকল্পকারি ব্যক্তি</th>
        <th>প্রতিকল্পকৃত ব্যক্তি</th>
        <th>প্রতিকল্প শুরু</th>
        <th>প্রতিকল্প শেষ</th>
    </tr>
    </thead>
    <tbody>
    @foreach($protikolpo_logs as $key => $protikolpo)
        @php
            $protikolpo_start_date = $protikolpo->protikolpo_start_date ? date('Y-m-d', strtotime($protikolpo->protikolpo_start_date)) : 'তারিখ জানা যায়নি';
            $protikolpo_end_date = $protikolpo->protikolpo_end_date ? date('Y-m-d', strtotime($protikolpo->protikolpo_end_date)) : 'চলমান';
        @endphp
        <tr>
            <td>{{ enTobn($loop->iteration) }}</td>
            <td>{{ $protikolpo->employee_office_id_from_name }}</td>
            <td>{{ $protikolpo->employee_office_id_to_name }}</td>
            <td>{{ enTobn($protikolpo_start_date) }}</td>
            <td>{{ enTobn($protikolpo_end_date) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
