<!--Action Button-->
@if( Active::checkUriPattern( 'admin/loudhailers' ) )
    <a class="btn btn-primary btn-flat" href="{{ route( 'admin.loudhailers.create' ) }}" >{{ trans( 'menus.backend.loudhailers.create' ) }}</a>
@endif
<div class="clearfix"></div>
