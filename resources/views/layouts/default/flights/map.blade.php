<div class="row">
    <div class="col-md-12">
        <h3 class="description">map</h3>
    </div>
    <div class="col-12">
        <div class="box-body">
            <div id="map" style="width: 100%; height: 800px"></div>
        </div>
    </div>
</div>

@section('scripts')
<script type="text/javascript">
phpvms.render_route_map({
    route_points: {!! json_encode($map_features['route_points']) !!},
    planned_route_line: {!! json_encode($map_features['planned_route_line']); !!},
});
</script>
@endsection
