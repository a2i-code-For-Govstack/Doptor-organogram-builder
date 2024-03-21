<select data-last='test' multiple="multiple" name="office_organogram_id[]" id="office_organogram_id" class="form-control rounded-0 select-select2">
    @foreach($organograms as $organogram)
        <option value="{{$organogram->id}}" >{{$organogram->designation_bng}}</option>
    @endforeach
</select>
