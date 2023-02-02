    <div class="p-2 d-flex justify-content-end align-items-center small">
      <div class="opacity-6 mr-2 fw-bold">@lang('views/footer.choose-locale'):</div>
      @form(['method' => 'PATCH', 'url' => route('locale.set', 'pt_BR'), 'classes' => 'px-1'])
      <button type="submit" class="btn-raw text-white no-stroke" style="font-weight: 400;">PT</button>
      @endform

      @form(['method' => 'PATCH', 'url' => route('locale.set', 'en'), 'classes' => 'px-1'])
      <button type="submit" class="btn-raw text-white no-stroke" style="font-weight: 400;">EN</button>
      @endform
    </div>