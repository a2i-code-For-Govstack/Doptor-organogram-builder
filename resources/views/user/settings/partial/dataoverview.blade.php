<div class="card card-custom">
    <!--begin::Header-->
    <div class="row m-0 page-title-wrapper d-md-flex align-items-md-center">
        <div class="col-md-6">
            <div class="title py-2">
                <h4 class="mb-0 font-weight-bold"><i class="fas fa-list mr-3"></i>{{ __('Personal Information')}}
                </h4>
            </div>
        </div>
        <div class="col-md-6">
            <div class="btn-group float-right">
                <button onclick="profileManager('change-profile/info-change-form', 'editForm')"
                        class="btn btn-info btn-sm" id="editButtons"><i class="fa fa-edit"></i>
                        Change information
                </button>
            </div>
        </div>
    </div>

    <!--end::Header-->
    <!--begin::Form-->
    <form class="form">
        <!--begin::Body-->
        <div class="card-body" id="kt_profile_scroll">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Name')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control form-control-lg form-control-solid" type="text"
                                   value="{{ Auth::user()->employee->full_name_bng ?? ''  }}" disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Name (English)')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control form-control-lg form-control-solid" type="text"
                                   value="{{ Auth::user()->employee->full_name_eng ?? ''  }}" disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Father Name')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control form-control-lg form-control-solid" type="text"
                                   value="{{ Auth::user()->employee->father_name_bng ?? ''  }}" disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Father Name (English)')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control form-control-lg form-control-solid" type="text"
                                   value="{{ Auth::user()->employee->father_name_eng ?? ''  }}" disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Mother Name')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control form-control-lg form-control-solid" type="text"
                                   value="{{ Auth::user()->employee->mother_name_bng ?? ''  }}" disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Mother Name (English)')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control form-control-lg form-control-solid" type="text"
                                   value="{{ Auth::user()->employee->mother_name_eng ?? ''  }}" disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Birth Date')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input type="text" class="form-control form-control-lg form-control-solid"
                                   placeholder="{{ __('Birth Date')}}"
                                   value="{{ Auth::user()->employee ? Carbon\Carbon::parse(Auth::user()->employee->date_of_birth)->format('d M Y') : ''  }}"
                                   disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Gender')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input type="text" class="form-control form-control-lg form-control-solid"
                                   placeholder="{{ __('Gender')}}"
                                   value="{{ (Auth::user()->employee && Auth::user()->employee->gender == 1) ? "Male" : ((Auth::user()->employee && Auth::user()->employee->gender == 2)  ? "Female" : "Other") }}"
                                   disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Personal Email') }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input disabled type="email" class="form-control form-control-lg form-control-solid"
                                   placeholder="{{ __('Personal Email') }}"
                                   value="{{ Auth::user()->employee->personal_email ?? ''  }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Nid No.') }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input type="text" class="form-control form-control-lg form-control-solid"
                                   placeholder="{{ __('Nid No.') }}"
                                   value="{{ Auth::user()->employee->nid ?? ''  }}" disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label
                            class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Personal Mobile No.') }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input disabled type="text" class="form-control form-control-lg form-control-solid"
                                   placeholder="{{ __('Personal Mobile No.') }}"
                                   value="{{ Auth::user()->employee->personal_mobile ? enTobn(Auth::user()->employee->personal_mobile) : ''  }}"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label
                            class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Alternative Mobile No.') }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input type="text" class="form-control form-control-lg form-control-solid"
                                   placeholder="{{ __('Alternative Mobile No.') }}"
                                   value="{{ Auth::user()->employee->alternative_mobile ? enTobn(Auth::user()->employee->alternative_mobile) : ''  }}" disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Religion')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input type="text" class="form-control form-control-lg form-control-solid"
                                   placeholder="{{ __('Religion') }}" value="{{ Auth::user()->employee->religion ?? ''  }}"
                                   disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Marital Status')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input type="text" class="form-control form-control-lg form-control-solid"
                                   placeholder="{{ __('Marital Status') }}"
                                   value="{{ Auth::user()->employee->marital_status ?? ''  }}" disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Blood Group')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input type="text" class="form-control form-control-lg form-control-solid"
                                   placeholder="{{ __('Blood Group') }}"
                                   value="{{ Auth::user()->employee->blood_group ?? ''  }}" disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label text-left">{{ __('Login Name')}}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input type="text" class="form-control form-control-lg form-control-solid"
                                   placeholder="{{ __('Login Name') }}" value="{{ Auth::user()->user_alias ?? ''  }}"
                                   disabled/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Body-->
    </form>
    <!--end::Form-->
</div>
