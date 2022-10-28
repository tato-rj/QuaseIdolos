<div class="table-container">
  @isset($header)
    @component('components.tables.header')
    {{$header}}
    @endcomponent
  @endisset
  
  {{$rows}}
</div>