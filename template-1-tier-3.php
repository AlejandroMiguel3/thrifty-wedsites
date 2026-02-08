<?php
$site_id = get_post_meta(get_the_ID(), 'reference_id');

$args = array(
    'post_type'      => 'tws_order',
    'posts_per_page' => 1,
    'meta_query'     => array(
        array(
            'key'     => 'reference_id',
            'value'   => $site_id,
            'compare' => '='
        )
    )
);

$orders = get_posts($args);

$meta_fields = [];

if (!empty($orders)) {
    $order_id = $orders[0]->ID;
    $meta_fields = tws_load_order_meta($order_id);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catie & Michael | Our Wedding</title>
  <!-- FAVICON placeholder - will be updated by CONFIG -->
  <link id="dynamic-favicon" rel="icon" type="image/svg+xml" href="">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Great+Vibes&family=Inter:wght@300;400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@300;400;600&family=Italiana&display=swap" rel="stylesheet">
  <style>
    .font-serif-classic { font-family: 'Cormorant Garamond', serif; }
    .font-serif-luxury { font-family: 'Italiana', serif; }
    .font-script { font-family: 'Great Vibes', cursive; }
    .font-sans-clean { font-family: 'Inter', sans-serif; }

    :root { 
      --primary: #D4AF37; 
      --bg: #FDFCFB; 
      --pina: #fcfaf5;
      --easing: cubic-bezier(0.23, 1, 0.32, 1);
      --transition-speed: 0.8s;
    }

    html { scroll-behavior: smooth; }
    section { scroll-margin-top: 80px; }
    body { background-color: var(--bg); color: #1a1a1a; transition: background-color 0.5s ease; -webkit-font-smoothing: antialiased; }
    .text-primary { color: var(--primary); }
    .bg-primary { background-color: var(--primary); }
    .border-primary { border-color: var(--primary); }

    .reveal { 
      opacity: 0; 
      transform: translateY(30px); 
      transition: opacity var(--transition-speed) var(--easing), 
                  transform var(--transition-speed) var(--easing); 
      will-change: transform, opacity;
    }
    .reveal.active { 
      opacity: 1; 
      transform: translateY(0); 
    }

    .bg-pattern-sampaguita { 
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 5c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm-15 15c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm30 0c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM15 45c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm30 0c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5z' fill='%23d4af37' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E"); 
    }

    /* REFINED LOADER */
    #loading-screen { background: var(--bg); }
    #loading-screen .panel { 
      transition: transform 2s cubic-bezier(0.19, 1, 0.22, 1);
      background-color: var(--pina);
      background-image: url("https://www.transparenttextures.com/patterns/natural-paper.png");
    }
    .panel-left { background: linear-gradient(to right, var(--bg), var(--pina)); box-shadow: inset -1px 0 0 rgba(212, 175, 55, 0.05); }
    .panel-right { background: linear-gradient(to left, var(--bg), var(--pina)); box-shadow: inset 1px 0 0 rgba(212, 175, 55, 0.05); }
    .panel::after { content: ''; position: absolute; inset: 2rem; border: 1px solid rgba(212, 175, 55, 0.03); pointer-events: none; }
    @media (min-width: 768px) { .panel::after { inset: 3.5rem; } }
    
    #loading-screen.is-opening .panel-left { transform: translateX(-101%); }
    #loading-screen.is-opening .panel-right { transform: translateX(101%); }
    #loading-content { transition: opacity 1s ease, transform 1s var(--easing); }

    #main-content {
      transition: opacity 1.5s var(--easing), transform 1.5s var(--easing);
    }

    /* MASONRY */
    .masonry-grid { columns: 1; column-gap: 1.5rem; }
    @media (min-width: 640px) { .masonry-grid { columns: 2; } }
    @media (min-width: 1024px) { .masonry-grid { columns: 3; } }
    .masonry-item {
      display: inline-block; width: 100%; margin-bottom: 1.5rem; break-inside: avoid; border-radius: 0.5rem;
      overflow: hidden; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05); transition: transform 0.4s var(--easing);
    }
    .masonry-item img { width: 100%; height: auto; display: block; transition: transform 0.8s var(--easing); }
    .masonry-item:hover img { transform: scale(1.05); }

    .btn-luxury { position: relative; overflow: hidden; transition: all 0.4s var(--easing); }
    .btn-luxury::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: 0.6s; }
    .btn-luxury:hover::before { left: 100%; }

    #scroll-progress { position: fixed; top: 0; left: 0; height: 2px; background: var(--primary); z-index: 100; width: 0%; transition: width 0.1s linear; }

    .premium-image-wrapper { position: relative; display: inline-block; width: 100%; max-width: 480px; }
    .floating-frame { position: absolute; inset: -10px; border: 1px solid var(--primary); opacity: 0.25; pointer-events: none; z-index: -1; transition: transform 0.6s var(--easing); }
    @media (min-width: 768px) { .floating-frame { inset: -20px; } }
    .premium-image-wrapper:hover .floating-frame { transform: translate(10px, 10px); opacity: 0.5; }
    .image-container { position: relative; background: #fdfcfb; overflow: hidden; box-shadow: 0 15px 45px -20px rgba(0,0,0,0.12); }

    .editorial-cap { font-size: 3.5rem; float: left; line-height: 1; margin-right: 0.75rem; margin-top: 0.25rem; color: var(--primary); font-family: 'Italiana', serif; }
    @media (min-width: 768px) { .editorial-cap { font-size: 4rem; } }

    .story-v-line { width: 1px; height: 60px; background: linear-gradient(to bottom, transparent, var(--primary), transparent); margin: 0 auto 2rem; opacity: 0.3; }
    @media (min-width: 768px) { .story-v-line { height: 80px; margin-bottom: 3rem; } }

    .divider-ornament { display: flex; align-items: center; gap: 1rem; margin: 1.5rem 0; }
    @media (min-width: 768px) { .divider-ornament { gap: 1.5rem; margin: 2rem 0; } }
    .divider-ornament span { width: 30px; height: 1px; background: var(--primary); opacity: 0.3; }
    @media (min-width: 768px) { .divider-ornament span { width: 40px; } }
    .divider-ornament i { color: var(--primary); font-style: normal; font-size: 0.8rem; opacity: 0.6; }

    .heading-accent { position: relative; display: inline-block; padding: 0 1rem; }
    @media (min-width: 768px) { .heading-accent { padding: 0 2rem; } }
    .heading-accent::before, .heading-accent::after { content: ''; position: absolute; top: 50%; width: 30px; height: 1px; background: linear-gradient(to right, transparent, var(--primary)); opacity: 0.2; }
    @media (min-width: 768px) { .heading-accent::before, .heading-accent::after { width: 60px; } }
    .heading-accent::before { left: -40px; }
    @media (min-width: 768px) { .heading-accent::before { left: -70px; } }
    .heading-accent::after { right: -40px; transform: rotate(180deg); }
    @media (min-width: 768px) { .heading-accent::after { right: -70px; } }

    /* TIMELINE REDESIGN */
    .timeline-container { position: relative; padding: 2rem 0; }
    .timeline-line { 
      position: absolute; 
      top: 0; 
      bottom: 0; 
      left: 1.5rem; 
      width: 1px; 
      background: linear-gradient(to bottom, transparent 0%, var(--primary) 15%, var(--primary) 85%, transparent 100%); 
      opacity: 0.15; 
      transform: translateX(-50%); 
    }
    @media (min-width: 768px) { .timeline-line { left: 50%; } }
    
    .timeline-nexus {
      position: absolute;
      top: 3.5rem;
      left: 1.5rem;
      width: 20px;
      height: 20px;
      transform: translate(-50%, -50%);
      z-index: 10;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    @media (min-width: 768px) { .timeline-nexus { left: 50%; width: 32px; height: 32px; top: 4.5rem; } }
    
    .nexus-outer {
      position: absolute;
      inset: 0;
      border: 1px solid var(--primary);
      border-radius: 50%;
      opacity: 0.3;
      animation: nexus-pulse 3s infinite ease-out;
    }
    .nexus-inner {
      width: 6px;
      height: 6px;
      background: var(--primary);
      border-radius: 50%;
      box-shadow: 0 0 15px var(--primary);
    }
    @media (min-width: 768px) { .nexus-inner { width: 8px; height: 8px; } }

    @keyframes nexus-pulse {
      0% { transform: scale(0.8); opacity: 0.5; }
      50% { transform: scale(1.1); opacity: 0.2; }
      100% { transform: scale(0.8); opacity: 0.5; }
    }

    .event-card {
      transition: all 0.6s var(--easing);
    }
    .event-card:hover {
      transform: translateY(-5px);
    }

    /* MOBILE NAV MENU */
    #mobile-menu {
      transform: translateX(100%);
      transition: transform 0.5s var(--easing);
    }
    #mobile-menu.active {
      transform: translateX(0);
    }

    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--primary); opacity: 0.5; border-radius: 10px; }
  </style>
