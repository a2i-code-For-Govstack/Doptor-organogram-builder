
<div class="card card-custom">
    <!--begin::Header-->
    <div class="row m-0 page-title-wrapper d-md-flex align-items-md-center">
        <div class="col-md-6">
            <div class="title py-2">
                <h4 class="mb-0 font-weight-bold"><i class="fas fa-list mr-3"></i>{{ __('Change of personal information')}}
                </h4>
            </div>
        </div>
    </div>

    <!--end::Header-->
    <!--begin::Form-->
    <form class="form" id="DataChange" action="{{ route('profile.edit') }}" method="post">
        <!--begin::Body-->
        @csrf
        <div class="card-body" id="kt_profile_scroll">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Name')}}<span class="text-danger">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input name="name_bng" id="name_bng" class="form-control form-control-lg form-control-solid no-drop" type="text"
                                   value="{{ Auth::user()->employee->name_bng ?? ''  }}" disabled onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')"/>
                                    <p class="mb-0">Full Name :<span class="text-success" style="font-size: 15px !important;" id="full_name_bng">{{ Auth::user()->employee->full_name_bng ?? ''  }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Name (English)')}}<span class="text-danger">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input name="name_eng" id="name_eng" class="form-control form-control-lg form-control-solid no-drop" type="text"
                                   value="{{ Auth::user()->employee->name_eng ?? ''  }}" disabled onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')"/>
                                   <p class="mb-0">Full Name (English) :<span class="text-success" style="font-size: 15px !important;" id="full_name_eng">{{ Auth::user()->employee->full_name_eng ?? ''  }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('First Name Surname')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input name="prefix_name_bng" id="prefix_name_bng" class="form-control form-control-lg form-control-solid bangla" type="text"
                                   value="{{ Auth::user()->employee->prefix_name_bng ?? ''  }}" onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('First Name Surname (English)')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input name="prefix_name_eng" id="prefix_name_eng" class="form-control form-control-lg form-control-solid english" type="text"
                                   value="{{ Auth::user()->employee->prefix_name_eng ?? ''  }}" onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Surname')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input name="surname_bng" id="surname_bng" class="form-control form-control-lg form-control-solid bangla" type="text"
                                   value="{{ Auth::user()->employee->surname_bng ?? ''  }}" onkeyup="generate_full_name('#prefix_name_bng', '#name_bng', '#surname_bng', '#full_name_bng')"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Surname (English)')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input name="surname_eng" id="surname_eng" class="form-control form-control-lg form-control-solid english" type="text"
                                   value="{{ Auth::user()->employee->surname_eng ?? ''  }}" onkeyup="generate_full_name('#prefix_name_eng', '#name_eng', '#surname_eng', '#full_name_eng')"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Father Name')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input name="father_name_bng" class="form-control form-control-lg form-control-solid bangla" type="text"
                                   value="{{ Auth::user()->employee->father_name_bng ?? ''  }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Father Name (English)')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input name="father_name_eng" class="form-control form-control-lg form-control-solid english" type="text"
                                   value="{{ Auth::user()->employee->father_name_eng ?? ''  }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Mother Name')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input name="mother_name_bng" class="form-control form-control-lg form-control-solid bangla" type="text"
                                   value="{{ Auth::user()->employee->mother_name_bng ?? ''  }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Mother Name (English)')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input name="mother_name_eng" class="form-control form-control-lg form-control-solid english" type="text"
                                   value="{{ Auth::user()->employee->mother_name_eng ?? ''  }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Birth Date')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input name="date_of_birth" type="text" class="form-control form-control-lg form-control-solid no-drop"
                                   placeholder="{{ __('জন্ম তারিখ')}}" value="{{ Auth::user()->employee ? Carbon\Carbon::parse(Auth::user()->employee->date_of_birth)->format('d M Y') : ''  }}" disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Gender')}}<span class="text-danger">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            @php
                                $genders = ['Male', 'Female', 'Other'];
                            @endphp
                            <select name="gender" class="form-control" placeholder="Gender" id="gender" required>
                                <option value="">--Choose--</option>
                                @foreach ($genders as $key => $gender)
                                    <option value="{{ $key+1 }}" {{ Auth::user()->employee && Auth::user()->employee->gender == $key+1 ? 'selected' : '' }}>{{ $gender }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Personal e-mail')
                                    }}<span class="text-danger">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input readonly name="personal_email" type="email" class="form-control form-control-lg form-control-solid no-drop"
                                   placeholder="{{ __('Personal e-mail') }}" value="{{ Auth::user()->employee->personal_email ?? ''  }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('
                            Identity card no')
                                    }}<span class="text-danger">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input name="nid" type="text" class="form-control form-control-lg form-control-solid no-drop"
                                   placeholder="{{ __('
                                   Identity card no') }}" value="{{ Auth::user()->employee->nid ?? ''  }}" disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Personal mobile
                            No') }}<span class="text-danger">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input readonly name="personal_mobile" type="text" class="form-control form-control-lg form-control-solid no-drop"
                                   placeholder="{{ __('Personal mobile No') }}" value="{{ Auth::user()->employee->personal_mobile ?? ''  }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('
                            Alternative mobile number')
                                    }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input name="alternative_mobile" type="text" class="form-control form-control-lg form-control-solid" maxlength="11"
                                   placeholder="{{ __('
                                   Alternative mobile number') }}" value="{{ Auth::user()->employee->alternative_mobile ?? ''  }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Religion')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <select name="religion" class="form-control" placeholder="Religion" id="religion">
                                <option value="">--Choose--</option>
                                <option value="Islam" {{ Auth::user()->employee && Auth::user()->employee->religion == "Islam" ? 'selected' : '' }}>Islam</option>
                                <option value="Hindu" {{ Auth::user()->employee && Auth::user()->employee->religion == "Hindu" ? 'selected' : '' }}>Hindu</option>
                                <option value="Christian" {{ Auth::user()->employee && Auth::user()->employee->religion == "Christian" ? 'selected' : '' }}>Christan</option>
                                <option value="Buddhist" {{ Auth::user()->employee && Auth::user()->employee->religion == "Buddhist" ? 'selected' : '' }}>Buddha</option>
                                <option value="Others" {{ Auth::user()->employee && Auth::user()->employee->religion == "Others" ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Marital Status')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <select name="marital_status" class="form-control" placeholder="Marital Status" id="marital-status">
                                <option value="">--Choose--</option>
                                <option value="Single" {{ Auth::user()->employee && Auth::user()->employee->marital_status == "Single" ? 'selected' : '' }}>Single</option>
                                <option value="Married" {{ Auth::user()->employee && Auth::user()->employee->marital_status == "Married" ? 'selected' : '' }}>Married</option>
                                <option value="Widowed" {{ Auth::user()->employee && Auth::user()->employee->marital_status == "Widowed" ? 'selected' : '' }}>Widowed</option>
                                <option value="Separated" {{ Auth::user()->employee && Auth::user()->employee->marital_status == "Separated" ? 'selected' : '' }}>Separated</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Blood Group')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <select name="blood_group" class="form-control" placeholder="Blood Group" id="blood-group">
                                <option value="">--Choose--</option>
                                <option value="A+" {{ Auth::user()->employee && Auth::user()->employee->blood_group == "A+" ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ Auth::user()->employee && Auth::user()->employee->blood_group == "A-" ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ Auth::user()->employee && Auth::user()->employee->blood_group == "B+" ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ Auth::user()->employee && Auth::user()->employee->blood_group == "B-" ? 'selected' : '' }}>B-</option>
                                <option value="O+" {{ Auth::user()->employee && Auth::user()->employee->blood_group == "O+" ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ Auth::user()->employee && Auth::user()->employee->blood_group == "O-" ? 'selected' : '' }}>O-</option>
                                <option value="AB+" {{ Auth::user()->employee && Auth::user()->employee->blood_group == "AB+" ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ Auth::user()->employee && Auth::user()->employee->blood_group == "AB-" ? 'selected' : '' }}>AB-</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Login Name')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input name="user_alias" id="user_alias" type="text" class="form-control form-control-lg form-control-solid user_alias english"
                                   placeholder="{{ __('Login Name') }}" value="{{ Auth::user()->user_alias ?? ''  }}"/>
                        <span id="check-user_alias"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__foot pb-1">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col-lg-12 col-xl-12 text-right">
                        <button type="submit" class="btn btn-info"><i class="fa fa-save"></i>Save
                        </button>&nbsp;
                        <button type="reset" class="btn btn-danger"><i class="fas fa-sync  mr-2"></i>Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Body-->
    </form>
    <!--end::Form-->
</div>
<script !src="">
    $('.bangla').bangla({ enable: true });

    $('.english').on('keyup',function (){
        var english = $(this).val();
        if (isUnicode(english) === true) {
            $(this).val('');
            toastr.warning('Please use English words');
            return false
        }
    });

    var timer;
    $('.user_alias').on('keyup', function () {
        clearTimeout(timer);
        timer = setTimeout(waitCheckAlias, 1000);
    });

    function waitCheckAlias() {
        var user_alias = $("#user_alias").val();
        url = '{{url('check_user_alias')}}';
        data = {user_alias};
        datatype = 'json';
        ajaxCallUnsyncCallback(url, data, datatype, 'POST', function (response) {
            if (response.status == 'success') {
                $('#check-user_alias').text(response.msg).css({ 'color': 'red', 'font-family' : 'Nikosh' });
            } else {
                $('#check-user_alias').text(response.msg).css({ 'color': 'green', 'font-family' : 'Nikosh, SolaimanLipi, sans-serif' });
            }
        })
    }
</script>
