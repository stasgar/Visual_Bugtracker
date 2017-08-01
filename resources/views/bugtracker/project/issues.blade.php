@extends('layouts.project')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/bugtracker/issue.css') }}" />
@endsection

@section('scripts')
<script src="{{ asset('js/bugtracker/issues.js') }}"></script>
@endsection

@section('project-content')

{!! Breadcrumbs::render('issues', $project) !!}
    <div class="issue-controls pull-right">
        @if(!app('request')->input('closed_visible'))
        <a class="btn btn-success" href="{{ route('project.issues', ['project' => $project, 'closed_visible'=>true]) }}"><span class="glyphicon glyphicon-eye-open"></span> Show closed</a>
        @else
        <a class="btn btn-danger" href="{{ route('project.issues', ['project' => $project, 'closed_visible'=>false]) }}"><span class="glyphicon glyphicon-eye-close"></span> Hide closed</a>
        @endif
    </div>
@if(!$issues->isEmpty())


    <div class="issues-block">
        @include('bugtracker.project.partials.issues-block')
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#create-issue-modal">@lang('projects.issue_create')</button>
    </div>
@else
    <div class="alert alert-info">There is no issues yet, add one!</div>
@endif

<div>
    {!! View::make('bugtracker.project.partials.issue_create_modal', ['project'=>$project])->render() !!}
</div>


@endsection
