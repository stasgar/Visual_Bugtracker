<div class="board-box {{isset($current_board)?($board->id == $current_board->id ? 'active-board' : 'text'):""}}">
    <div class="board-box-content">
        <div class="board-box-controls pull-right btn-group">
            <!--<button class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>-->
            @can('delete', $board)
                <a class="btn btn-danger delete-board btn-sm" href="{{route('project.delete_board', compact('board', 'project'))}}">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            @endcan
        </div>
        <div class="board-box-img">
            <img src="{{ $board->thumbnailImageUrl() }}" alt="Project image">
        </div>
        <h4 class="board-title board-box-title">{{ $board->name }}</h4>
        <div class="board-box-credentials">
            <span class="pull-right board-box-creator">
                <span class="text-muted"><em><small>@lang('projects.board_created_by')</small></em></span>
                <span><a href="{{route('user', ['user'=>$board->creator])}}"><span>@</span>{{ $board->creator->name }}</a></span>
                <img width="20px" src="{{ $board->creator->imageLink() }}" alt="profile image">
            </span>
        </div>
    </div>
    <div class="board-box-open-btn">
        <a class="btn btn-success" href="{{route('project.editor.board', ['project'=>$project, 'board'=>$board])}}">@lang('projects.open')</a>
    </div>
</div>
