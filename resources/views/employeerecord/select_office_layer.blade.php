<select name="office_layer_id" id="office_layer_id" class="form-control rounded-0" required>
    <option value="0">--বাছাই করুন--</option>
    @foreach($office_layers as $office_layer)
        <option value="{{$office_layer->id}}">{{$office_layer->layer_name_bng}}</option>
    @endforeach
</select>
