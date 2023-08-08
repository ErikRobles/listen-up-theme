jQuery(document).ready(function ($) {
  $("#menu-main-menu").slicknav();
  // Apply the SlickNav background color from the customizer setting
  var slicknavBgColor = wp.customize("slicknav_bg_color").get();
  $(".mobile-menu").css("background-color", slicknavBgColor);
  // Update the SlickNav background color when the customizer setting is changed
  wp.customize("slicknav_bg_color", function (value) {
    value.bind(function (newVal) {
      $(".mobile-menu").css("background-color", newVal);
    });
  });
});
