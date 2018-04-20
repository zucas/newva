<div id="ranks_table_wrapper">
    <table class="table table-hover table-responsive">
        <thead>
        <th>Name</th>
        <th>Hours</th>
        <th class="text-center">Auto Approve Acars</th>
        <th class="text-center">Auto Approve Manual</th>
        <th class="text-center">Auto Promote</th>
        <th></th>
        </thead>
        <tbody>
        @foreach($ranks as $rank)
            <tr>
                <td><a href="{!! route('admin.ranks.edit', [$rank->id]) !!}">{!! $rank->name !!}</a></td>
                <td>{!! $rank->hours !!}</td>
                <td class="text-center">
                    @if($rank->auto_approve_acars == 1)
                        <span class="label label-success">Yes</span>
                    @else
                        <span class="label label-default">No</span>
                    @endif
                </td>
                <td class="text-center">
                    @if($rank->auto_approve_manual == 1)
                        <span class="label label-success">Yes</span>
                    @else
                        <span class="label label-default">No</span>
                    @endif
                </td>
                <td class="text-center">
                    @if($rank->auto_promote == 1)
                        <span class="label label-success">Yes</span>
                    @else
                        <span class="label label-default">No</span>
                    @endif
                </td>
                <td class="text-right">
                    {!! Form::open(['route' => ['admin.ranks.destroy', $rank->id], 'method' => 'delete']) !!}
                    <a href="{!! route('admin.ranks.edit', [$rank->id]) !!}" class='btn btn-sm btn-success btn-icon'>
                        <i class="fas fa-pencil-alt"></i></a>
                    {!! Form::button('<i class="fa fa-times"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger btn-icon', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
