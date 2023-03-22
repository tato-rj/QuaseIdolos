jQuery.fn.autoDestructIn = function(seconds, speed = 'fast') {
    let $element = $(this);
    setTimeout(function() {
        $element.fadeDelete(speed);
    }, seconds * 1000);
};

jQuery.fn.visible = function() {
    return this.css('visibility', 'visible');
};

jQuery.fn.invisible = function() {
    return this.css('visibility', 'hidden');
};

jQuery.fn.toggleVisibility = function() {
    return this.css('visibility', function(i, visibility) {
        return (visibility == 'visible') ? 'hidden' : 'visible';
    });
};

jQuery.fn.fadeDelete = function(speed = '') {
    return this.fadeOut(speed, function() {
        $(this).remove();
    });
};

jQuery.fn.hex = function(property) {
    let parts = this.css(property).match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

    delete(parts[0]);
    
    for (var i = 1; i <= 3; ++i) {
        parts[i] = parseInt(parts[i]).toString(16);
        if (parts[i].length == 1) parts[i] = '0' + parts[i];
    }

    return '#' + parts.join('');
};

jQuery(function($) {

  var _oldShow = $.fn.show;

  $.fn.show = function(speed, oldCallback) {
    return $(this).each(function() {
      var obj         = $(this),
          newCallback = function() {
            if ($.isFunction(oldCallback)) {
              oldCallback.apply(obj);
            }
            obj.trigger('afterShow');
          };

      // you can trigger a before show if you want
      obj.trigger('beforeShow');

      // now use the old function to show the element passing the new callback
      _oldShow.apply(obj, [speed, newCallback]);
    });
  }
});
