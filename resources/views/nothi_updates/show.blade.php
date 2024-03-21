<div class="container">
    <div class="row">
      <div class="col-sm text-left">
        <b>ভার্শন: {{ En2Bn($data->version) }} </b>
      </div>
      <div class="col-sm text-right">
        <b>রিলিজ ডেট: {{ En2Bn($data->release_date) }} </b>
      </div>
    </div>


  <p>
      {!! $data->body !!}
  </p>

</div>

  @php
    function En2Bn($number) {
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        return str_replace($en, $bn, $number);
    }
@endphp