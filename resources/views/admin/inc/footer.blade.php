
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <h5 class="card-title">Team</h5>
         
      
                        <div id='kf' class="row mb-3">
                          <label for="inputText" class="col-sm-12 col-form-label">Team Name</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" name='teams_name' id="inputText" placeholder="Enter Team Name" required>
                          </div>
                        </div> 

                        <div id='kf' class="row mb-3">
                          <label for="inputText" class="col-sm-12 col-form-label">Team Img</label>
                          <div class="col-sm-12">
                            <input type="file" class="form-control" name='teams_img' id="teams_img" required>
                          </div>
                        </div> 

                        
                     
                        <div class="row mb-3">
                          <div class="col-sm-10">
                              <input type="submit" value="Add Team" class='btn btn-success'>
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
<div class="modal fade" id="ServicesModal" tabindex="-1" aria-labelledby="ServicesModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
   
      <div class="modal-body">
        <form  action="{{url('admin/post-service/')}}" method='post' enctype="multipart/form-data" >
          @csrf
        
          <section class="section">
            <div class="row">
              <div class="col-lg-12">
      
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Service</h5>
         
      
                        <div id='kf' class="row mb-3">
                          <label for="inputText" class="col-sm-12 col-form-label">Service Name</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" name='services_name' id="services_name" placeholder="Enter Service Name" required>
                          </div>
                        </div> 

                       
                        <div id='slideupload' class="row mb-3">
                          <label for="inputText" class="col-sm-12 col-form-label">Serives Images</label>
                          <div class="col-sm-12">
                            <div class="input-images"></div>
                          </div>
                        </div> 

                        
                     
                        <div class="row mb-3">
                          <div class="col-sm-10">
                              <input type="submit" value="Add Team" class='btn btn-success'>
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
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
   
      <div class="modal-body">
        <form  action="{{url('admin/upload-video/')}}" method='post' enctype="multipart/form-data" >
          @csrf
        
          <section class="section">
            <div class="row">
              <div class="col-lg-12">
      
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Video</h5>
         
      
                        <div id='kf' class="row mb-3">
                          <label for="inputText" class="col-sm-12 col-form-label">Video Name</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" name='videos_name' id="inputText" placeholder="Enter Video Name" required>
                          </div>
                        </div> 

                        <div id='kf' class="row mb-3">
                          <label for="inputText" class="col-sm-12 col-form-label">Video</label>
                          <div class="col-sm-12">
                            <input type="file" class="form-control" name='videos_url' id="videos_url" required>
                          </div>
                        </div> 

                        
                     
                        <div class="row mb-3">
                          <div class="col-sm-10">
                              <input type="submit" value="Add Team" class='btn btn-success'>
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
  <!-- Template Main JS File -->
  <script src="{{asset('assets/admin/js/main.js')}}"></script>
  <script src="{{asset('assets/admin/vendor/multi/image-uploader.min.js')}}"></script>
 
 <script>
    $(document).ready(function() {
        $('.form_view').on('click',function(){
          var id = $(this).data('id');
          $.ajax({
            url: "{{url('admin/get-form/')}}"+'/'+id,
            type: 'GET',
            success: function(response) {
              if(response.read == 1){
                $(".classsf_" + id).removeClass("table-success");
              }
              $('#formModal').modal('show');
              $('#formModal .modal-body').html(response.data);
            },
            error: function(xhr) {
              alert(xhr.responseText);
            }
          });
        });
    });
    $(document).ready(function() {
        $('.provider_view').on('click',function(){
          var id = $(this).data('id');
          $.ajax({
            url: "{{url('admin/get-provider/')}}"+'/'+id,
            type: 'GET',
            success: function(response) {
              $('#formModal').modal('show');
              $('#formModal .modal-body').html(response.data);
            },
            error: function(xhr) {
              alert(xhr.responseText);
            }
          });
        });
    });
    $(document).ready(function() {
        $('.edit').on('click',function(){
          var id = $(this).data('id');
          $.ajax({
            url: "{{url('admin/get-team/')}}"+'/'+id,
            type: 'GET',
            success: function(response) {
              $('#editModal').modal('show');
              $('#editModal .modal-content').html(response.data);
            },
            error: function(xhr) {
              alert(xhr.responseText);
            }
          });
        });
    });
    $(document).ready(function() {
        $('.edit2').on('click',function(){
          var id = $(this).data('id');
          $.ajax({
            url: "{{url('admin/get-service/')}}"+'/'+id,
            type: 'GET',
            success: function(response) {
              $('#editModal').modal('show');
              $('#editModal .modal-content').html(response.data);
              $('.input-images').imageUploader();

            },
            error: function(xhr) {
              alert(xhr.responseText);
            }
          });
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