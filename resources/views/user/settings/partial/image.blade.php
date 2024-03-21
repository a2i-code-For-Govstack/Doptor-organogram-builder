<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
<style type="text/css">
    .nounderline, .violet {
        color: #0abb87 !important;
    }

    .btn-dark {
        background-color: #0abb87 !important;
        border-color: #0abb87 !important;
    }

    .btn-dark .file-upload {
        width: 100%;
        padding: 10px 0px;
        position: absolute;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .profile-img img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
    }
</style>
<!-- begin:: Content -->
<!--Begin:: App Content-->


<div class="card card-custom">
    <!--begin::Header-->
    <div class="row m-0 page-title-wrapper d-md-flex align-items-md-center">
        <div class="col-md-6">
            <div class="title py-2">
                <h4 class="mb-0 font-weight-bold"><i class="fas fa-list mr-3"></i>{{ __('প্রোফাইল ফটো পরিবর্তন')}}</h4>
            </div>
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Form-->
    <form class="form">
        <!--begin::Body-->
        <div class="card-body" id="kt_profile_scroll">
            <div class="profile-img" onclick="$('#file-upload').click()">
                <img src="{{Auth::user()->employee ? Auth::user()->employee->profile_picture() : asset('images/no.png')}}" id="profile-pic">
            </div>
            <!--begin::Alart-->
            <div class="badge badge-warning align-items-center mt-3" role="alert">
                <div>
                    &nbsp;&nbsp;প্রোফাইল ছবি অবশ্যই ৩০০ x ৩০০ পিক্সেল (প্রস্থ x উচ্চতা) এবং ফাইলের আকার অবশ্যই ৫০ কিলো বাইটের কম এবং JPG বা JPEG ফরমেটে হতে হবে।
                </div>
            </div>
            <!--end::Alart-->
            <div class="kt-portlet__foot mt-3">
                <div class="kt-form__actions">
                    <div class="btn btn-dark">
                        <input type="file" class="file-upload" id="file-upload" name="profile_picture" accept="image/x-png,image/jpeg">
                        ছবি বাছাই করুন
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="myModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">ছবি ক্রপ করুন</h4>
                        <button type="button" class="close" data-dismiss="modal"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div id="resizer"></div>
                        <button onclick="return false;" class="btn rotate float-lef" data-deg="90">
                            <i class="fas fa-undo"></i></button>
                        <button onclick="return false;" class="btn rotate float-right" data-deg="-90">
                            <i class="fas fa-redo"></i></button>
                        <hr>
                        <button class="btn btn-block btn-dark" id="upload" onclick="saveImage(event)">
                            সংরক্ষণ
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Body-->
    </form>
    <!--end::Form-->
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.js"></script>
<script>
    function saveImage(e) {
        e.preventDefault();
    }

    @if (session('success'))
    Swal.fire({
        icon: 'success',
        title: '{{ session('success') }}',
        text: ''
    });
    @endif

    @if (session('error'))
    Swal.fire({
        icon: 'error',
        title: '{{ session('error') }}',
        text: ''
    });
    @endif

    @if ($errors->any())
    @php
        $str = "";
    @endphp
    @foreach ($errors->all() as $error)
    @php
        $str .= $error. "\r\n";
    @endphp
    @endforeach
    Swal.fire({
        icon: 'error',
        title: 'Error',
        html: `{{ $str }}`
    });
    @endif

    $(function () {
        var croppie = null;
        var el = document.getElementById('resizer');

        $.base64ImageToBlob = function (str) {
            var pos = str.indexOf(';base64,');
            var type = str.substring(5, pos);
            var b64 = str.substr(pos + 8);

            var imageContent = atob(b64);

            var buffer = new ArrayBuffer(imageContent.length);
            var view = new Uint8Array(buffer);

            for (var n = 0; n < imageContent.length; n++) {
                view[n] = imageContent.charCodeAt(n);
            }

            var blob = new Blob([buffer], {type: type});

            return blob;
        }

        $.getImage = function (input, croppie) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    croppie.bind({
                        url: e.target.result,
                    });
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#file-upload").on("change", function (event) {
            $("#myModal").modal();

            croppie = new Croppie(el, {
                viewport: {
                    width: 300,
                    height: 300
                },
                boundary: {
                    width: 350,
                    height: 350
                },
                enableOrientation: true
            });
            $.getImage(event.target, croppie);
        });

        $("#upload").on("click", function () {
            croppie.result('base64').then(function (base64) {
                $("#myModal").modal("hide");
                $("#profile-pic").attr("src", "{{ asset('images/loader.gif') }}");

                var url = "{{ route('image.change') }}";
                var formData = new FormData();
                formData.append("photo", $.base64ImageToBlob(base64));


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.status == "success") {
                            $("#profile-pic").attr("src", base64);
                            $("#profilepic").attr("src", base64);
                            $(".kt-badge--username").attr("src", base64);
                            $("#profile_page_pic").attr("src", base64);
                            $('.kt-user-card__avatar img').attr("src", base64);
                            Swal.fire({
                                icon: 'success',
                                title: 'প্রোফাইল ছবি পরিবর্তন হয়েছে',
                                text: ''
                            });

                        } else {
                            $("#profile-pic").attr("src", "{{ asset('images/no.png') }}");
                            // console.log(data['profile_picture']);
                        }
                    },
                    error: function (error) {
                        Swal.fire({
                                icon: 'error',
                                title: 'দুঃখিত',
                                text: 'ফাইল সাইজ সঠিক নয়!'
                            });
                        $("#profile-pic").attr("src", "{{ asset('images/no.png') }}");
                        $('#imgBtn').click()
                    }
                });
            });
        });

        // To Rotate Image Left or Right
        $(".rotate").on("click", function () {
            croppie.rotate(parseInt($(this).data('deg')));
        });

        $('#myModal').on('hidden.bs.modal', function (e) {
            // This function will call immediately after model close
            // To ensure that old croppie instance is destroyed on every model close
            setTimeout(function () {
                croppie.destroy();
            }, 100);
        })

    });

</script>
