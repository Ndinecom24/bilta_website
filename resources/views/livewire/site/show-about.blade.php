<section id="about-us" style="background-color: #f9f9f9; padding: 60px 0;">
  <div class="container" style="max-width: 1140px; margin: auto; padding: 0 15px;">
    
    <!-- Intro Section -->
    <div style="text-align: center; margin-bottom: 50px;">
      <h2 style="font-size: 2.5rem; font-weight: 700;">Who We Are</h2>
      <p style="font-size: 1.1rem; color: #555; max-width: 800px; margin: 20px auto;">
      
        The Bible and Literature Translation Association (BiLTA) is a dedicated organization empowering communities to translate the Bible and essential literature into local languages, preserving culture and promoting literacy. 
      </p>
    </div>

    <!-- Content Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px;">

      <div>
        <h4 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 10px;">🌟 Vision</h4>
        <p style="color: #666;">
         {{     $about_us_details->vision ?? "To make available the word of God and essential literature in local languages." }}
        </p>
      </div>

      <div>
        <h4 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 10px;">🎯 Mission</h4>
        <p style="color: #666;">
          {{     $about_us_details->mission ?? " To build the capacity of the local people to translate the Bible and essential literature into their heart languages for effective evangelism and discipleship. " }}
        </p>
      </div>

      <div>
        <h4 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 10px;">📌 Objective</h4>
        <ul style="color: #666; padding-left: 20px; margin: 0;">
          
          {!! $about_us_details->objective ?? '
          <li>Mobilise and build capacity of local people for Bible translation.</li>
          <li>Promote use of local languages in disseminating the word of God alongside other languages.</li>
          <li>Promote literacy and education through newsletters, books, magazines, and videos in local languages.</li>
      ' !!}
        </ul>
      </div>

      <div>
        <h4 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 10px;">📖 Description</h4>
        <p style="color: #666;">
          {{     $about_us_details->description ?? " 
          BiLTA is registered with the Registrar of Societies in Zambia as a charitable organization aimed at empowering communities to translate the word of God and other literature into their languages.
       "}}
          </p>
      </div>

      <div>
        <h4 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 10px;">❓ What Is BiLTA?</h4>
        <p style="color: #666;">
          {{     $about_us_details->what_is ?? " 
          BiLTA stands for “Bible and Literature Translation Association.” It began as Senga Bible and Literature Translation Association (SBLTA) in 2012 and was renamed BiLTA in 2021 to include broader language groups.
       
       " }}   </p>
      </div>

      <div>
        <h4 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 10px;">👥 Who We Are</h4>
        <p style="color: #666;">
          {{     $about_us_details->who_we_are ?? " 
          Established in 2019, BiLTA is a dedicated translation association committed to advancing the translation of the Bible and essential literature into local languages.
          " }}   </p>
      </div>

      <div>
        <h4 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 10px;">🚀 Action</h4>
        <p style="color: #666;">
          We mobilize communities, train translators, promote local languages, and collaborate with cultural experts to make literature accessible and meaningful in every language.
          </p>
      </div>

    </div>
  </div>
</section>

<!--  Location & Contact Section -->
<section id="location-contact" style="background-color: #f9f9f9; padding: 60px 0; border-top: 1px solid #ddd;">
  <div class="container" style="max-width: 1140px; margin: auto; padding: 0 15px;">

    <!-- Header -->
    <div style="text-align: center; margin-bottom: 50px;">
      <h2 style="font-size: 2.25rem; font-weight: 700; color: #333;">Find Us & Contact</h2>
      <p style="font-size: 1.1rem; color: #666; max-width: 700px; margin: 20px auto;">
        Get in touch with us for partnerships, translation services, or just to say hello.
      </p>
    </div>

    <!-- Content Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 40px; align-items: start;">

      <!-- Map -->
      <div style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31741.4633847497!2d28.2443!3d-15.4167!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1940b4a25d89fdd1%3A0x86f7d6a53e74b08e!2sLusaka%2C%20Zambia!5e0!3m2!1sen!2sus!4v1689964355731!5m2!1sen!2sus"
          width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
          referrerpolicy="no-referrer-when-downgrade" title="BiLTA Location Map">
        </iframe>
      </div>

      <!-- Contact Info -->
      <div style="font-size: 1rem; color: #444;">
        <h3 style="margin-bottom: 15px; font-weight: 600;">Our Address</h3>
        <p>{!! nl2br(e($contact_us_details->address ?? 'Address not provided')) !!}</p>

        <h3 style="margin: 25px 0 15px; font-weight: 600;">Contact Us</h3>
        <p>
          📞 <strong>Phone:</strong> {{ $contact_us_details->phone ?? 'N/A' }}<br>
          ✉️ <strong>Email:</strong> <a href="mailto:{{ $contact_us_details->email ?? '#' }}">{{ $contact_us_details->email ?? 'Not available' }}</a>
        </p>

        <h3 style="margin: 25px 0 15px; font-weight: 600;">Follow Us</h3>
        <p>
          🌐 <a href="{{ $contact_us_details->website ?? '#' }}" target="_blank" style="color:#0077b5;">Website</a><br>
          📱 
          <a href="{{ $contact_us_details->facebook_url ?? '#' }}" target="_blank" style="color:#3b5998;">Facebook</a> | 
          <a href="{{ $contact_us_details->twitter_url ?? '#' }}" target="_blank" style="color:#1da1f2;">Twitter</a> | 
          <a href="{{ $contact_us_details->linkedin_url ?? '#' }}" target="_blank" style="color:#0e76a8;">LinkedIn</a>
        </p>
      </div>

      <!-- Quick Links -->
      <div>
        <h3 style="font-weight: 600; margin-bottom: 20px;">Quick Links</h3>
        <a href="{{ route('gallery') }}" style="display:block; margin-bottom: 12px; background-color: #e6f0ff; color: #004080; padding: 12px; border-radius: 6px; text-align: center; text-decoration: none; font-weight: 500;">
          📸 View Our Gallery
        </a>
        <a href="{{ route('projects', '0') }}" style="display:block; margin-bottom: 12px; background-color: #e9f7ef; color: #1d643b; padding: 12px; border-radius: 6px; text-align: center; text-decoration: none; font-weight: 500;">
          📋 Explore Projects
        </a>
        <a href="{{ route('site.home') }}#contact" style="display:block; background-color: #fff3e0; color: #b35400; padding: 12px; border-radius: 6px; text-align: center; text-decoration: none; font-weight: 500;">
          ✉️ Contact Form
        </a>
      </div>

    </div>
  </div>
</section>

