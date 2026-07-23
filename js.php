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
  (function() {
      var isPersonPage = document.getElementById('tab21') || document.getElementById('tab33');
      if (!isPersonPage) return;

      document.addEventListener('click', function(e) {
          var link = e.target.closest('.nav-tabs a[data-toggle="tab"]');
          if (!link) return;
          e.preventDefault();
          e.stopImmediatePropagation();
          var href = link.getAttribute('href');
          if (!href || href.length < 2) return;
          var pane = document.querySelector(href);
          if (!pane) return;
          var nav = link.closest('.nav-tabs');
          var lis = nav.querySelectorAll(':scope > li');
          for (var i = 0; i < lis.length; i++) lis[i].classList.remove('active');
          link.parentElement.classList.add('active');
          var container = nav.parentElement;
          var tabContent = container.querySelector('.tab-content');
          if (!tabContent) tabContent = nav.closest('.panel-body, .panel, [role="tabpanel"]').querySelector('.tab-content');
          if (!tabContent) return;
          var panes = tabContent.children;
          for (var i = 0; i < panes.length; i++) {
              panes[i].classList.remove('active');
              panes[i].classList.remove('in');
          }
          pane.classList.add('active');
          pane.classList.add('in');
      }, true);

      document.addEventListener('DOMContentLoaded', function() {
          var hash = window.location.hash;
          if (hash && hash.length > 1) {
              var link = document.querySelector('.nav-tabs a[href="' + hash + '"]');
              if (link) link.click();
          }
      });
  })();
  </script>
