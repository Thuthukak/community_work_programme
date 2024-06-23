@extends('layouts.crm')

@section('title', __('project.files').' | '.$project->name)

@section('contents')
@include('crm.projects.partials.breadcrumb',['title' => __('project.files')])

<h4 class="page-header-pill-layouts" style="justify-content:flex-start;
    align-items: center;
    padding: 0.5rem 0.5rem;
    border-radius: 9999px; 
    background-color: white;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    padding:10px;
    display:inline-block;
    margin:20px;width:content;">
    {{ $project->name }} 
</h4>

@include('crm.projects.partials.nav-tabs')
<div class="row">
    <div class="col-md-7" style="margin-top:10px">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" style="margin-left:20px">{{ __('project.files') }}</h3>
            </div>
            <div class="panel-body table-responsive" style="margin-left:20px">
                <table class="table table-condensed" style="background: white;
    padding:2px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    padding-bottom: 50px;">
                    <thead>
                        <th>{{ __('app.table_no') }}</th>
                        <th>{{ __('file.file') }}</th>
                        <th class="text-center">{{ __('file.updated_at') }}</th>
                        <th class="text-right">{{ __('file.size') }}</th>
                        <th class="text-center">{{ __('file.download') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </thead>
                    <tbody class="sort-files">
                        @forelse($files as $key => $file)
                        <tr id="{{ $file->id }}">
                            <td>{{ 1 + $key }}</td>
                            <td>
                                <strong class="">{{ $file->title }}</strong>
                                <div class="text-info small">{{ $file->description }}</div>
                            </td>
                            <td class="text-center">
                                <div class="">{{ $file->getDate() }}</div>
                                <div class="text-info small">{{ $file->getTime() }}</div>
                            </td>
                            <td class="text-right">{{ format_size_units($file->getSize()) }}</td>
                            <td class="text-center">
                                {!! html_link_to_route('files.download', '', [$file->id], ['icon' => 'file', 'title' => __('file.download')]) !!}
                            </td>
                            <td class="text-center">
                                {!! html_link_to_route('projects.files', '', [$project, 'action' => 'edit', 'id' => $file->id], ['icon' => 'edit', 'title' => __('file.edit')]) !!}
                                {!! html_link_to_route('projects.files', '', [$project, 'action' => 'delete', 'id' => $file->id], ['icon' => 'remove', 'title' => __('file.delete'), 'id' => 'delete-file-'.$file->id]) !!}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6">{{ __('file.empty') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        @if (Request::has('action') == false)
        <div class="panel panel-default" style="margin-top:10px">
            <div class="panel-heading"><h3 class="panel-title">{{ __('file.create') }}</h3></div>
            <div class="panel-body">
                {!! Form::open(['route' => ['files.upload', $project->id], 'id' => 'upload-file', 'files' => true]) !!}
                {{ Form::hidden('fileable_type', get_class($project)) }}
                {!! FormField::file('file', ['label' => __('file.select')], ['class'=> 'custom-formfield']) !!}
                {!! FormField::text('title', ['class'=> 'custom-formfield']) !!}
                {!! FormField::textarea('description', ['class'=> 'custom-formfield']) !!}
                {!! Form::submit(__('file.upload'), ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        @endif
        @if (Request::get('action') == 'edit' && $editableFile)
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('file.edit') }} : {{ $editableFile->title }}</h3></div>
            <div class="panel-body">
                {!! Form::model($editableFile, ['route' => ['files.update', $editableFile->id], 'method' => 'patch']) !!}
                {!! FormField::text('title', ['label' => __('file.title'), 'required' => true]) !!}
                {!! FormField::textarea('description', ['label' => __('file.description')]) !!}
                {!! Form::submit(__('file.update'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('projects.files', __('app.cancel'), [$project->id], ['class' => 'btn btn-default']) }}
                {!! Form::close() !!}
            </div>
        </div>
        @endif
        @if (Request::get('action') == 'delete' && $editableFile)
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('file.delete') }} : {{ $editableFile->title }}</h3></div>
            <div class="panel-body">{{ __('file.delete_confirm') }}</div>
            <div class="panel-footer">
                {!! FormField::delete(
                    ['route' => ['files.destroy', $editableFile->id]],
                    __('app.delete_confirm_button'),
                    ['class' => 'btn btn-danger'],
                    ['file_id' => $editableFile->id, ]
                ) !!}
                {{ link_to_route('projects.files', __('app.cancel'), $project, ['class' => 'btn btn-default']) }}
            </div>
        </div>
        @endif
    </div>
</div>


@endsection
