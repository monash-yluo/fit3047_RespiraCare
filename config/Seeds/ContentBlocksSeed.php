<?php

declare(strict_types=1);

use Migrations\BaseSeed;

class ContentBlocksSeed extends BaseSeed
{
    public function run(): void
    {
        $data = [
            [
                'parent' => 'global',
                'label' => 'Website Title',
                'description' => 'Shown on the home page, as well as any tabs in the users browser.',
                'slug' => 'website-title',
                'type' => 'text',
                'value' => 'RespiraCare',
            ],
            [
                'parent' => 'global',
                'label' => 'Logo',
                'description' => 'Shown in the centre of the home page, and also in the top corner of all administration pages.',
                'slug' => 'logo',
                'type' => 'image',
            ],
            [
                'parent' => 'home-hero',
                'label' => 'Home Page Hero Title',
                'description' => 'The main content shown in the centre of the home page.',
                'slug' => 'home-hero-title',
                'type' => 'html',
                'value' => '<h1 class="fs-2 mb-3">Your Dedicated Partner in <br><span>COPD Management</span></h1>',
            ],
            [
                'parent' => 'home-hero',
                'label' => 'Home Page Hero Description',
                'description' => 'A brief description for the home page hero section.',
                'slug' => 'home-hero-description',
                'type' => 'text',
                'value' => 'Log your daily vitals, receive personalised reminders, 
                and get expert respiratory support exactly when you need it.'
            ],
            [
                'parent' => 'home-process',
                'label' => 'Process Section Title',
                'description' => 'Section heading shown above the COPD management steps.',
                'slug' => 'home-process-title',
                'type' => 'text',
                'value' => 'Simple, Remote COPD Management',
            ],
            [
                'parent' => 'home-process',
                'label' => 'Process Step Titles',
                'description' => 'Pipe-delimited titles for COPD process steps.',
                'slug' => 'home-process-step-titles',
                'type' => 'text',
                'value' => 'Log Daily Vitals:|Track Symptoms:|Receive Expert Care:',
            ],
            [
                'parent' => 'home-process',
                'label' => 'Process Step Descriptions',
                'description' => 'Pipe-delimited descriptions for COPD process steps.',
                'slug' => 'home-process-step-descriptions',
                'type' => 'text',
                'value' => 'Easily record your oxygen saturation (SpO2), blood pressure, and respiratory rate from the comfort of home.|Confidentially update your physician on coughing, wheezing, or shortness of breath via our secure portal.|Get personalised feedback, proactive treatment adjustments, and continuous monitoring.',
            ],
            [
                'parent' => 'home-feature',
                'label' => 'Feature Details Section',
                'description' => 'HTML content for the feature details section including title and paragraphs.',
                'slug' => 'home-feature-details',
                'type' => 'html',
                'value' => '<h3 class="fw-bold mb-4">Empowering Your Respiratory Health</h3><p>Managing Chronic Obstructive Pulmonary Disease shouldn\'t require constant hospital visits. RespiraCare brings the clinic to your living room.</p><p>Our intuitive platform allows you to securely input your daily health data, providing your specialised care team with the real-time insights they need to monitor your condition.</p><p>With automated reminders, we are dedicated to helping you stay proactive about your lung health and preventing flare-ups before they happen.</p>',
            ],
            [
                'parent' => 'home-doctors',
                'label' => 'Doctors Section Header',
                'description' => 'HTML content for the doctors section header including title and description.',
                'slug' => 'home-doctors-header',
                'type' => 'html',
                'value' => '<h2 class="text-white fw-bold mb-3">Meet Our Certified Specialists</h2><p class="text-white-50 col-lg-8 mb-0">Our dedicated team of certified physicians and pulmonologists specialise in advanced COPD management, ensuring you receive the highest standard of virtual respiratory care.</p>',
            ],
            [
                'parent' => 'home-doctors',
                'label' => 'Doctor 1 Name',
                'description' => 'Name of the first specialist doctor.',
                'slug' => 'doctor-name-1',
                'type' => 'text',
                'value' => 'Dr. Alice Smith',
            ],
            [
                'parent' => 'home-doctors',
                'label' => 'Doctor 1 Description',
                'description' => 'Description of the first specialist doctor.',
                'slug' => 'doctor-description-1',
                'type' => 'text',
                'value' => 'Specializing in chronic lung disease and proactive remote patient monitoring.',
            ],
            [
                'parent' => 'home-doctors',
                'label' => 'Doctor 2 Name',
                'description' => 'Name of the second specialist doctor.',
                'slug' => 'doctor-name-2',
                'type' => 'text',
                'value' => 'Dr. Emily Rostova',
            ],
            [
                'parent' => 'home-doctors',
                'label' => 'Doctor 2 Description',
                'description' => 'Description of the second specialist doctor.',
                'slug' => 'doctor-description-2',
                'type' => 'text',
                'value' => 'Dedicated to improving patient outcomes through continuous virtual care.',
            ],
            [
                'parent' => 'home-doctors',
                'label' => 'Doctor 3 Name',
                'description' => 'Name of the third specialist doctor.',
                'slug' => 'doctor-name-3',
                'type' => 'text',
                'value' => 'Dr. Marcus Thompson',
            ],
            [
                'parent' => 'home-doctors',
                'label' => 'Doctor 3 Description',
                'description' => 'Description of the third specialist doctor.',
                'slug' => 'doctor-description-3',
                'type' => 'text',
                'value' => 'Passionate about advancing respiratory care through innovative virtual solutions.',
            ],
            [
                'parent' => 'home-doctors',
                'label' => 'Doctor 1 Image',
                'description' => 'Profile image of the first specialist doctor.',
                'slug' => 'doctor-image-1',
                'type' => 'image',
            ],
            [
                'parent' => 'home-doctors',
                'label' => 'Doctor 2 Image',
                'description' => 'Profile image of the second specialist doctor.',
                'slug' => 'doctor-image-2',
                'type' => 'image',
            ],
            [
                'parent' => 'home-doctors',
                'label' => 'Doctor 3 Image',
                'description' => 'Profile image of the third specialist doctor.',
                'slug' => 'doctor-image-3',
                'type' => 'image',
            ],
            [
                'parent' => 'home-doctors',
                'label' => 'Doctors CTA Section Text',
                'description' => 'Call-to-action text for the doctors section.',
                'slug' => 'home-doctors-cta-text',
                'type' => 'text',
                'value' => 'Ready to take control of your COPD? Reach out to our team to learn more about how the RespiraCare platform can support your daily health journey. Whether you need help setting up your remote vitals monitoring, or have questions about connecting with our certified specialists, we are here to help.',
            ],
            
        ];

        $table = $this->table('content_blocks');
        $table->insert($data)->save();
    }
}
