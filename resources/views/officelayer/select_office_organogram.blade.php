<select multiple="multiple" name="office_unit_org_id[]" id="office_unit_org_id" class="form-control rounded-0">
    {{-- <option value="0">--বাছাই করুন--</option> --}}
    @foreach($office_organograms as $office_organogram)
        <option value="{{$office_organogram->id}}">{{$office_organogram->designation_bng}}</option>
    @endforeach
</select>
