 <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.1.3.min.js"></script>
        <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="assets/plugins/pace-master/pace.min.js"></script>

        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>

        <script src="assets/plugins/switchery/switchery.min.js"></script>
        <script src="assets/plugins/uniform/jquery.uniform.min.js"></script>
        <script src="assets/plugins/offcanvasmenueffects/js/classie.js"></script>
        <script src="assets/plugins/offcanvasmenueffects/js/main.js"></script>

        <script src="assets/plugins/waves/waves.min.js"></script>
        <script src="assets/plugins/3d-bold-navigation/js/main.js"></script>
        <script src="assets/plugins/jquery-mockjax-master/jquery.mockjax.js"></script>

        <script src="assets/plugins/moment/moment.js"></script>
        <script src="assets/plugins/datatables/js/jquery.datatables.min.js"></script>
        <script src="assets/plugins/x-editable/bootstrap3-editable/js/bootstrap-editable.js"></script>
        <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="assets/js/modern.min.js"></script>
        <script src="assets/js/pages/table-data.js"></script>
        <script src="assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
        <script src="assets/plugins/jquery-validation/jquery.validate.min.js"></script>
        <script src="assets/js/pages/form-wizard.js"></script>
        
        
         <script src="assets/plugins/toastr/toastr.min.js"></script>
         <script src="own/flipclock.js"></script>
         <script src="own/own.js"></script>
        
         <script src="charts/canvasjs.min.js"></script>
         <script src="charts/jquery.canvasjs.min.js"></script>
         <script type="text/javascript" src="https://www.google.com/jsapi"></script>
         
           
 
  <link rel="stylesheet" href="share/css/rrssb.css" />   
 
  <script src="share/js/rrssb.min.js"></script>
  <script>
  $(document).ready(function() {
      function activateTab($link) {
          var target = $link.attr('href');
          if (!target || target.length < 2) return;
          var targetId = target.charAt(0) === '#' ? target.substring(1) : target;
          var $pane = $('#' + targetId);
          if (!$pane.length) return;
          var $navTabs = $link.closest('.nav-tabs');
          var $contentContainer = $navTabs.siblings('.tab-content');
          if (!$contentContainer.length) {
              $contentContainer = $navTabs.parent().find('.tab-content').first();
          }
          $navTabs.find('li').removeClass('active');
          $link.parent('li').addClass('active');
          $contentContainer.children('.tab-pane').removeClass('active in');
          $pane.addClass('active in');
      }

      $(document).on('click', '.nav-tabs a[data-toggle="tab"]', function(e) {
          e.preventDefault();
          activateTab($(this));
      });

      var hash = window.location.hash;
      if (hash && hash.length > 1) {
          var $link = $('.nav-tabs a[href="' + hash + '"]');
          if ($link.length) {
              activateTab($link);
          }
      }
  });
  </script>
