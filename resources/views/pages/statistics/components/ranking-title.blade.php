<h5 class="mb-3">@fa(['icon' => 'list-ul', 'title' => null])Top
<select name="limit" aria-label="Quantidade de resultados"
    class="form-control form-select rounded border-0 d-inline-block w-auto mx-1"
    style="font-size: inherit; line-height: 1.2;">
    @foreach([10, 20, 50, 100] as $option)
    <option value="{{$option}}" {{$option == ($limit ?? 10) ? 'selected' : ''}}>{{$option}}</option>
    @endforeach
</select>
{{$label}}</h5>
