<input type="hidden" id="dataTable" value="{{$data}}">
@if(count($results))
    <div style="width:50%">
        <input placeholder="অনুসন্ধান" class="tree_search21 form-control" type="text" value="">
    </div>
@endif
<div class="tree-demo kt_tree_24">
    {!! loadTree($results,'child->child->child->child->child->child->child', true) !!}
</div>
