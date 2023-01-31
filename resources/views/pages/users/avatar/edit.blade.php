<div>
	<div class="form-group mb-3">
	  <div id="upload-box">
	    <input type="file" data-target="#image" data-placeholder="#placeholder" id="image-input" name="avatar" style="display:none;" />

	    <div class="position-relative image-container">

	    <div class="position-relative mx-auto" style="width: 200px">
	    	<div>
		    	@if($user->hasAvatar())
		    	<img class="w-100" id="image" src="{{$user->avatar()}}">
		    	@else
		    	<img class="w-100" id="image" style="display: none;">
		    	<div class="w-100" id="placeholder" style="height: 200px; background: rgba(0,0,0,0.2)"></div>
		    	@endif
		    </div>
	    	<div id="upload-button">
	    		<button type="button" class="text-white btn-raw rounded-circle d-center position-absolute-center opacity-8" style="width: 80px; height: 80px; z-index: 1; font-size: 1.8rem; background: rgba(0,0,0,0.2);">@fa(['icon' => 'camera', 'mr' => 0])
	    		</button>
	    	</div>
		  </div>
	      
	      <div class="controls d-flex justify-content-between mt-2">
	        <button type="button" id="confirm-button" style="display: none;" class="btn btn-sm btn-success">
	          <i class="fas fa-check-circle mr-2"></i>Confirmar
	        </button>

	        <button type="button" id="cancel-button" style="display: none;" class="btn btn-sm btn-danger">
	          <i class="fas fa-times-circle mr-2"></i>Cancelar
	        </button>
	      </div>
	    </div>
	  </div>
	</div>
</div>