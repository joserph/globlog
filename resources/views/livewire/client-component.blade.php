<div class="row">
    <div class="col-md-12">
        @can('haveaccess', 'client.create')
            @include("client.$view")
        @endcan
    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-12">
        @can('haveaccess', 'client.index')
            @include('client.table')
        @endcan
    </div>
</div>
