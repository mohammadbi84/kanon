@php
    use App\Models\OrganUser;
    use App\Models\Organ;
@endphp
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            @if (Auth::user()->hasRole('admin'))
                {{-- <li class="menu">
                    <a href="#admin" data-active="" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <span>امور مدیریت سایت</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled " id="admin" data-parent="#accordionExample">

                        <li>
                            <a href="{{route('topadv.list')}}"> اطلاعیه </a>
                        </li>
                        <li>
                            <a href="{{route('slider.list')}}"> اسلایدر </a>
                        </li>
                        <li>
                            <a href="{{route('state.list')}}"> استان ها </a>
                        </li>
                        <li>
                            <a href="{{route('policy.list')}}"> قانون </a>
                        </li>
                        <li>
                            <a href="{{route('course.list')}}">استاندارد آموزشی</a>
                        </li>
                        <li>
                            <a href="{{route('Advertisement.list')}}">آگهی</a>
                        </li>
                        <li>
                            <a href="{{route('khabar.list')}}"> اخبار </a>
                        </li>
                        <li>
                            <a href="{{route('about.index')}}">درباره ما</a>
                        </li>

                    </ul>
                </li>
                <li class="menu">
                    <a href="#anjoman" data-active="" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <span>امور اصناف</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled " id="anjoman" data-parent="#accordionExample">
                        <li class="">
                            <a href="{{route('senf.list')}}"> لیست اصناف </a>
                        </li>
                        <li>
                            <a href="{{route('senf.add')}}"> افزودن صنف جدید </a>
                        </li>

                        <li>
                            <a href="{{route('school.list1')}}"> لیست آموزشگاه ها </a>
                        </li>

                    </ul>
                </li>


                <li class="menu">
                    <a href="#off" data-active="" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <span>تخفیف ها</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled " id="off" data-parent="#accordionExample">
                        <li class="">
                            <a href="{{route('off.list')}}"> لیست تخفیف ها </a>
                        </li>

                    </ul>
                </li>

                <li class="menu">
                    <a href="#standard" data-active="" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <span>جداول استاندارد های آموزشی</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled " id="standard" data-parent="#accordionExample">
                        <li class="">
                            <a href="{{route('standard.list')}}"> استانداردها </a>
                        </li>
                        <li class="">
                            <a href="{{route('khoshe.list')}}"> خوشه ها </a>
                        </li>


                        <li class="">
                            <a href="{{route('jobtype.list')}}"> نوع شغل-بند 9 </a>
                        </li>

                        <li class="">
                            <a href="{{route('kardanesh.list')}}"> نوع کاردانش-بند 10 </a>
                        </li>

                    </ul>
                </li> --}}
                <li class="menu">
                    <a href="#standard" data-active="" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <span>مدیریت استاندارد ها</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="standard" data-parent="#accordionExample">
                        <!-- شروع زیرمنو جدید: پیکربندی -->
                        <li class="menu">
                            <a href="#pikirbandi" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                <span>پیکربندی</span>
                            </a>
                            <ul class="collapse submenu list-unstyled" id="pikirbandi">
                                <li><a href="{{ route('jobtype.list') }}">نوع شغل</a></li>
                                <li><a href="{{ route('kardanesh.list') }}">نوع کاردانش</a></li>
                                <li><a href="{{ route('tuition') }}">نرخ شهریه</a></li>
                                <li><a href="{{ route('mineducation.list') }}">حداقل تحصیلات ورودی</a></li>
                            </ul>
                        </li>
                        <!-- پایان زیرمنو جدید: پیکربندی -->
                        <li><a href="{{ route('standard.list') }}">رسته ها</a></li>
                        <li><a href="{{ route('khoshe.list') }}">خوشه ها</a></li>
                        <li><a href="{{ route('group.list1') }}">رشته ها</a></li>
                        <li><a href="{{ route('herfe.list1') }}">حرفه ها</a></li>
                        <li><a href="{{ route('sanad.list1') }}">سند ها</a></li>
                    </ul>
                </li>

                <li class="menu">
                    <a href="#tablighat" data-active="" data-toggle="collapse" aria-expanded="true"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <span>مدیریت تبلیغات</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="tablighat" data-parent="#accordionExample">
                        <li class="">
                            <a href="#modiriatBakhsh" data-toggle="collapse" aria-expanded="false"
                                class="dropdown-toggle">
                                مدیریت بخش‌ها
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-chevron-right">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </div>
                            </a>
                            <ul class="collapse list-unstyled" id="modiriatBakhsh">
                                <li>
                                    <a href="{{ route('topadv.list') }}">اطلاعیه</a>
                                </li>
                                <li>
                                    <a href="{{ route('slider.list') }}">اسلایدر </a>
                                </li>
                                <li>
                                    <a href="{{ route('popup.edit') }}">پاپ اپ</a>
                                </li>
                                <li>
                                    <a href="{{ route('adslogin.list') }}">صفحه ورود</a>
                                </li>
                                <li>
                                    <a href="{{ route('register_message.edit') }}">پیام قبل از ثبت نام</a>
                                </li>
                                <li>
                                    <a href="{{ route('register_alert.edit') }}">هشدار ثبت نام</a>
                                </li>
                                <li>
                                    <a href="{{ route('Advertisement.list') }}">اگهی ها</a>
                                </li>
                                <li>
                                    <a href="{{ route('videoads.list') }}">ویدیو میانی</a>
                                </li>
                                <li>
                                    <a href="{{ route('course.list') }}">دوره آموزشی</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="menu">
                    <a href="{{ route('khabar.list') }}" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <span>اخبار</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                </li>
                <li class="menu">
                    <a href="{{ route('organ.index') }}" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <span>مدریت اعضا</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                </li>

                <li class="menu">
                    <a href="#peykarbandi" data-active="" data-toggle="collapse" aria-expanded="true"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <span>پیکر بندی</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="peykarbandi" data-parent="#accordionExample">
                        <li><a href="{{ route('contents.index') }}">مدریت مزایا گواهینامه ها</a></li>
                        <li>
                            <a href="{{ route('state.list') }}"> استان ها </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->hasRole('organ'))
                @php
                    $organId = OrganUser::where('user_id', Auth::user()->id)
                        ->where('role', 1)
                        ->first();
                    $organ = Organ::find($organId->organ_id);
                @endphp
                @if ($organ->status == 5)
                    <li class="menu">
                        <a href="#setting" data-active="" data-toggle="collapse" aria-expanded="true"
                            class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <span>تنظیمات و مشخصات</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled " id="setting" data-parent="#accordionExample">
                            <li class="">
                                <a href="{{ route('organ.herfes') }}"> حرفه ها </a>
                            </li>
                            <li class="">
                                <a href="{{ route('organ.reshtes') }}"> رشته ها </a>
                            </li>

                            <li class="">
                                <a href="{{ route('organ.files') }}"> فایل ها </a>
                            </li>


                        </ul>
                    </li>
                @endif
            @endif

        </ul>
        <!-- <div class="shadow-bottom"></div> -->

    </nav>

</div>
