<div class="row">
    <div class="col-md-12">
        @can('haveaccess', 'farm.create')
            @include("farm.$view")
        @endcan
    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-12">
        @can('haveaccess', 'farm.index')
            @include('farm.table')
        @endcan
    </div>
</div>
