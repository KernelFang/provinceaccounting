<x-guest-layout>
    <x-slot name="style">
        <style>
            .owl-carousel .owl-item {
                transition: transform 1s ease;
            }
        </style>
    </x-slot>

    <!-- Society Banner -->
    <section class="hero-home4 pb-0 pt80">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6">
                    <div class="pr30 pr0-lg mb30-md position-relative">
                        <h1 class="animate-up-1 mb25 text-thm2">
                            Welcome to Your<br class="d-none d-xl-block"> Gen Z Travels Portal
                        </h1>
                        <p class="text-dark">
                            Manage your property, pay monthly charges, and stay updated with society announcements — all
                            in one place.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="home5-hero-content welcome-home-slider position-relative">
                        <div class="main-banner-wrapper home9-hero-content">
                            <div
                                class="navi_pagi_vertical_right dots_nav_light banner-style-one slider-1-grid owl-theme owl-carousel">
                                <!-- Each slide with an image -->
                                <div class="slide slide-one animate-up-1 bounce-x w-100">
                                    <img src="{{ asset('theme/v1/images/banner/hero-banner-1.jpg') }}" alt="Slide 1"
                                        class="w-100">
                                </div>
                                <div class="slide slide-one animate-up-1 bounce-x w-100">
                                    <img src="{{ asset('theme/v1/images/banner/hero-banner-2.jpg') }}" alt="Slide 2"
                                        class="w-100">
                                </div>
                                <div class="slide slide-one animate-up-1 bounce-x w-100">
                                    <img src="{{ asset('theme/v1/images/banner/hero-banner-3.jpg') }}" alt="Slide 3"
                                        class="w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Welcome Section -->
    <section class="our-features p-5 pb90">
        <div class="container wow fadeInUp">
            <div class="row justify-content-center text-center align-items-center">
                <div class="col-lg-8">
                    <!-- Title & Description -->
                    <div class="main-title mb-4">
                        <h2 class="fw-bold">Welcome to Gen Z Travels Our Community</h2>
                        <p class="lead">Built on connection, growth, and shared purpose. Let’s collaborate and make a
                            difference together.</p>
                    </div>

                    <!-- Logo Image -->
                    <div class="animate-up-1 bounce-y w-100">
                        <img src="{{ asset('theme/v1/images/white-bg-logo.png') }}" alt="Community Logo"
                            class="img-fluid" style="max-width: 500px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Executive Committee Section -->
    <section class="pt90 pb60">
        <div class="container wow fadeInUp">
            <div class="row">
                <div class="col-lg-12 mb50">
                    <div class="main-title text-center">
                        <h2>Present Executive Committee</h2>
                        <p class="text">Our president and committee members play an essential role in guiding the
                            society's growth and vision.
                            Below is the list of current members.</p>
                    </div>
                </div>
            </div>
            <!-- Executive Committee Members -->
            <div class="row">
                @foreach ($committees as $committee)
                    <div class="col-md-12 mb-4">
                        <!-- Category Name (e.g., Leadership Team) -->
                        <h3 class="text-center mb-4">{{ $committee->category }}</h3>

                        <!-- List of Members under this category -->
                        <div class="row justify-content-center">
                            @foreach ($committee->members as $member)
                                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                                    <div class="freelancer-style1 text-center bdr1 hover-box-shadow">
                                        <div class="thumb w100 mb25 mx-auto position-relative rounded-circle">
                                            @php
                                                $photoPath = public_path('theme/v1/images/committee/' . $member->photo);
                                                $photo = file_exists($photoPath)
                                                    ? 'theme/v1/images/committee/' . $member->photo
                                                    : 'theme/v1/images/resource/user.png';
                                            @endphp
                                            <img class="committee-image rounded-circle mx-auto"
                                                src="{{ asset($photo) }}" alt="{{ $member->name }}" width="150px">
                                        </div>
                                        <div class="details">
                                            <h5 class="title mb-1">{{ $member->name }}</h5>
                                            <p class="mb-0 small">{{ $member->position }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Our Services -->
    <section class="our-features pb90 pb30-md">
        <div class="container wow fadeInUp">
            <div class="row">
                <div class="col-lg-12 mb50">
                    <div class="main-title text-center">
                        <h2>Our Services</h2>
                        <p class="text">Essential services for all residents and property owners</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Security -->
                <div class="col-sm-6 col-lg-3">
                    <div class="iconbox-style1 at-home4 p-0 text-center">
                        <div class="icon before-none"><i class="fas fa-shield-alt"></i></div>
                        <div class="details">
                            <h4 class="title mt10 mb-3">Security</h4>
                            <p class="text">The safety of our residents is our top priority. We have 24/7 security
                                guards stationed throughout the area.</p>
                        </div>
                    </div>
                </div>
                <!-- Maintenance and Repair -->
                <div class="col-sm-6 col-lg-3">
                    <div class="iconbox-style1 at-home4 p-0 text-center">
                        <div class="icon before-none"><i class="fas fa-tools"></i></div>
                        <div class="details">
                            <h4 class="title mt10 mb-3">Maintenance and Repair</h4>
                            <p class="text">Comprehensive maintenance of common areas, plumbing, electrical repairs,
                                landscaping, cleaning, and pest control services.</p>
                        </div>
                    </div>
                </div>
                <!-- Administrative Services -->
                <div class="col-sm-6 col-lg-3">
                    <div class="iconbox-style1 at-home4 p-0 text-center">
                        <div class="icon before-none"><i class="fas fa-cogs"></i></div>
                        <div class="details">
                            <h4 class="title mt10 mb-3">Administrative Services</h4>
                            <p class="text">Collection of maintenance fees, budgets, and organizing regular resident
                                meetings.</p>
                        </div>
                    </div>
                </div>
                <!-- Community Events -->
                <div class="col-sm-6 col-lg-3">
                    <div class="iconbox-style1 at-home4 p-0 text-center">
                        <div class="icon before-none"><i class="fas fa-users"></i></div>
                        <div class="details">
                            <h4 class="title mt10 mb-3">Community Events</h4>
                            <p class="text">Organizing community events and activities to engage with the residents
                                and foster a strong neighborhood.</p>
                        </div>
                    </div>
                </div>
                <!-- Emergency Response -->
                <div class="col-sm-6 col-lg-3">
                    <div class="iconbox-style1 at-home4 p-0 text-center">
                        <div class="icon before-none"><i class="fas fa-ambulance"></i></div>
                        <div class="details">
                            <h4 class="title mt10 mb-3">Emergency Response</h4>
                            <p class="text">First-aid, emergency contacts, and medical assistance for resident
                                security and emergency response.</p>
                        </div>
                    </div>
                </div>
                <!-- Dispute Resolution -->
                <div class="col-sm-6 col-lg-3">
                    <div class="iconbox-style1 at-home4 p-0 text-center">
                        <div class="icon before-none"><i class="fas fa-balance-scale"></i></div>
                        <div class="details">
                            <h4 class="title mt10 mb-3">Dispute Resolution</h4>
                            <p class="text">Mediation services to resolve conflicts between residents to maintain
                                community harmony.</p>
                        </div>
                    </div>
                </div>
                <!-- Youth Club -->
                <div class="col-sm-6 col-lg-3">
                    <div class="iconbox-style1 at-home4 p-0 text-center">
                        <div class="icon before-none"><i class="fas fa-users-cog"></i></div>
                        <div class="details">
                            <h4 class="title mt10 mb-3">Youth Club</h4>
                            <p class="text">The SBYC empowers youth through community service, sports, and leadership
                                activities, fostering growth and collaboration.</p>
                        </div>
                    </div>
                </div>
                <!-- Legal Assistance -->
                <div class="col-sm-6 col-lg-3">
                    <div class="iconbox-style1 at-home4 p-0 text-center">
                        <div class="icon before-none"><i class="fas fa-gavel"></i></div>
                        <div class="details">
                            <h4 class="title mt10 mb-3">Legal Assistance</h4>
                            <p class="text">Legal support for property management and compliance with local
                                regulations for all residents.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Features -->
    <section class="our-features pb90 pb30-md">
        <div class="container wow fadeInUp">
            <div class="row">
                <div class="col-lg-12 mb50">
                    <div class="main-title text-center">
                        <h2>Features for Gen Z Travels</h2>
                        <p class="text">Explore the key features that make Gen Z Travels a unique and
                            thriving community.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- School -->
                <div class="col-sm-6 col-lg-3">
                    <div class="iconbox-style1 at-home4 p-0 text-center">
                        <div class="icon before-none"><i class="fas fa-shield-alt"></i></div>
                        <div class="details">
                            <h4 class="title mt10 mb-3">Siraj Mia Memorial Model School</h4>
                            <p class="text">Siraj Mia Memorial Model School, founded by <strong>MD. Monir
                                    Hossain</strong>, offers
                                quality education to nurture brilliant individuals who will enrich society.</p>
                        </div>
                    </div>
                </div>
                <!-- Masjid -->
                <div class="col-sm-6 col-lg-3">
                    <div class="iconbox-style1 at-home4 p-0 text-center">
                        <div class="icon before-none"><i class="fas fa-tools"></i></div>
                        <div class="details">
                            <h4 class="title mt10 mb-3">Baitur Rahman Jame Masjid</h4>
                            <p class="text">Baitur Rahman Jame Masjid is a place of worship dedicated to spiritual
                                growth and community enrichment. It serves as a hub for faith, unity, and service to
                                society.</p>
                        </div>
                    </div>
                </div>
                <!-- Madrasha -->
                <div class="col-sm-6 col-lg-3">
                    <div class="iconbox-style1 at-home4 p-0 text-center">
                        <div class="icon before-none"><i class="fas fa-cogs"></i></div>
                        <div class="details">
                            <h4 class="title mt10 mb-3">Tawhidul Ulum Madrasha and Atim Khana</h4>
                            <p class="text">Tawhidul Ulum Madrasha and Atim Khana, managed by Muatalli MD. Monir
                                Hossain, provide Islamic education and care for orphans.</p>
                        </div>
                    </div>
                </div>
                <!-- Playground and Walkway -->
                <div class="col-sm-6 col-lg-3">
                    <div class="iconbox-style1 at-home4 p-0 text-center">
                        <div class="icon before-none"><i class="fas fa-users"></i></div>
                        <div class="details">
                            <h4 class="title mt10 mb-3">Playground and Walkway</h4>
                            <p class="text">The community’s playground and walkway offer a safe and welcoming space
                                for physical activity, relaxation, and community interaction.</p>
                        </div>
                    </div>
                </div>
                <!-- Youth Club -->
                <div class="col-sm-6 col-lg-3">
                    <div class="iconbox-style1 at-home4 p-0 text-center">
                        <div class="icon before-none"><i class="fas fa-ambulance"></i></div>
                        <div class="details">
                            <h4 class="title mt10 mb-3">Youth Club</h4>
                            <p class="text">A platform for empowering youth through community development, sports,
                                leadership training, and social responsibility initiatives.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About the Society -->
    <section class="pt150 pt60-lg pb60-lg pb30-md">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6">
                    <div class="home4-about-1 position-relative">
                        <img class="w-100 mb30-md" src="{{ asset('theme/v1/images/about/about.jpg') }}"
                            alt="">
                        <img src="{{ asset('theme/v1/images/about/south-baridhara-society.png') }}" alt=""
                            class="bounce-x img-1 default-box-shadow4">
                    </div>
                </div>
                <div class="col-lg-6 col-xl-5">
                    <div class="mb30">
                        <h2 class="title mb30">About Gen Z Travels</h2>
                        <p class="text">
                            Welcome to Gen Z Travels – a community focused on fostering a safe, clean, and
                            inclusive environment for all residents. Established in 2004, Gen Z Travels has
                            grown into a well-knit and vibrant neighborhood.
                        </p>
                        <p class="text">
                            Our mission is to enhance the quality of life through efficient services, environmental
                            sustainability, and community-driven initiatives. From transparent financial management to
                            timely support services, we aim to make every resident feel at home and heard.
                        </p>
                        <div class="list-style2">
                            <ul class="mb25">
                                <li><i class="far fa-check"></i>Established and thriving since 2004</li>
                                <li><i class="far fa-check"></i>Focus on safety, cleanliness, and inclusivity</li>
                                <li><i class="far fa-check"></i>Resident-first digital services and support</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- our blog section -->
    {{-- <div class="container">
        <div class="row align-items-center wow fadeInUp" data-wow-delay="00ms"
            style="visibility: visible; animation-delay: 0ms; animation-name: fadeInUp;">
            <div class="col-lg-9">
                <div class="main-title">
                    <h2 class="title">Our Blog</h2>
                    <p class="paragraph">Aliquam lacinia diam quis lacus euismod</p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="text-start text-lg-end mb-4 mb-lg-2">
                    <a class="ud-btn2" href="page-blog-v1.html">All Categories<i
                            class="fal fa-arrow-right-long"></i></a>
                </div>
            </div>
        </div>
        <div class="row wow fadeInUp" data-wow-delay="300ms"
            style="visibility: visible; animation-delay: 300ms; animation-name: fadeInUp;">
            <div class="col-sm-6 col-xl-3">
                <div class="blog-style1 bdr1 at-home5 overflow-hidden">
                    <div class="blog-img"><img class="w-100" src="theme/v1/images/blog/blog-1.jpg" alt=""></div>
                    <div class="blog-content">
                        <a class="date" href="">December 2, 2022</a>
                        <h4 class="title mt-1"><a href="page-blog-single.html">Start an online business and work from
                                home</a></h4>
                        <p class="text mb-0">A complete guide to starting a small business online</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="blog-style1 bdr1 at-home5 overflow-hidden">
                    <div class="blog-img"><img class="w-100" src="theme/v1/images/blog/blog-2.jpg" alt=""></div>
                    <div class="blog-content">
                        <a class="date" href="">December 2, 2022</a>
                        <h4 class="title mt-1"><a href="page-blog-single.html">Front becomes an official Instagram
                                Marketing Partner</a></h4>
                        <p class="text mb-0">A complete guide to starting a small business online</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="blog-style1 bdr1 at-home5 overflow-hidden">
                    <div class="blog-img"><img class="w-100" src="theme/v1/images/blog/blog-3.jpg" alt=""></div>
                    <div class="blog-content">
                        <a class="date" href="">December 2, 2022</a>
                        <h4 class="title mt-1"><a href="page-blog-single.html">Engendering a culture of professional
                                development</a></h4>
                        <p class="text mb-0">A complete guide to starting a small business online</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="blog-style1 bdr1 at-home5 overflow-hidden">
                    <div class="blog-img"><img class="w-100" src="theme/v1/images/blog/blog-4.jpg" alt=""></div>
                    <div class="blog-content">
                        <a class="date" href="">December 2, 2022</a>
                        <h4 class="title mt-1"><a href="page-blog-single.html">Increasing engagement with
                                Instagram</a></h4>
                        <p class="text mb-0">A complete guide to starting a small business online</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Inject custom JavaScript via slot -->
    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('.owl-carousel').trigger('play.owl.autoplay', [8000, 3000]);
            });
        </script>
    </x-slot>
</x-guest-layout>
