
<!-- actions table -->
<div class="datatable mt-5 ml-3 mr-3">
    <div class="table-responsive">
        <table style="width: 100%;" id="actions-table">
            <thead>
                <tr style="border-bottom: 1px solid var(--default-border-color);">
                    <th class="datatable-th">Started At</th>
                    <th class="datatable-th">Priority</th>
                    <th class="datatable-th">Title</th>
                    <th class="datatable-th">Content</th>
                    <th class="datatable-th">Key result</th>
                    <th class="datatable-th">Model Type</th>
                    <th class="datatable-th">Finished At</th>
                    <th class="datatable-th">Person</th>
                </tr>
            </thead>
            <tbody>
                @foreach($actions as $action)
                <tr style="border-bottom: 1px solid var(--default-border-color);">
                    <td class="datatable-td">{{ $action->started_at }}</td>
                    <td class="datatable-td">
                        @php
                            $priorityMap = [
                                1 => ['label' => 'Immediate', 'class' => 'danger'],
                                2 => ['label' => 'Urgent', 'class' => 'warning'],
                                3 => ['label' => 'Normal', 'class' => 'info'],
                                4 => ['label' => 'Low', 'class' => 'success'],
                                5 => ['label' => 'Postponed', 'class' => 'dark'],
                            ];
                        @endphp
                        <span class="badge rounded-pill bg-{{ $priorityMap[$action->priority]['class'] ?? 'secondary' }} fixed-pill">
                            {{ $priorityMap[$action->priority]['label'] ?? 'Unknown' }}
                        </span>
                    </td>
                    <td class="datatable-td"><a href="{{ route('actions.showloneaction',$action->id) }}">{{ $action->title }}</a></td>
                    <td class="datatable-td">{{ $action->content }}</td>
                    <td class="datatable-td" style="word-wrap: break-word;
                    overflow-wrap: break-word;">{{ $action->keyResult->title ?? 'Unknown' }}</td>
                    <td class="datatable-td">{{ last(explode('\\', $action->model_type)) }}</td>
                    <td class="datatable-td">{{ $action->finished_at }}</td>
                    <td class="datatable-td">
                        <img src="storage/icon/green.png" style="width: 14px; height: 14px;" class="avatar-xs mr-2">
                        {{ $action->user->first_name ?? 'Unknown' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