<script type="importmap">
{
  "imports": {
    "@google/genai": "https://esm.sh/@google/genai@^1.40.0",
    "react/": "https://esm.sh/react@^19.2.4/",
    "react": "https://esm.sh/react@^19.2.4"
  }
}
</script>
</head>
<body class="bg-pattern-sampaguita overflow-x-hidden" style="background-color: #FDFCFB;">
<script>
  const orderMeta = <?php echo json_encode($meta_fields, JSON_PRETTY_PRINT); ?>;
  console.log(orderMeta);
</script>

  <div id="scroll-progress"></div>

  <!-- MINIMALIST PREMIUM LOADER -->
  <div id="loading-screen" class="fixed inset-0 z-[100] flex pointer-events-none">
    <div class="panel panel-left absolute inset-y-0 left-0 w-1/2 shadow-xl"></div>
    <div class="panel panel-right absolute inset-y-0 right-0 w-1/2 shadow-xl"></div>
    <div id="loading-content" class="absolute inset-0 flex flex-col items-center justify-center z-[110] px-6 text-center">
      <h1 class="font-script text-4xl sm:text-5xl md:text-7xl text-primary dyn-names opacity-0" style="transition: opacity 2s ease;">Catie & Michael</h1>
      <p class="mt-8 md:mt-12 font-serif-luxury tracking-[1em] sm:tracking-[1.5em] text-stone-400 text-[8px] uppercase opacity-0 dyn-loader-date" style="transition: opacity 2.5s ease;"></p>
    </div>
  </div>

  <!-- NAVIGATION -->
  <nav id="navbar" class="fixed top-0 left-0 right-0 z-40 px-6 sm:px-8 py-4 sm:py-5 flex justify-between items-center bg-transparent transition-all duration-700">
    <div class="font-serif-luxury text-xl sm:text-2xl font-bold tracking-tighter text-primary cursor-pointer nav-link dyn-initials" data-target="welcome">C & M</div>
    
    <!-- DESKTOP NAV -->
    <div id="nav-links" class="hidden lg:flex items-center space-x-8 text-[9px] uppercase tracking-[0.25em] opacity-60">
      <a href="#welcome" class="hover:opacity-100 transition-opacity nav-link">Welcome</a>
      <a href="#story" class="hover:opacity-100 transition-opacity nav-link">Story</a>
      <a href="#attire" class="hover:opacity-100 transition-opacity nav-link">Attire</a>
      <a href="#schedule" class="hover:opacity-100 transition-opacity nav-link">Schedule</a>
      <a href="#gallery" class="hover:opacity-100 transition-opacity nav-link">Gallery</a>
      <a href="#rsvp" class="hover:opacity-100 transition-opacity nav-link">RSVP</a>
    </div>

    <div class="flex items-center space-x-4">
      <a href="#rsvp" class="hidden sm:block btn-luxury px-6 py-2 text-[10px] tracking-widest uppercase border border-primary text-primary hover:bg-stone-900 hover:text-white hover:border-stone-900 nav-link">
        RSVP
      </a>
      <!-- MOBILE HAMBURGER -->
      <button id="menu-toggle" class="lg:hidden w-8 h-8 flex flex-col justify-center space-y-1.5 focus:outline-none z-50">
        <span class="w-full h-px bg-primary transition-all duration-300"></span>
        <span class="w-full h-px bg-primary transition-all duration-300"></span>
      </button>
    </div>
  </nav>

  <!-- MOBILE MENU OVERLAY -->
  <div id="mobile-menu" class="fixed inset-0 bg-white z-[45] flex flex-col items-center justify-center space-y-8 lg:hidden">
    <div class="absolute inset-0 -z-10 opacity-[0.03] flex items-center justify-center pointer-events-none overflow-hidden">
      <span class="font-serif-luxury text-[40vw] rotate-90 whitespace-nowrap leading-none uppercase select-none dyn-initials">C&M</span>
    </div>
    <a href="#welcome" class="nav-link-mobile font-serif-luxury text-3xl tracking-widest uppercase text-stone-400 hover:text-primary transition-colors">Welcome</a>
    <a href="#story" class="nav-link-mobile font-serif-luxury text-3xl tracking-widest uppercase text-stone-400 hover:text-primary transition-colors">Story</a>
    <a href="#attire" class="nav-link-mobile font-serif-luxury text-3xl tracking-widest uppercase text-stone-400 hover:text-primary transition-colors">Attire</a>
    <a href="#schedule" class="nav-link-mobile font-serif-luxury text-3xl tracking-widest uppercase text-stone-400 hover:text-primary transition-colors">Schedule</a>
    <a href="#gallery" class="nav-link-mobile font-serif-luxury text-3xl tracking-widest uppercase text-stone-400 hover:text-primary transition-colors">Gallery</a>
    <a href="#rsvp" class="nav-link-mobile font-serif-luxury text-3xl tracking-widest uppercase text-stone-400 hover:text-primary transition-colors">RSVP</a>
  </div>

  <main id="main-content" class="opacity-0 scale-105 pointer-events-none">
    
    <!-- HERO -->
    <section id="welcome" class="h-[100dvh] flex flex-col items-center justify-center text-center px-6 relative overflow-hidden">
      <div class="absolute inset-0 -z-10 opacity-[0.02] pointer-events-none flex items-center justify-center select-none overflow-hidden">
        <span class="font-serif-luxury text-[clamp(4rem,13vw,18rem)] uppercase tracking-tighter whitespace-nowrap leading-none px-4">FOREVER</span>
      </div>
      <p class="text-[8px] sm:text-[10px] uppercase tracking-[0.6em] sm:tracking-[1em] mb-6 sm:mb-8 font-light reveal text-stone-400 dyn-hero-detail"></p>
      <h1 class="font-script leading-tight mb-8 sm:mb-12 text-primary reveal text-6xl sm:text-8xl md:text-[10rem] lg:text-[12rem] delay-75 dyn-names"></h1>
      <div id="countdown" class="flex justify-center gap-6 sm:gap-16 reveal delay-150"></div>
    </section>

    <!-- OUR LOVE STORY -->
    <section id="story" class="py-16 sm:py-24 px-6 max-w-7xl mx-auto overflow-visible">
      <div class="reveal text-center mb-16 sm:mb-24">
        <div class="story-v-line"></div>
        <span class="text-[10px] uppercase tracking-[0.4em] opacity-40 block mb-2">Ang Aming Kwento</span>
        <h2 class="font-serif-luxury text-4xl sm:text-5xl md:text-8xl text-primary font-bold heading-accent mb-4">Our Love Story</h2>
        <p class="font-serif-classic italic opacity-50 text-lg sm:text-xl">A journey defined by grace and timeless devotion.</p>
      </div>
      <div id="story-container" class="space-y-24 sm:space-y-36"></div>
    </section>

    <!-- ATTIRE GUIDE -->
    <section id="attire" class="py-16 sm:py-24 px-6 bg-stone-50/50">
      <div class="max-w-5xl mx-auto text-center reveal">
        <span class="text-[10px] uppercase tracking-[0.6em] opacity-40 block mb-4">Gabay sa Kasuotan</span>
        <h2 class="font-serif-luxury text-4xl sm:text-6xl text-primary mb-6">Attire Guide</h2>
        <p class="font-serif-classic text-lg sm:text-xl italic opacity-60 mb-10 sm:mb-16">We invite you to celebrate with us in your most elegant formal attire.</p>
        
        <div class="grid md:grid-cols-2 gap-8 sm:gap-12">
          <div class="attire-card bg-white p-8 sm:p-12 shadow-sm border-t-4 border-primary rounded-xl">
            <h3 class="font-serif-luxury text-xl sm:text-2xl uppercase tracking-widest mb-6">For the Ladies</h3>
            <p class="text-[9px] sm:text-[10px] uppercase tracking-[0.3em] opacity-40 mb-4">Formal Floor-length Gown</p>
            <p class="font-serif-classic text-base sm:text-lg opacity-70 leading-relaxed dyn-attire-ladies"></p>
          </div>
          <div class="attire-card bg-white p-8 sm:p-12 shadow-sm border-t-4 border-primary rounded-xl">
            <h3 class="font-serif-luxury text-xl sm:text-2xl uppercase tracking-widest mb-6">For the Gentlemen</h3>
            <p class="text-[9px] sm:text-[10px] uppercase tracking-[0.3em] opacity-40 mb-4">Barong Tagalog or Suit</p>
            <p class="font-serif-classic text-base sm:text-lg opacity-70 leading-relaxed dyn-attire-gentlemen"></p>
          </div>
        </div>

        <div id="attire-colors" class="mt-10 sm:mt-16 flex flex-wrap justify-center gap-3 sm:gap-4"></div>
      </div>
    </section>

    <!-- SPONSORS -->
    <section id="sponsors" class="py-16 sm:py-24 px-6">
      <div class="max-w-4xl mx-auto text-center">
        <div class="reveal mb-12 sm:mb-20">
          <span class="text-[10px] uppercase tracking-[0.6em] opacity-40 block mb-4">Mga Saksi</span>
          <h2 class="font-serif-luxury text-4xl sm:text-6xl text-primary">Wedding Sponsors</h2>
        </div>
        <div class="space-y-16 sm:space-y-24">
          <div class="reveal">
            <h3 class="font-serif-luxury text-base sm:text-xl uppercase tracking-[0.5em] mb-8 sm:mb-10 opacity-40">Principal Sponsors</h3>
            <div id="principal-sponsors" class="grid grid-cols-1 md:grid-cols-2 gap-x-12 sm:gap-x-20 gap-y-6 font-serif-classic text-2xl sm:text-3xl"></div>
          </div>
          <div class="reveal delay-100">
            <h3 class="font-serif-luxury text-base sm:text-xl uppercase tracking-[0.5em] mb-8 sm:mb-10 opacity-40">Entourage</h3>
            <div id="secondary-sponsors" class="grid grid-cols-2 md:grid-cols-3 gap-8 sm:gap-12 font-serif-classic text-base sm:text-xl opacity-80"></div>
          </div>
        </div>
      </div>
    </section>

    <!-- SOUNDTRACK -->
    <section id="soundtrack" class="py-16 sm:py-24 px-6 bg-stone-900 text-stone-100">
      <div class="max-w-4xl mx-auto text-center reveal">
        <h2 class="font-serif-luxury text-3xl sm:text-5xl mb-10">The Soundtrack of Us</h2>
        <div id="spotify-container" class="max-w-lg mx-auto rounded-2xl overflow-hidden shadow-2xl border border-white/10 transition-transform duration-700 hover:scale-105"></div>
      </div>
    </section>

    <!-- ORDER OF EVENTS (REDESIGNED) -->
    <section id="schedule" class="py-16 sm:py-24 px-6">
      <div class="max-w-6xl mx-auto">
        <div class="reveal text-center mb-16 sm:mb-20">
          <span class="text-[10px] uppercase tracking-[0.6em] opacity-40 block mb-4">Daloy ng Pagdiriwang</span>
          <h2 class="font-serif-luxury text-4xl sm:text-6xl text-primary">Order of Events</h2>
        </div>
        <div class="timeline-container">
          <div class="timeline-line"></div>
          <div id="schedule-container" class="space-y-16 sm:space-y-24"></div>
        </div>
      </div>
    </section>

    <!-- PRENUP PHOTO GALLERY -->
    <section id="gallery" class="py-16 sm:py-24 px-6 bg-stone-50/30">
      <div class="max-w-7xl mx-auto">
        <div class="reveal text-center mb-12 sm:mb-16">
          <span class="text-[10px] uppercase tracking-[0.6em] opacity-40 block mb-4">Sulyap sa Kahapon</span>
          <h2 class="font-serif-luxury text-4xl sm:text-6xl text-primary">Prenup Gallery</h2>
        </div>
        <div id="masonry-container" class="masonry-grid reveal"></div>
      </div>
    </section>

    <!-- GIFT REGISTRY -->
    <section id="registry" class="py-16 sm:py-24 px-6 text-center">
      <div class="max-w-2xl mx-auto reveal">
        <span class="text-[10px] uppercase tracking-[0.6em] opacity-40 block mb-4">Pasasalamat</span>
        <h2 class="font-serif-luxury text-4xl sm:text-6xl text-primary mb-6">Gift Registry</h2>
        <p class="font-serif-classic text-lg sm:text-xl opacity-70 mb-10 sm:mb-12 leading-relaxed">Your presence at our wedding is the greatest gift of all. However, if you wish to honor us with a gift, a contribution towards our future home would be warmly appreciated.</p>
        <div id="registry-container" class="flex flex-col md:flex-row justify-center gap-6 sm:gap-8"></div>
      </div>
    </section>

    <!-- MAPS -->
    <section id="maps" class="h-[400px] sm:h-[500px] relative overflow-hidden">
      <div class="absolute inset-0 grayscale contrast-125 opacity-30">
        <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&q=80&w=2000" class="w-full h-full object-cover">
      </div>
      <div class="absolute inset-0 flex items-center justify-center p-6">
        <div class="bg-white p-8 sm:p-12 md:p-14 shadow-2xl rounded-2xl max-w-md text-center reveal border border-stone-50">
          <h2 class="font-serif-luxury text-3xl sm:text-4xl mb-4 text-primary">The Venue</h2>
          <p class="font-serif-classic text-xl sm:text-2xl mb-2 dyn-venue-name"></p>
          <p class="text-[8px] sm:text-[10px] tracking-[0.3em] uppercase opacity-40 mb-6 sm:mb-8 dyn-venue-location"></p>
          <a href="#" target="_blank" class="btn-luxury inline-block px-10 sm:px-12 py-4 bg-primary text-white text-[9px] sm:text-[10px] tracking-[0.4em] uppercase hover:bg-stone-900 dyn-maps-link">Open in Maps</a>
        </div>
      </div>
    </section>

    <!-- RSVP -->
    <section id="rsvp" class="py-16 sm:py-24 px-6 bg-white">
      <div class="max-w-2xl mx-auto bg-stone-50 p-10 sm:p-16 md:p-20 shadow-2xl border-t-4 border-primary reveal text-center rounded-b-xl">
        <h2 class="font-serif-luxury text-4xl sm:text-5xl mb-6">RSVP</h2>
        <p class="mb-8 sm:mb-10 text-[9px] sm:text-[10px] opacity-40 tracking-[0.4em] sm:tracking-[0.5em] uppercase">KINDLY RESPOND BY JANUARY 1, 2027</p>
        <a href="#" target="_blank" rel="noopener" class="btn-luxury w-full inline-block bg-primary text-white py-4 sm:py-5 text-[10px] tracking-[0.5em] uppercase hover:bg-stone-900 dyn-rsvp-link">RSVP Here</a>
      </div>
    </section>

    <footer class="py-12 sm:py-16 text-center opacity-30">
      <p class="font-script text-3xl sm:text-4xl mb-4 text-primary dyn-initials"></p>
      <p class="text-[8px] tracking-[0.4em] uppercase dyn-hashtag"></p>
    </footer>
  </main>

  <script type="module">
    const CONFIG = {
      "favicon": "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='0.85em' font-size='70' fill='%23D4AF37' font-family='serif' font-weight='bold'%3EC%3C/text%3E%3Ctext x='35' y='1.1em' font-size='40' fill='%23D4AF37' font-family='serif' opacity='0.6'%3E%26%3C/text%3E%3Ctext x='55' y='0.85em' font-size='70' fill='%23D4AF37' font-family='serif' font-weight='bold'%3EM%3C/text%3E%3C/svg%3E",
      "wedding_date": "2027-02-14T10:00:00",
      "city": "TAGAYTAY",
      "wedding_venue": "The Hillside Garden, Tagaytay City, Cavite",
      "bride_first_name": "Catie",
      "groom_first_name": "Michael",
      "initials": "C & M",
      "first_encounter": {
        "content": "In the quiet corners of an old library, a single glance became a lifetime of shared stories. A chance meeting that blossomed into a beautiful friendship, and eventually, a promise that would last through the ages.",
        "img": "https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&q=80&w=1200"
      },
      "proposal": {
        "content": "Beneath the vast, starlit canopy of the Tagaytay sky, amidst the cool evening breeze, he asked the question that resonated in the depths of their souls. It was a moment of pure magic, marking the beginning of their eternal unity.",
        "img": "https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?auto=format&fit=crop&q=80&w=1200"
      },
      "attire_ladies": "We recommend elegant gowns in shades of <span class='text-primary font-bold'>Champagne</span>, <span class='text-primary font-bold'>Sage Green</span>, or Earth tones. Please avoid wearing white or ivory.",
      "attire_gentlemen": "Traditional <span class='text-primary font-bold'>Barong Tagalog</span> or a clean-cut <span class='text-primary font-bold'>Dark Suit</span>. Formal leather shoes are highly encouraged.",
      "attire_colors": ["#F7E7CE", "#BCB88A", "#E0D5C1", "#D4AF37"],
      "principal_sponsors": ["Mr. & Mrs. Antonio Dela Cruz", "Mr. & Mrs. Roberto Santos"],
      "best_man": "John Benedict Doe",
      "maid_of_honor": "Ma. Jane Isabella Smith",
      "groomsmen": [
        "David Christopher Lim"
      ],
      "bridesmaids": [
        "Sofia Maria Reyes"
      ],
      "soundtrack_link": "https://open.spotify.com/embed/playlist/49wHubftRzuuq6KbAEcsLt",
      "order_of_events": [
        { "time": "10:00 AM", "title": "Processional", "description": "The elegant arrival of the wedding party and our beloved guests." },
        { "time": "10:30 AM", "title": "Holy Matrimony", "description": "A sacred exchange of vows and rings as we become one." },
        { "time": "12:00 PM", "title": "Cocktail Hour", "description": "Light refreshments and joyous captures under the Tagaytay sun." },
        { "time": "01:30 PM", "title": "Reception & Feast", "description": "A grand celebration of love with dining, toasts, and dancing." }
      ],
      "prenup_photos": [
        { "url": "https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=800" },
        { "url": "https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=800" },
        { "url": "https://images.unsplash.com/photo-1532712938310-34cb3982ef74?q=80&w=800" },
        { "url": "https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=800" },
        { "url": "https://images.unsplash.com/photo-1519225497282-1034d440056a?q=80&w=800" },
        { "url": "https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?q=80&w=800" }
      ],
      "registry_items": {
        "method": "GCash / Digital Bank",
        "accountNumber": "0917 123 4567",
        "accountHolder": "Michael R.",
        "link": "#",
        "label": "Visit Registry"
      },
      "rsvp_link": "#",
      "maps_link": "https://maps.app.goo.gl/UeNWecveaQrncVmF9",
      "hashtag": "#CatieAndMichael2027"
    };

    let countdownInterval;

    function startLoadingSequence() {
      const loader = document.getElementById('loading-screen');
      const content = document.getElementById('main-content');
      const text = document.getElementById('loading-content');
      const names = text.querySelector('h1');
      const date = text.querySelector('p');

      if (!loader || !content) return;

      // Start by showing text
      setTimeout(() => { 
        if (names) names.style.opacity = '1';
        if (date) date.style.opacity = '0.4';
      }, 300);

      // Fade out text early
      setTimeout(() => { 
        if (text) { 
          text.style.opacity = '0'; 
          text.style.transform = 'translateY(-12px)'; 
        } 
      }, 1800);

      // Split panels
      setTimeout(() => { loader.classList.add('is-opening'); }, 2200);

      // Reveal content
      setTimeout(() => { 
        content.classList.remove('opacity-0', 'scale-105');
        content.classList.add('opacity-100', 'scale-100');
        content.style.pointerEvents = 'auto';
        loader.style.display = 'none'; 
        initScrollObservers(); 
      }, 3000);
    }

    function initMobileNav() {
      const toggle = document.getElementById('menu-toggle');
      const menu = document.getElementById('mobile-menu');
      if (!toggle || !menu) return;

      toggle.addEventListener('click', () => {
        menu.classList.toggle('active');
        const spans = toggle.querySelectorAll('span');
        if (menu.classList.contains('active')) {
          spans[0].style.transform = 'translateY(4px) rotate(45deg)';
          spans[1].style.transform = 'translateY(-3px) rotate(-45deg)';
        } else {
          spans[0].style.transform = 'none';
          spans[1].style.transform = 'none';
        }
      });

      document.querySelectorAll('.nav-link-mobile').forEach(link => {
        link.addEventListener('click', () => {
          menu.classList.remove('active');
          const spans = toggle.querySelectorAll('span');
          spans[0].style.transform = 'none';
          spans[1].style.transform = 'none';
        });
      });
    }

    function initScrollObservers() {
      const observer = new IntersectionObserver(entries => {
        entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('active'); });
      }, { threshold: 0.1 });
      document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
      
      const nav = document.getElementById('navbar');
      const progress = document.getElementById('scroll-progress');
      window.addEventListener('scroll', () => {
        const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
        if (progress) progress.style.width = scrolled + "%";
        if (nav) {
            if (window.scrollY > 50) { 
              nav.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-sm', 'py-3'); 
              nav.classList.remove('py-4', 'sm:py-5'); 
            } 
            else { 
              nav.classList.remove('bg-white/90', 'backdrop-blur-md', 'shadow-sm', 'py-3'); 
              nav.classList.add('py-4', 'sm:py-5'); 
            }
        }
      }, { passive: true });
      
      document.querySelectorAll('.nav-link, .nav-link-mobile').forEach(link => {
        link.addEventListener('click', (e) => {
          e.preventDefault();
          const targetId = link.getAttribute('href')?.replace('#', '') || link.dataset.target;
          const targetElement = document.getElementById(targetId);
          if (targetElement) {
            const offset = 80;
            const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - offset;
            window.scrollTo({ top: targetPosition, behavior: 'smooth' });
          }
        });
      });
    }

    function initCountdown(targetDate) {
      const target = new Date(targetDate).getTime();
      const el = document.getElementById('countdown');
      if (!el || isNaN(target)) return;
      if (countdownInterval) clearInterval(countdownInterval);
      countdownInterval = setInterval(() => {
        const now = new Date().getTime();
        const diff = target - now;
        if (diff < 0) { el.innerHTML = '<div class="text-serif-luxury text-primary text-xl">TODAY IS THE DAY</div>'; clearInterval(countdownInterval); return; }
        const d = Math.floor(diff / (1000 * 60 * 60 * 24));
        const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        el.innerHTML = `
          <div class="text-center"><div class="text-3xl sm:text-5xl font-serif-luxury text-primary">${d}</div><div class="text-[7px] sm:text-[8px] uppercase tracking-widest opacity-40">Days</div></div>
          <div class="text-center"><div class="text-3xl sm:text-5xl font-serif-luxury text-primary">${h}</div><div class="text-[7px] sm:text-[8px] uppercase tracking-widest opacity-40">Hrs</div></div>
          <div class="text-center"><div class="text-3xl sm:text-5xl font-serif-luxury text-primary">${m}</div><div class="text-[7px] sm:text-[8px] uppercase tracking-widest opacity-40">Min</div></div>
        `;
      }, 1000);
    }

    function renderDynamic(data) {
      // Dynamic Favicon Update
      const faviconEl = document.getElementById('dynamic-favicon');
      if (faviconEl && data.favicon) {
        faviconEl.href = data.favicon;
      }

      const fullNames = `${data.bride_first_name} & ${data.groom_first_name}`;
      document.querySelectorAll('.dyn-names').forEach(el => el.textContent = fullNames);
      document.querySelectorAll('.dyn-initials').forEach(el => el.textContent = data.initials);
      document.querySelectorAll('.dyn-hashtag').forEach(el => el.textContent = data.hashtag);
      
      const dateObj = new Date(data.wedding_date);
      const formattedDate = dateObj.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }).toUpperCase();
      const tagalogDate = `Ika-${dateObj.getDate()} ng Pebrero ${dateObj.getFullYear()}`;
      
      document.querySelector('.dyn-loader-date').textContent = tagalogDate;
      document.querySelectorAll('.dyn-hero-detail').forEach(el => el.textContent = `${formattedDate} • ${data.city}`);
      
      document.querySelector('.dyn-attire-ladies').innerHTML = data.attire_ladies;
      document.querySelector('.dyn-attire-gentlemen').innerHTML = data.attire_gentlemen;
      document.querySelector('.dyn-venue-name').textContent = data.wedding_venue;
      document.querySelector('.dyn-venue-location').textContent = data.city;
      const rsvpLink = document.querySelector('.dyn-rsvp-link');
      if (rsvpLink && data.rsvp_link) rsvpLink.href = data.rsvp_link;
      const mapsLink = document.querySelector('.dyn-maps-link');
      if (mapsLink && data.maps_link) mapsLink.href = data.maps_link;
      
      const attireColorsEl = document.getElementById('attire-colors');
      if (attireColorsEl) attireColorsEl.innerHTML = data.attire_colors.map(color => `<div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full shadow-inner border-2 border-white" style="background-color: ${color}"></div>`).join('');
      
      const sponsorsP = document.getElementById('principal-sponsors');
      const sponsorsS = document.getElementById('secondary-sponsors');
      if (sponsorsP) sponsorsP.innerHTML = data.principal_sponsors.map(s => `<div class="reveal">${s}</div>`).join('');
      if (sponsorsS) {
        const entourageCards = [];
        if (data.best_man) entourageCards.push({ name: data.best_man, role: 'Best Man' });
        if (data.maid_of_honor) entourageCards.push({ name: data.maid_of_honor, role: 'Maid of Honor' });
        (data.groomsmen || []).forEach(name => entourageCards.push({ name, role: 'Groomsman' }));
        (data.bridesmaids || []).forEach(name => entourageCards.push({ name, role: 'Bridesmaid' }));
        sponsorsS.innerHTML = entourageCards.map(s => `<div class="reveal"><p class="font-bold mb-1">${s.name}</p><p class="text-[8px] uppercase tracking-widest opacity-40">${s.role}</p></div>`).join('');
      }
      
      const spotifyContainer = document.getElementById('spotify-container');
      if (spotifyContainer) spotifyContainer.innerHTML = `<iframe style="border-radius:12px" src="${data.soundtrack_link}" width="100%" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>`;
      
      const scheduleEl = document.getElementById('schedule-container');
      if (scheduleEl) scheduleEl.innerHTML = data.order_of_events.map((e, i) => `
        <div class="relative flex flex-col md:flex-row items-start reveal group py-10 ${i % 2 !== 0 ? 'md:flex-row-reverse' : ''}">
          <div class="timeline-nexus">
            <div class="nexus-outer"></div>
            <div class="nexus-inner"></div>
          </div>
          
          <div class="w-full md:w-1/2 pl-12 sm:pl-16 md:pl-0 ${i % 2 === 0 ? 'md:pr-24 md:text-right' : 'md:pl-24 md:text-left'} event-card">
            <div class="inline-flex items-center gap-3 mb-4">
               <span class="font-serif-luxury text-xs tracking-[0.4em] text-primary uppercase">${e.time}</span>
               <i class="w-1 h-1 rounded-full bg-primary/30"></i>
            </div>
            <h4 class="font-serif-luxury text-3xl sm:text-4xl md:text-5xl text-stone-900 mb-2 leading-tight group-hover:text-primary transition-colors">${e.title}</h4>
            <p class="font-serif-classic text-base sm:text-lg italic opacity-60 leading-relaxed max-w-lg ${i % 2 === 0 ? 'md:ml-auto' : ''}">${e.description}</p>
          </div>
          <div class="hidden md:block md:w-1/2"></div>
        </div>`).join('');
      
      const storyEl = document.getElementById('story-container');
      if (storyEl) {
        const storyParts = [
          { ...data.first_encounter, title: "The First Encounter", tagalog: "Ang Unang Pagkikita" },
          { ...data.proposal, title: "The Proposal", tagalog: "Ang Pag-aalok" }
        ];
        storyEl.innerHTML = storyParts.map((s, i) => {
          const firstLetter = s.content.charAt(0);
          const remainingText = s.content.slice(1);
          return `<div class="flex flex-col ${i % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse'} gap-10 sm:gap-16 items-center reveal">
            <div class="w-full md:w-1/2 flex justify-center"><div class="premium-image-wrapper"><div class="floating-frame"></div><div class="image-container aspect-[4/5]"><img src="${s.img}" class="w-full h-full object-cover transition-transform duration-[4s] hover:scale-110"></div></div></div>
            <div class="w-full md:w-1/2 text-center ${i % 2 === 0 ? 'md:text-left' : 'md:text-right'} max-w-xl">
              <span class="text-[9px] uppercase tracking-[0.6em] text-primary opacity-60 mb-3 sm:mb-4 block font-serif-luxury">${s.tagalog}</span>
              <h3 class="font-serif-luxury text-3xl sm:text-5xl text-stone-900 font-bold mb-4 sm:mb-6 leading-tight">${s.title}</h3>
              <div class="divider-ornament ${i % 2 === 0 ? 'md:justify-start' : 'md:justify-end'}"><span></span><i>✧</i><span></span></div>
              <p class="font-serif-classic text-xl sm:text-2xl italic opacity-70 leading-relaxed text-stone-700"><span class="editorial-cap">${firstLetter}</span>${remainingText}</p>
            </div></div>`}).join('');
      }
      
      const galleryEl = document.getElementById('masonry-container');
      if (galleryEl) galleryEl.innerHTML = (data.prenup_photos || []).map(photo => `<div class="masonry-item reveal"><img src="${photo.url}" loading="lazy"></div>`).join('');
      
      const registryEl = document.getElementById('registry-container');
      if (registryEl) registryEl.innerHTML = `
        <div class="p-8 sm:p-10 border border-stone-100 bg-white shadow-sm rounded-xl flex-1 hover:shadow-md transition-shadow">
          <p class="text-[9px] tracking-widest uppercase opacity-40 mb-3">${data.registry_items.method}</p>
          <p class="font-serif-luxury text-xl sm:text-2xl mb-1">${data.registry_items.accountNumber}</p>
          <p class="text-[10px] uppercase tracking-widest opacity-60">${data.registry_items.accountHolder}</p>
        </div>
        <div class="p-8 sm:p-10 border border-stone-100 bg-white shadow-sm rounded-xl flex-1 hover:shadow-md transition-shadow flex flex-col justify-center">
          <p class="text-[9px] tracking-widest uppercase opacity-40 mb-3">Registry List</p>
          <a href="${data.registry_items.link}" class="font-serif-luxury text-xl sm:text-2xl underline decoration-primary underline-offset-8">${data.registry_items.label}</a>
        </div>`;
    }

    async function initApp() { 
      renderDynamic(CONFIG); 
      initCountdown(CONFIG.wedding_date); 
      initMobileNav();
      startLoadingSequence(); 
    }
    
    initApp();
  </script>
</body>
</html>