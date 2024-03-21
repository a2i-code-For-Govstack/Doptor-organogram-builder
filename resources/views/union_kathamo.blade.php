@extends('master')
@section('content')
 
    <div class="sna-subheader py-2 py-lg-6 subheader-solid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap" id="kt_subheader">

        <div class="ml-3"></div>
        <div>
            <h3 class="text-white my-1">প্রশাসনিক বিভাগ থেকে ইউনিয়ন</h3>
        </div>
        <div class="mr-3 d-flex"></div>
    </div>
    <!--end::Subheader-->
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-3">
        <!--Begin::Dashboard 1-->

        <!--Begin::Row-->
        <div class="row">
            <div class="col-md-6">
                <div class="card custom-card round-0 shadow-sm">
                    <div class="card-body">
                        <div id="kt_tree_2" class="tree-demo kt_tree_23">
                            {!! loadTree($results, 'zila_kathamo->upozila_kathamo->union_kathamo') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--End::Row-->

        <!--Begin::Row-->
        <div class="row">
        </div>

        <!--End::Row-->

        <!--End::Dashboard 1-->
    </div>
    <!--end::Global Theme Bundle -->


@endsection

<script>

$( document ).ready(function() {
    $(".kt_tree_23").jstree("open_all");
});

</script>