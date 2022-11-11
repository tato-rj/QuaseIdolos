<div class="offcanvas-header">
  <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
  <button type="button" class="btn-close btn-raw" style="width: 40px; height: 40px;" data-bs-dismiss="offcanvas" aria-label="Close">
    @fa(['icon' => 'times', 'fa_size' => '2x', 'mr' => 0])
  </button>
</div>

<div class="d-flex flex-column h-100 justify-content-between">
  <div class="px-4">
    <div>
      @include('layouts.menu.guest.links')
    </div>
  </div>

  <div class="d-center pb-4">
    @include('components.social')
  </div>
</div>