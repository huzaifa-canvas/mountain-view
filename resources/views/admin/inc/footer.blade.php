
<!-- ======= Footer ======= -->
 <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>MountainView</span></strong>. All Rights Reserved 
    </div>

    </div>
  </footer>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" ></script>
  <script src="{{asset('assets/admin/vendor/apexcharts/apexcharts.min.js')}}" defer></script>
  <script src="{{asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/admin/vendor/chart.js/chart.umd.js')}}" defer></script>
  <script src="{{asset('assets/admin/vendor/echarts/echarts.min.js')}}" defer></script>
  <script src="{{asset('assets/admin/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('assets/admin/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('assets/admin/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('assets/admin/vendor/multi/image-uploader.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/admin/js/main.js')}}"></script>
  <script>
    $(document).ready(function(){
      let counter = 1;
      $('#clone_btn').on('click', function(){
          var answerContainer = $('#answer_container');
          if (answerContainer.length) {
              var clone = $('.answer_parent:first').clone(); 
              clone.find('input').val(''); 
              answerContainer.append(clone); 
              counter++; 
          } else {
              console.error('Required elements are missing in the DOM.');
          }
      });

      $(document).on('click', '.remove-btn', function(){
          if ($('.answer_parent').length > 1) {
              $(this).closest('.answer_parent').remove();
          } else {
              alert('At least one input field is required.');
          }
      });
    });
  </script>
    <script>
      function formatIcon (icon) {
          if (!icon.id) {
              return icon.text;
          }
          var $icon = $('<span><i class="' + icon.element.value + '"></i> ' + icon.text + '</span>');
          return $icon;
      };

      function initSelect2() {
          $('.icon-select').select2({
              templateResult: formatIcon,
              templateSelection: formatIcon,
              width: '100%'
          });
      }

      $(document).ready(function(){
        initSelect2();
        
        $('#clone_btn2').on('click', function(){
            var answerContainer = $('#answer_container2');
            if (answerContainer.length) {
                $('.icon-select').select2('destroy');
                
                var clone = $('.answer_parent2:first').clone(); 
                clone.find('input[type="text"]').val(''); 
                clone.find('select').prop('selectedIndex', 0);
                
                answerContainer.append(clone); 
                initSelect2();
            } else {
                console.error('Required elements are missing in the DOM.');
            }
        });
  
        $(document).on('click', '.remove-btn2', function(){
            if ($('.answer_parent2').length > 1) {
                $(this).closest('.answer_parent2').remove();
            } else {
                alert('At least one input field is required.');
            }
        });
      });
    </script>
  <script>
    tinymce.init({
      selector: 'textarea#default-editor'
    });

  $("#tagsinput").tagsinput('items')	

  </script>
  <style>
      .image-uploader .upload-text {
          color: #666 !important;
          font-weight: 500;
          text-align: center;
      }
      .image-uploader .upload-text i.material-icons {
          font-size: 3.5rem !important;
          color: #ccc !important;
          margin-bottom: 10px;
      }
  </style>
  <script>
        $('.input-images').imageUploader({
            label: 'Drag & Drop files here or click to browse'
        });
        $('.input-images2').imageUploader2({
            label: 'Drag & Drop files here or click to browse'
        });

        // Fix for image uploader placeholder not showing when all images are deleted
        // Using capture phase (true) because the plugin stops event propagation
        document.addEventListener('click', function(e) {
            let deleteBtn = e.target.closest('.delete-image');
            if (deleteBtn) {
                let uploader = deleteBtn.closest('.image-uploader');
                if (uploader) {
                    setTimeout(function() {
                        if (uploader.querySelectorAll('.uploaded-image').length === 0) {
                            uploader.classList.remove('has-files');
                        }
                    }, 50);
                }
            }
        }, true);
   </script>
</body>
</html>