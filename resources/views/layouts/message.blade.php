
  @if(session('message'))
      <div class="row mb-2">
          <div class="col-lg-12">
              <div class="alert alert-success" role="alert d-flex justify-content-center">
                {{ session('message') }}
              </div>
          </div>
      </div>
  @endif

  @if(session('error'))
      <div class="alert alert-danger d-flex justify-content-center">
            {{ session('error') }}
      </div>
  @endif
