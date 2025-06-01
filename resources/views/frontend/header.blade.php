
    <header class="header" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
        <div class="upper-bar" style="background-color: {{get_general_value('primary_color')}};color:white;padding-top:.8rem;padding-bottom:.8rem;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-2 col-lg-4">
                        <div class="d-flex justify-content-between
                    justify-content-lg-start align-items-center" style="font-size: 14px;">
                            <div class="">
                                <i class="fa-solid fa-phone me-2"></i>

                                <span class="me-4 d-none d-lg-block">
                                    {{get_general_value('phone')}}  </span>
                            </div>

                            <div class="">
                                <i class="fa-solid fa-envelope me-2"></i>

                                <span class="d-none d-lg-block">
                                   {{get_general_value('email')}} </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-7 col-lg-4 d-flex ">
                        <span style="font-size: 14px;" class="fs-sm">عميلنا العزيز يوجد كابون خصم 10٪ + توصيل
                            مجاني</span>
                    </div>

                    <div class="col-3 col-lg-4">
                        <div class="d-flex align-items-center">
                            @php
                            $currency = get_general_value('currancy');
                        
                            if ($currency == 'د.إ') {
                                $flag = 'flag.png';
                            } elseif ($currency == 'ر.س') {
                                $flag = 'sa-flag.jpeg';
                            } elseif ($currency == '$') {
                                $flag = 'usa-flag.png';
                            }elseif($currency == 'ر.ع'){
                                $flag='oman.jpg';
                            }elseif($currency == 'د.ك'){
                                $flag='kwt.png';
                            
                            }elseif($currency == 'ر.ق'){
                                $flag='qater.png';
                            
                             }elseif($currency == 'د.ب'){
                                $flag='bahreen.png';
                            }
                        @endphp
                        
                        <div class="d-flex align-items-center">
                            <img loading="lazy" src="{{ asset('front/assets/image/icons/' . $flag) }}" width="30" class="me-2" alt="">
                            <span class="me-2">|</span>
                            <span style="font-size: 13px;" class="me-4">{{ $currency }}</span>
                        </div>
                        
                            <a href="{{route('page','term')}}" style="font-size: 13px;" class="text-decoration-none text-white d-none d-lg-inline-block me-4">سياسة الخصوصية
                                والشروط والاحكام</a>
                            <a href="{{route('page','pay')}}" style="font-size: 13px;" class="text-decoration-none text-white d-none d-lg-inline-block ">طرق الدفع والأقساط</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-expand-lg main_menu py-0">
            <div class="container-fluid my-0">
                <a class="navbar-brand d-md-none bg-danger d-none d-md-block" href="/">
                    <img loading="lazy" src="{{asset('storage/'.get_general_value('web_logo'))}}" height="60" width="50" alt="" />
                </a>
                <div class="container d-md-none py-0">
                    <div class="d-flex align-items-center ">
                        <div>
                            <button class="btn d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                                <i class="fas fa-bars fa-xl" style="color: {{get_general_value('primary_color')}};"></i>
                            </button>
                        </div>
                        <div class="">
                            <a class="navbar-brand d-md-none  " href="/">
                                
                                <img loading="lazy" src="{{asset('storage/'.get_general_value('web_logo'))}}" width="150" height="50" alt="" />
                            </a>
                        </div>
                        <div>
                        </div>
                        <div class=" d-flex align-items-center ms-auto">
                            <!-- <a href="cart.php" class="nav-link position-relative p-0 d-md-none ">
                        <i class="fa-solid fa-bag-shopping" style="font-size: 20px;color:white"></i>
                            <span class="position-absolute top-0 start-0 ms-1 mt-1 translate-middle badge rounded-pill bg-dark text-light">
                                0
                            </span>
                        </a> -->


                            <a href="#" class="nav-link position-relative p-0 d-md-none me-2" style="width: 30px;height:30px;border-radius:50%;background-color:{{get_general_value('primary_color')}};text-align:center;line-height:15px;display:flex;justify-content:center;align-items:center">
                                <i class="fa-solid fa-user" style="font-size: 16px;color:white"></i>
                                <!-- <img  loading="lazy" src="{{asset('front/assets/image/icons/ecommerce_-_love_favorite-512.webp')}}" width="35" class="" alt="" /> -->
                                <!-- <span class="position-absolute top-0 start-0 ms-1 mt-1 translate-middle badge rounded-pill primaryColor">
                                0
                            </span> -->
                            </a>

                            <a href="{{route('cart.index')}}" class="nav-link position-relative d-md-none p-0" style="width: 30px;height:30px;border-radius:50%;background-color:{{get_general_value('primary_color')}};text-align:center;line-height:15px;display:flex;justify-content:center;align-items:center">
                                <!-- <img  loading="lazy" src="{{asset('front/assets/image/icons/ecommerce-latest.webp')}}" width="35" class="" alt="" /> -->
                                <i class="fa-solid fa-bag-shopping" style="font-size: 16px;color:white"></i>
                                <span style="    background-color: {{get_general_value('primary_color')}} 
                                    
                                    border: 2px solid black;
                                    width: 18px;
                                    height: 18px;
                                    border-radius: 50% !important;
                                    font-size: 12px;
                                    padding: 0;" class="position-absolute top-0 start-0 ms-1 mt-1 translate-middle badge rounded-pill text-white">
                                    0
                                </span> </a>
                        </div>
                    </div>
                </div>
                <div class="collapse navbar-collapse my-1" id="navbarSupportedContent" style="padding-top: 15px;">
                    <a class="navbar-brand d-md-block d-none ms-auto me-auto" href="/">
                        <img loading="lazy" src="{{asset('storage/'.get_general_value('web_logo'))}}" height="50" width="150" alt="" />
                    </a>
                    <button class="btn d-none d-lg-block" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample2" aria-controls="offcanvasExample">
                        <i class="fas fa-bars text-dark fa-xl"></i>
                    </button>
                    <form class="d-flex ms-auto me-auto searchForm" role="search">
                        <div class="input-group" style="position: relative;" dir="rtl">
                            <!-- <select aria-label="First name" class="form-control w-25">
                            <option value="" selected>جميع الفئات</option>
                        </select> -->
                            <input type="text" aria-label="Last name" class="form-control w-50 " style="text-indent: 25px;border-radius:6px ! important;background-color:{{get_general_value('primary_color')}};padding:10px;border:none ;" placeholder="أدخل كلمة البحث" />
                            <i class="fa-solid fa-magnifying-glass" style="position: absolute; right:15px; top:36%;color:#8b8b8b"></i>

                            <!-- <button class="input-group-text btn primaryColor px-4">
                        </button> -->
                        </div>
                    </form>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-auto me-auto">
                        <li class="nav-item mx-2 me-4 d-flex">
                            <a href="#" class="nav-link position-relative p-0" style="width: 40px;height:40px;border-radius:50%;background-color:{{get_general_value('primary_color')}};text-align:center;line-height:20px;display:flex;justify-content:center;align-items:center">
                                <i class="fa-solid fa-user" style="font-size: 20px;color:white"></i>
                                
                            </a>
                            <div class="d-flex " style="flex-direction: column;">
                                <span class="ms-2 text-black" style="font-size: 13px;">حسابي</span>
                                <span class="ms-2  text-black" style="font-size: 14px;">تسجيل الدخول</span>

                            </div>
                        </li>
                        <li class="nav-item mx-2 d-flex">
                            <a href="{{ route('cart.index') }}" class="nav-link position-relative p-0" style="width: 40px;height:40px;border-radius:50%;background-color:{{get_general_value('primary_color')}};text-align:center;line-height:20px;display:flex;justify-content:center;align-items:center">
                                <i class="fa-solid fa-bag-shopping" style="font-size: 20px;color:white"></i>
                                <span style="background-color:  {{get_general_value('primary_color')}}; border: 2px solid black; width: 18px; height: 18px; border-radius: 50% !important; font-size: 12px; padding: 0;" class="position-absolute top-0 start-0 ms-1 mt-1 translate-middle badge rounded-pill text-white">
                                    {{ count(session('cart', [])) }}
                                </span>
                            </a>
                            <span class="ms-2 text-black" style="font-size: 13px;">السلة</span>
                        </li>
                        
                        <!-- <li class="nav-item mx-2">
                        <a href="#" class="nav-link position-relative p-0">
                            <img  loading="lazy" src="{{asset('front/assets/image/icons/language-latest.webp')}}" width="35" class="" alt="" />
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a href="controlPanel/login.php" class="nav-link position-relative p-0">
                            <img  loading="lazy" src="{{asset('front/assets/image/icons/header-account-image-line-512.webp')}}" width="35" class="" alt="" />
                        </a>
                    </li> -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="main_menu d-md-block d-none">
            <div class="container">
                <ul class="nav py-2" dir="rtl">
                    <li class="nav-item">
                    </li>
                </ul>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light navbar-dark shadow d-none" style="background-color: {{get_general_value('primary_color')}};">
            <div class="container">
                <!-- <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-content">
                <div class="hamburger-toggle">
                    <div class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </button> -->
                <div class="collapse navbar-collapse" id="navbar-content">
                    <ul class="navbar-nav mr-auto mb-2 mb-lg-0">

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">قسم الالعاب</a>
                            <ul class="dropdown-menu shadow">


                                <li class="dropend">
                                    <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">Submenu Right</a>
                                    <ul class="dropdown-menu shadow">
                                        <li><a class="dropdown-item" href="#"> Second level 1</a></li>
                                        <li><a class="dropdown-item" href="#"> Second level 2</a></li>
                                        <li><a class="dropdown-item" href="#"> Second level 3</a></li>
                                        <li class="dropend">
                                            <a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown">Let's go deeper!</a>
                                            <ul class="dropdown-menu dropdown-submenu shadow">
                                                <li><a class="dropdown-item" href="#"> Third level 1</a></li>
                                                <li><a class="dropdown-item" href="#"> Third level 2</a></li>
                                                <li><a class="dropdown-item" href="#"> Third level 3</a></li>
                                                <li><a class="dropdown-item" href="#"> Third level 4</a></li>
                                                <li><a class="dropdown-item" href="#"> Third level 5</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="dropdown-item" href="#"> Third level 5</a></li>
                                    </ul>
                                </li>

                                <li><a class="dropdown-item" href="#">Gallery</a></li>
                                <li><a class="dropdown-item" href="blog.html">Blog</a></li>
                            </ul>
                        </li>



                    </ul>

                </div>
            </div>
        </nav>



        <aside>
            <div class="offcanvas offcanvas-bottom h-75 rounded-3 mx-1" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <div class="offcanvas-title fw-bold">
                        فئات المنتجات
                    </div>
                    <button type="button" class="btn-close bg-danger" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body mt-2">

                    <div class="accordion accordion-flush" id="sections">

                        <div class="py-3 border-bottom">
                            <a href="/" class="text-decoration-none text-dark">
                                الرئيسية
                            </a>
                        </div>
                        @foreach (App\Models\Category::has('subcategories')->get() as $index => $category)
                        <div class="accordion-item border-bottom">
                            <h2 class="accordion-header" id="flush-heading{{ $index }}">
                                <button class="accordion-button collapsed px-0" type="button" data-bs-toggle="collapse" data-bs-target="#section{{ $index }}" aria-expanded="false" aria-controls="section{{ $index }}">
                                    {{ $category->name }}
                                </button>
                            </h2>
                            <div id="section{{ $index }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $index }}" data-bs-parent="#sections">
                                <div class="accordion-body">
                                    <div class="accordion accordion-flush" id="categories">
                                        @foreach ($category->subcategories as $subcategory)
                                            <div class="py-3 border-bottom">
                                                <a href="{{route('category.slug',$subcategory->slug)}}" class="text-decoration-none text-dark">
                                                    {{ $subcategory->name }}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            
                    </div>
                </div>
            </div>
        </aside>


        <aside>
            <div class="offcanvas offcanvas2 offcanvas-right h-75 rounded-3 mx-1 d-none d-lg-block" style="width: 30% !important;height: 100% !important;right: -5px;border-radius: 0 !important;" tabindex="-1" id="offcanvasExample2" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <div class="offcanvas-title fw-bold">
                        فئات المنتجات
                    </div>
                    <button type="button" style="    border-radius: 50%;
    background-color: #ed4555 !important;opacity:1 !important" class="btn-close bg-danger" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body mt-2">

                    <div class="accordion accordion-flush" id="sections">

                        <div class="py-3 border-bottom">
                            <a href="/" class="text-decoration-none text-dark">
                                الرئيسية
                            </a>
                        </div>
                        @foreach (App\Models\Category::has('subcategories')->get() as $index => $category)
                        <div class="accordion-item border-bottom">
                            <h2 class="accordion-header" id="flush-heading{{ $index }}">
                                <button class="accordion-button collapsed px-0" type="button" data-bs-toggle="collapse" data-bs-target="#section{{ $index }}" aria-expanded="false" aria-controls="section{{ $index }}">
                                    {{ $category->name }}
                                </button>
                            </h2>
                            <div id="section{{ $index }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $index }}" data-bs-parent="#sections">
                                <div class="accordion-body">
                                    <div class="accordion accordion-flush" id="categories">
                                        @foreach ($category->subcategories as $subcategory)
                                            <div class="py-3 border-bottom">
                                                <a href="{{route('category.slug',$subcategory->slug)}}" class="text-decoration-none text-dark">
                                                    {{ $subcategory->name }}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            
                    </div>
                </div>
            </div>
        </aside>
    </header>