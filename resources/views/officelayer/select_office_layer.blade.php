<select name="parent_layer_id" id="parent_layer_id" class="form-control rounded-0">
    <option value="0">--বাছাই করুন--</option>
    @foreach($office_layers as $office_layer)
        <option value="{{$office_layer->id}}">@if($office_layer->parent) {{$office_layer->parent->layer_name_bng}} -> @endif {{$office_layer->layer_name_bng}}</option>
    @endforeach
</select>
