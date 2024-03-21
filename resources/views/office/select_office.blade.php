<option value="0">--বাছাই করুন--</option>
@foreach($office_list as $office)
    <option data-office-name-en="{{$office['office_name_eng']}}" value="{{$office['id']}}">{{$office['office_name_bng']}}</option>
@endforeach
