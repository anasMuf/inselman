// spinner-navigation.js
(function($) {
    $.fn.spinnerNavigation = function() {
      this.each(function() {
        var spinner = $(this);
        var inputNumber = spinner.find(".input-number");

        spinner.find(".minus").click(function() {
          var currentValue = parseInt(inputNumber.val());
          if (currentValue > 1) {
            inputNumber.val(currentValue - 1);
          }
        });

        spinner.find(".plus").click(function() {
          var currentValue = parseInt(inputNumber.val());
          inputNumber.val(currentValue + 1);
        });
      });
      return this;
    };
  })(jQuery);
