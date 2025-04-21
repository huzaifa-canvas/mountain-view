@include('admin.inc.header')

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Global Setting</h1>
    <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
      <li class="breadcrumb-item active">Global Setting</li>
    </ol>
    </nav>
  </div><!-- End Page Title -->
<form  action="{{url('admin/global-settings/1')}}" method='post' enctype="multipart/form-data" >
  @csrf
  @if(session()->has('success'))
  <div class="alert alert-success">
    {{ session()->get('success') }}
  </div>
@endif
  <section class="section">
    <div class="row">
    <div class="col-lg-12">

      <div class="card">
      <div class="card-body">
        <h5 class="card-title">Global Settings</h5>
        <div class="row mb-3">
        
        </div>

        <div  class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Text</label>
          <div class="col-sm-10">
          <input type="text"  name='general_setting_text' value="{{$general_setting->general_setting_text ?? ''}}" class="form-control">
          </div>
        </div>
        <div  class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Logo</label>
          <div class="col-sm-10">
          <input type="file"  name='general_setting_logo' value="{{$general_setting->general_setting_logo ?? ''}}" class="form-control">
          </div>
        </div>
        <div  class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Address</label>
          <div class="col-sm-10">
          <input type="text"  name='general_setting_address' value="{{$general_setting->general_setting_address ?? ''}}" class="form-control">
          </div>
        </div>
        <div  class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Phone</label>
          <div class="col-sm-10">
          <input type="text"  name='general_setting_phone' value="{{$general_setting->general_setting_phone ?? ''}}" class="form-control">
          </div>
        </div>
        <div  class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
          <input type="email"  name='general_setting_email' value="{{$general_setting->general_setting_email ?? ''}}" class="form-control">
          </div>
        </div>
        <div  class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Facebook</label>
          <div class="col-sm-10">
          <input type="text"  name='general_setting_facebook' value="{{$general_setting->general_setting_facebook ?? ''}}" class="form-control">
          </div>
        </div>
        <div  class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Linkedin</label>
          <div class="col-sm-10">
          <input type="text"  name='general_setting_linkedin' value="{{$general_setting->general_setting_linkedin ?? ''}}" class="form-control">
          </div>
        </div>
        <div  class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Youtube</label>
          <div class="col-sm-10">
          <input type="text"  name='general_setting_youtube' value="{{$general_setting->general_setting_youtube ?? ''}}" class="form-control">
          </div>
        </div>
        <div  class="row mb-3">
          <label for="inputText" class="col-sm-2 col-form-label">Twitter</label>
          <div class="col-sm-10">
          <input type="text"  name='general_setting_twitter' value="{{$general_setting->general_setting_twitter ?? ''}}" class="form-control">
          </div>
        </div>
          <div class="row mb-3">
          <div class="col-sm-10">
            <input type="submit" value="Update" class='btn btn-success'>
          </div>
          </div>
        </form>
      </div>
      </div>
    </div>
    </div>
  </section>



  </main><!-- End #main -->
@include('admin.inc.footer')    