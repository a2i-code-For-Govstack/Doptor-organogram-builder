<form class="form" id="menuassignform">
    <div class="card-body">
        <div class="checkbox-list">
            @if($parentMenus)
                <div class="form-group">
                    <label>মেনু সমুহ:</label>
                    <br/>
                    {!! loadMenuForRole($parentMenus) !!}
                </div>
        </div>
        @endif
    </div>
    <div class="card-footer">
        <button type="button" id="assignMenuInRole" class="btn btn-primary mr-2">প্রদান করুন</button>
    </div>
</form>
<script>
    menumap = JSON.parse("{{json_encode($roleMenuMap)}}")
    editLoad(menumap)
</script>
