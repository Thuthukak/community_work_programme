<ul class="breadcrumb hidden-print" style="display: flex;
    justify-content: flex-start;
    gap: 20px;
    align-items: center;
    margin: 20px;">
    <li>{{ link_to_route('subscriptions.index',__('subscription.list')) }}</li>
    <li>{{ $subscription->name_link }}</li>
    <li class="active">{{ isset($title) ? $title : __('subscription.detail') }}</li>
</ul>
