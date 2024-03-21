<div class="table-responsive">
    <table class="table table-bordered text-center">
        <thead>
        <tr>
            <th>ক্রম</th>
            <th>মুল স্তরের নাম</th>
            <th>কাস্টম স্তর</th>
           <th>কার্যক্রম</th>
        </tr>
        </thead>
        <tbody>
        @foreach($office_layers as $layer)
            <tr>
                <td>{{enTobn($loop->iteration)}}</td>
                <td>{{$layer->layer_name_bng}}</td>
                <td>{{@$layer->custom_layer->name}}</td>

               <td>
                   <button type="button"
                           data-id="{{$layer->id}}"
                           data-content="{{$layer->layer_name_bng}}"
                           data-dismiss="modal"
                           class="btn btn-warning btn-icon btn-square btntableDataEdit"><i
                           class="fas fa-pencil-alt"></i></button>
               </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
