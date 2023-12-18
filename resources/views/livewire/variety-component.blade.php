<div class="row">
    <div class="col-md-12">
        @can('haveaccess', 'variety.create')
            @include("variety.$view")
        @endcan
    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-12">
        @can('haveaccess', 'variety.index')
            @include('variety.table')
        @endcan
    </div>
</div>
