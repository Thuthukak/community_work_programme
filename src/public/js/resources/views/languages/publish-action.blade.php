<form id="publish-form" method="post" action="{{ route('language.translations.publish') }}" style="display: none">
    {{csrf_field()}}
    {{ method_field('post') }}
</form>
<a href="javascript:void(0)"
   class="btn btn-info float-right" onclick="
       event.preventDefault();
       document.getElementById('publish-form').submit();
    ">
    <i class="fa fa-paper-plane"></i>  {{ __('translation.publish') }}</i>
</a>
