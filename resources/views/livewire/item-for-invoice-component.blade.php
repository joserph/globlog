<div class="row">
    <div class="col-md-12">
        @can('haveaccess', 'itemforinvoice.create')
            @include("itemforinvoice.$view")
        @endcan
    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-12">
        @can('haveaccess', 'itemforinvoice.index')
            @include('itemforinvoice.table')
        @endcan
    </div>
</div>