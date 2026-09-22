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
        <!-- Currency & Tax Settings -->
        <hr class="my-4">
        <h5 class="card-title pt-0">Currency & Tax Settings</h5>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Currency</label>
          <div class="col-sm-10">
            <select name="currency" class="form-select">
              <option value="CAD" {{ ($general_setting->currency ?? 'CAD') == 'CAD' ? 'selected' : '' }}>CAD ($ - Canadian Dollar)</option>
              <option value="USD" {{ ($general_setting->currency ?? '') == 'USD' ? 'selected' : '' }}>USD ($ - US Dollar)</option>
              <option value="EUR" {{ ($general_setting->currency ?? '') == 'EUR' ? 'selected' : '' }}>EUR (€ - Euro)</option>
              <option value="GBP" {{ ($general_setting->currency ?? '') == 'GBP' ? 'selected' : '' }}>GBP (£ - British Pound)</option>
              <option value="AUD" {{ ($general_setting->currency ?? '') == 'AUD' ? 'selected' : '' }}>AUD ($ - Australian Dollar)</option>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Tax Rate (%)</label>
          <div class="col-sm-4">
            <input type="number" step="0.01" name="tax_rate" value="{{ $general_setting->tax_rate ?? '15.00' }}" class="form-control" placeholder="15.00">
          </div>
          <label class="col-sm-2 col-form-label text-end">Tax Label</label>
          <div class="col-sm-4">
            <input type="text" name="tax_label" value="{{ $general_setting->tax_label ?? 'Taxes & fees' }}" class="form-control" placeholder="Taxes & fees">
          </div>
        </div>

        <!-- Booking Fee Settings -->
        <hr class="my-4">
        <h5 class="card-title pt-0">Booking Fee Settings</h5>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Pet Fee ($)</label>
          <div class="col-sm-4">
            <input type="number" step="0.01" name="pet_fee" value="{{ $general_setting->pet_fee ?? '25.00' }}" class="form-control" placeholder="25.00">
            <small class="text-muted">Per pet fee amount</small>
          </div>
          <label class="col-sm-2 col-form-label text-end">Laundry Fee ($)</label>
          <div class="col-sm-4">
            <input type="number" step="0.01" name="laundry_fee" value="{{ $general_setting->laundry_fee ?? '25.00' }}" class="form-control" placeholder="25.00">
            <small class="text-muted">Per load fee amount</small>
          </div>
        </div>

        <!-- Loyalty Points Settings -->
        <hr class="my-4">
        <h5 class="card-title pt-0">Loyalty Points Settings</h5>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Enable Loyalty Program</label>
          <div class="col-sm-10 d-flex align-items-center">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="loyalty_enabled" id="loyalty_enabled" value="1" {{ ($general_setting->loyalty_enabled ?? 1) ? 'checked' : '' }}>
              <label class="form-check-label fw-bold" for="loyalty_enabled">Enable customer loyalty points earning and redemption</label>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Earning Rate (Points / $1)</label>
          <div class="col-sm-10">
            <input type="number" step="0.0001" name="loyalty_points_per_dollar" value="{{ $general_setting->loyalty_points_per_dollar ?? '0.2000' }}" class="form-control">
            <small class="text-muted">Default: 0.2000 (1 point per $5 spent)</small>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Redemption Rate ($ / Point)</label>
          <div class="col-sm-10">
            <input type="number" step="0.0001" name="loyalty_points_redemption_rate" value="{{ $general_setting->loyalty_points_redemption_rate ?? '0.1000' }}" class="form-control">
            <small class="text-muted">Default: 0.1000 (100 points = $10 discount)</small>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-sm-10 offset-sm-2">
            <input type="submit" value="Update Settings" class='btn btn-success px-4'>
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