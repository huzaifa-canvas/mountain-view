
<div class="modal fade" id="listingsModal" tabindex="-1" aria-labelledby="listingsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
   
      <div class="modal-body">
        <form action="{{ url('admin/post-' . last(request()->segments())) }}" method="post" enctype="multipart/form-data">
          @csrf
        
          <section class="section">
            <div class="row">
              <div class="col-lg-12">
      
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Add New Listing</h5>
                        <div class="row mb-3">
                          <label for="inputText" class="col-sm-12 col-form-label">Listing Name</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" name='listings_name' id="inputText" placeholder="Enter Listing Name" required>
                          </div>
                        </div> 
                        <div class="row mb-3">
                          <label for="inputText" class="col-sm-12 col-form-label">Listing Price</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" name='listings_price' placeholder="Enter Price" required>
                          </div>
                        </div> 
                        <label for="inputText" class="col-sm-12 col-form-label">Listing Points</label>
                        <div class="col-sm-12">
                          <div id="answer_container">
                            <div class="input-group mb-2 answer_parent">
                              <input type="text" name='listings_points[]' class="form-control" placeholder="Enter Points" required>
                              <button type="button" class="btn btn-danger remove-btn"><i class="bi bi-x-lg"></i></button>
                            </div>
                          </div>
                          <button id="clone_btn" type="button" class="btn btn-success"><i class="bi bi-plus-lg"></i></button>
                        </div>
                        <label for="inputText" class="col-sm-12 col-form-label">Listing Extras</label>
                        <div class="col-sm-12">
                          <div id="answer_container2">
                            <div class="input-group mb-2 answer_parent2">
                              <input type="text" name='listings_icons[]' class="form-control" placheholder="Enter Fontawesome Icon" required>
                              <input type="text" name='listings_extras[]' class="form-control" placheholder="Enter Extras" required>
                              <button type="button" class="btn btn-danger remove-btn2"><i class="bi bi-x-lg"></i></button>
                            </div>
                          </div>
                          <button id="clone_btn2" type="button" class="btn btn-success"><i class="bi bi-plus-lg"></i></button>
                        </div>
                        <div class="row mb-3">
                          <label for="inputText" class="col-sm-12 col-form-label">Team Img</label>
                          <div class="col-sm-12">
                            <div class="input-images"></div>
                          </div>
                        </div> 
                        <div class="row mb-3">
                          <label for="inputText" class="col-sm-12 col-form-label">Listing Persons</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" name='listings_number_of_persons' placeholder="Number of Persons" required>
                          </div>
                        </div> 
                        <div class="row mb-3">
                          <div class="col-sm-10">
                              <input type="submit" value="Add New Listing" class='btn btn-success'>
                          </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </section>
      </div>
    </div>
  </div>
</div>





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
      $(document).ready(function(){
        let counter = 1;
        $('#clone_btn2').on('click', function(){
            var answerContainer = $('#answer_container2');
            if (answerContainer.length) {
                var clone = $('.answer_parent2:first').clone(); 
                clone.find('input').val(''); 
                answerContainer.append(clone); 
                counter++; 
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
  <script>
        $('.input-images').imageUploader();
        $('.input-images2').imageUploader2();

   </script>
</body>
</html>