(function ($, Drupal) {
//  alert("working");
    $(document).ready(function() {
      // Get references to the checkbox fields
      var checkbox = $('#no-last-name');
      var lastname = $('.js-form-item-last-name');

      if (checkbox.is(':checked')) {
        lastname.hide();
      }
      checkbox.on('change', function() {
        if ($(this).is(':checked')) {
          lastname.hide();
        } else {

          lastname.show();
        }
      });
    });

}(jQuery, Drupal));



