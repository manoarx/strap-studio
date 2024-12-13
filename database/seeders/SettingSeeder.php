<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            ['contact_phone' => '+971501544994'],
            ['contact_mail' => 'info@strapstudios.com'],
            ['contact_address' => '1704 - ADCP Business Tower C, Electra Street, Abu Dhabi'],
            ['contact_map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3630.8478911714765!2d54.369439415353895!3d24.490726666006992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5e6609d0392dc3%3A0x5488ba3bf9fd695d!2sSTRAP%20STUDIOS!5e0!3m2!1sen!2sin!4v1678517449308!5m2!1sen!2sin'],
            ['instagram' => 'https://www.instagram.com/strapstudiosme/'],
            ['linkedin' => 'https://www.linkedin.com/company/strapstudios/'],
            ['about_our_approach' => 'We believe that everyone has a unique and beautiful story to tell, and our goal is to capture those  stories in a way that is both natural and visually striking. We believe in capturing real emotion, real connection and real beauty. We\'re not just interested in making great photos but also in creating  an experience that makes you feel comfortable and empowered.'],
            ['about_our_experience' => 'We\'ve been in the photography business for more than 15 years, and have developed a keen eye for capturing special moments and unique perspectives. We have been trained in various photography techniques and technologies.'],
            ['about_portfolio' => 'Check out our portfolio to see some examples of our work. We have a diverse collection of images that showcase our skills, including portraits, family photos, and lifestyle shots.'],
            ['registration_form_email' => NULL],
            ['contact_form_email' => 'info@strapstudios.com'],
            ['workshop_header_title' => 'Workshops'],
            ['workshop_header_description' => 'Photography courses are a great way for individuals to learn or improve their photography skills. Whether you are a beginner or an experienced photographer, there are courses available to suit your needs. With a focus on techniques such as camera operation, lighting, composition, and post-processing, photography courses will help individuals capture stunning photographs in any setting.'],
            ['about_studio_rental' => 'Our Studio Rental package is the perfect solution for photographers, videographers, and other visual artists looking for a professional space to create their next project. Our studio is fully equipped with equipment and amenities, providing you with everything you need to bring your vision to life. Our studio rental package includes the use of our spacious and well-lit shooting area, which is perfect for photography and videography projects of all types. The studio features a range of backgrounds, including solid colors, as well as a variety of lighting options to suit your needs. The studio also has a makeup and hair area, a comfortable waiting area, and a kitchenette. We also provide studio equipment s, lighting equipment, and other accessories, all included in the package price. This saves you the time, money and hassle of having to rent or transport your own equipment. Our studio rental package is flexible, allowing you to rent the space by the hour, half-day or full-day, depending on your project\'s needs. We also offer discounted rates for multiple days or extended rentals, making it easy and affordable for you to work on larger projects. Additionally, our studio rental package is ideal for workshops, photography classes, and other events, as the space can be easily configured to accommodate up to 20 attendees. Book our Studio Rental package and experience the convenience and flexibility of having a professional space to create your next project. With our package, you can focus on your creativity without worrying about the logistics of finding a suitable location and equipment.'],
            ['shop_open' => '09:00'],
            ['shop_close' => '17:00'],
            ['shop_days' => 'Monday - Friday'],
            ['shop_address' => '1704 - ADCP Business Tower C, Electra Street, Abu Dhabi'],
            ['shop_phone' => '+971501544994'],
            ['shop_email' => ''],
            ['title' => 'Professional Photography Studio, Abu dhabi'],
            ['description' => 'Professional Photography Studio specializing in business portraits, event photography, and video production in Abu Dhabi.'],
            ['keyword' => 'Professional Photography Studio, Abu dhabi'],
            ['ogimage' => 'https://www.strapstudios.com/frontend/assets/images/strap_studio_logo.png'],
            ['twitter' => '@StrapStudios'],
            ['facebook' => 'https://www.facebook.com/StrapStudios'],
            ['instagram' => 'https://www.instagram.com/strapstudiosme'],
            ['linkedin' => 'https://www.linkedin.com/company/strapstudios'],
            ['x' => 'https://www.x.com/StrapStudios'],
            ['ratingValue' => '4.7'],
            ['reviewCount' => '25'],
            ['bestRating' => '5'],
            ['reviewRating' => '5'],
            ['author' => 'Tarik Manoar'],
            ['reviewBody' => 'Excellent service! The photos were professional and exceeded expectations.'],
            ['serviceType' => 'Business Portrait Photography, Event Photography, Video Production'],
        ];

        foreach ($settings as $setting) {
            setting($setting)->save();
        }
    }
}
